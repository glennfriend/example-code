<?php

namespace Modules\Contact\UseCases;

use Carbon\Carbon;
use Generator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Account\Repositories\AccountRepository;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Repositories\ContactRepository;
use OnrampLab\CleanArchitecture\UseCase;
use OnrampLab\SecurityModel\Builders\ModelBuilder;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * @method static Contact perform(mixed $args)
 */
class MigrateContactTimeZoneUseCase extends UseCase
{
    private AccountRepository $accountRepository;
    private ContactRepository $contactRepository;
    private MigrateContactTimeZoneCounter $counter;

    public bool $dryRun = false;
    public string $logName;
    public Carbon $startDate;
    public Carbon $endDate;

    public function handle(
        AccountRepository $accountRepository,
        ContactRepository $contactRepository,
    ): void
    {
        $this->accountRepository = $accountRepository;
        $this->contactRepository = $contactRepository;
        $this->counter = new MigrateContactTimeZoneCounter();

        $this->migrationTimezone();
    }

    private function migrationTimezone(): void
    {
        $this->accountRepository->getAllEnabledAccounts()->each(function ($account) {
            /**
             * @var Contact $contact
             */
            foreach ($this->queryScopeContact($this->startDate, $this->endDate, $account->id) as $contact) {
                $currentContactTimezone = $contact->time_zone;
                $contact->time_zone = '';
                $contact->save();

                $payload = [
                    'time_zone' => null,
                ];
                $updatedContact = UpdateContactUseCase::perform([
                    'accountId'  => $account->id,
                    'contactId'  => $contact->id,
                    'attributes' => $payload,
                ]);

                $this->message('migration time zone.', [
                    'contact_id' => $contact->id,
                    'contact_timezone_before' => $currentContactTimezone,
                    'contact_timezone_after' => $updatedContact->time_zone,
                    'account_id' => $account->id,
                ]);
                ++$this->counter->numberContactsAffected;
            }
        });

        $this->message('migration time zone finished', $this->counter->toArray());
    }

    private function queryScopeContact(Carbon $startDate, Carbon $endDate, int $accountId): Generator
    {
        $from = $startDate->copy();

        while ($from < $endDate) {
            $to = $from->copy()->addHour();
            if ($to > $endDate) {
                $to = $endDate;
            }

            foreach ($this->queryContactIds($from, $to, $accountId) as $contactInfos) {
                $contactIds = array_column($contactInfos->toArray(), 'id');
                if (!$contactIds) {
                    continue;
                }

                foreach ($this->contactRepository->findOnesByIds($contactIds) as $contact) {
                    yield $contact;
                }
            }
            $from = $to;
        }
    }

    private function queryContactIds(Carbon $fromDate, Carbon $toDate, int $accountId): Generator
    {
        $limit = 500;
        $startId = 0;
        $startDateFormat = $fromDate->toIso8601String();

        while (true) {
            /**
             * @var ModelBuilder $builder
             */
            // @phpstan-ignore-next-line
            $builder = $this->contactRepository
                ->where('id', '>', $startId)
                ->where('account_id', '=', $accountId)
                ->where('is_opt_out', '<>', 1)
                ->whereBetween('created_at', [$startDateFormat, $toDate->toIso8601String()])
                ->limit($limit);

            /**
             * @var Collection<Contact> $collection
             */
            $collection = $builder->get();
            $this->counter->numberContactsFind += $collection->count();

            yield $collection;
            if ($collection->count() < $limit) {
                break;
            }

            // NOTE: id is must, other is performance
            $startId = $collection->last()->id;
            $startDateFormat = Carbon::parse($collection->last()->created_at)->toIso8601String();
        }
    }

    protected function message(string $message, array $options = []): void
    {
        if (app()->runningInConsole()) {
            $this->consoleMessage($message, $options);

            return;
        }

        if ($this->isDryRun()) {
            $message .= ' (dry run)';
        }
        Log::info($message, $options);
    }

    /**
     * Description
     *      - $signature support --dryRun yes or not
     *      - $options auto append status
     *      - append single log
     *      - show console message
     */
    private function consoleMessage(string $message, array $options = []): void
    {
        if ($this->isDryRun()) {
            $message .= ' (dry run)';
        }
        Log::info($message, array_merge(['status' => $this->getLogName()], $options));

        if ($options) {
            $message .= "\n" . json_encode($options, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        echo $message . "\n";

        $this->storageFileLog($message);
    }

    private function isDryRun(): bool
    {
        return $this->dryRun ?? false;
    }

    private function storageFileLog(string $message): void
    {
        static $firstMessage = true;

        $logFile = $this->getMakeLogPath();
        if (! $firstMessage) {
            file_put_contents($logFile, $message . "\n", FILE_APPEND);
        } else {
            file_put_contents($logFile, $message . "\n");
            $firstMessage = false;
        }
    }

    private function getLogName(): string
    {
        return $this->logName ?? 'temp';
    }

    private function getMakeLogPath(): string
    {
        return app()->storagePath() . '/' . $this->getLogName() . '.log';
    }
}

#[MapName(SnakeCaseMapper::class)]
class MigrateContactTimeZoneCounter extends Data
{
    public int $numberContactsFind = 0;
    public int $numberContactsAffected = 0;
}
