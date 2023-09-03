<?php

namespace Modules\Contact\Console;

use Carbon\Carbon;
use Exception;
use Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Log;
use Modules\Account\Entities\Account;
use Modules\Account\Repositories\AccountRepository;
use Modules\AppIntegration\Entities\AvaAppIntegration;
use Modules\AppIntegration\Repositories\AvaAppIntegrationRepository;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Repositories\ContactRepository;
use OnrampLab\SecurityModel\Builders\ModelBuilder;  // use Illuminate\Database\Query\Builder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateContactCustomToAVA extends Command
{
    /**
     * @var string
     */
    protected $signature = 'contact:migrate-contact-custom-to-ava
                                {startDate      : 開始時間 "2023-01-01"}
                                {endDate        : 結束時間 "2023-01-01"}
                                {--accountIds=  : 限制範圍 "1,5,10"}
                                {--dryRun}';

    /**
     * @var string
     */
    protected $description = 'Migrate contact custom data to AVA';

    private Carbon $startDate;
    private Carbon $endDate;
    private int $affectedNumber = 0;

    public function __construct(
        readonly private AvaAppIntegrationRepository $avaAppIntegrationRepository,
    )
    {
        ini_set('memory_limit', '512M');
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        $this->preprocessing();

        foreach ($this->queryContactsByHour($this->startDate, $this->endDate) as $contacts) {
            $contacts->each(function (Contact $contact) {
                $this->line("-> contact_id={$contact->id}, create={$contact->created_at->toIso8601String()}");

                try {
                    $this->getAvaAppIntegrations($contact)->each(function (AvaAppIntegration $avaAppIntegration) use ($contact) {
                        $avaLead = $avaAppIntegration->getLead($contact->phone);
                        if (!$avaLead) {
                            return;
                        }

                        $message = "update lead_id={$avaLead->id} ";
                        if ($this->isDryRun()) {
                            $this->line("dry run: " . $message);
                        } else {
                            $this->line($message);

                            $customData = $contact->custom;
                            if (!$customData) {
                                // 如果什麼資料都沒有, 那麼不需要做任何事
                                return;
                            }
                            $avaAppIntegration->updateLead($avaLead->id, $avaLead->accountId, [], $customData);

                            $this->affectedNumber++;
                            Log::info('contact custom update done', [
                                'contact_id'         => $contact->id,
                                'contact_created_at' => $contact->created_at->toIso8601String(),
                            ]);
                        }
                    });

                } catch (\Throwable $exception) {
                    $errorMessages = [
                        'contact_id'         => $contact->id,
                        'contact_created_at' => $contact->created_at->toIso8601String(),
                        'error'              => $exception->getMessage(),
                    ];
                    Log::warning('contact custom update failed', $info);
                    $this->error("contact custom update failed: " . print_r($info, true));

                    // don't throw exception, update next, continue ...
                    return;
                }

            });
        }

        $this->info('migration finished');
        $this->info('total number affected: ' . $this->affectedNumber);
        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function preprocessing(): void
    {
        // @phpstan-ignore-next-line
        $this->startDate = Carbon::parse($this->argument('startDate'));
        // @phpstan-ignore-next-line
        $this->endDate = Carbon::parse($this->argument('endDate'))->addDay();

        $this->info(<<<EOD
start sync now.

date >= {$this->startDate->toIso8601String()}
and  <  {$this->endDate->toIso8601String()}

EOD
        );

        if ($this->isDryRun()) {
            $this->info('is Dry-Run mode');
        }
        elseif (!$this->confirm('Execute it ')) {
            $this->line('Do not execute !');
            exit;
        }
    }

    private function isDryRun(): bool
    {
        return (boolean) $this->option('dryRun');
    }

    private function queryContactsByHour(Carbon $startDate, Carbon $endDate): Generator
    {
        $from = $startDate->copy();

        while ($from < $endDate) {
            $to = $from->copy()->addHour();  // TODO: bug, 沒有檢查小於規定的日期
            foreach ($this->queryContacts($from, $to) as $contacts) {
                yield $contacts;
            }
            $from = $to;
        }
    }

    /**
     * @throws Exception
     */
    private function queryContacts(Carbon $fromDate, Carbon $toDate): Generator
    {
        $limit = 500;
        $startId = 0;
        $startDate = $fromDate->toIso8601String();

        /**
         * @var ContactRepository $contactRepository
         */
        $contactRepository = app(ContactRepository::class);
        //$attempt = 0;

        do {
            //if (++$attempt > 1000) {
            //    throw new Exception('try too many times');
            //}

            // Eddie: sort by id 是多餘的, 吃到什麼 index, 就會用它的方式做排序

            /**
             * @var ModelBuilder $builder
             */
            $builder = $contactRepository
                ->where('id', '>', $startId)
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<', $toDate->toIso8601String())
                ->limit($limit)
                ->orderBy('id', 'ASC');

            if ($this->isDryRun()) {
                $this->info(vsprintf(str_replace('?', "'%s'", $builder->toSql()), $builder->getBindings()));
            }

            // NOTE: 如果使用 lazy, 會忽略 offset, limit, 在這個情況下不適用
            $collection = $builder->get();
            //if ($collection->count() === 0) {
            //    break;
            //}
            yield $collection;
            if ($collection->count() < $limit) {
                break;
            }

            // NOTE: id is must, other is performance
            // @phpstan-ignore-next-line
            $startId = $collection->last()->id;
            $startDate = Carbon::parse($collection->last()->created_at)->toIso8601String();

        } while ($collection->count() < 0);
    }

    private function getAvaAppIntegrations(Contact $contact): Collection
    {
        return $this->avaAppIntegrationRepository->findByField('account_id', $contact->account->id);
    }
}

/*

// TODO: 請加到 XxxxxxServiceProvider
public function registerCommands(): void
{
    $this->commands([
        \Modules\Contact\Console\MigrateContactCustomToAVA::class,
    ]);
}

*/
