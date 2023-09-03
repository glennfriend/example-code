<?php

namespace Modules\AppIntegration\Listeners;

use Exception;
use Illuminate\Support\LazyCollection;
use Log;
use Modules\Contact\Entities\Contact;

class HappyService
{

    public function __construct(private readonly HappyRepository $happyRepository)
    {
    }

    public function handle(): void
    {
        $this->getHappys($contact)->each(function ($appIntegration) use ($contact) {
            if (!$appIntegration instanceof Leadable) {
                return;
            }

            try {
                $appIntegration->syncLead($contact);
            } catch (Exception $exception) {
                Log::warning('xxxx failed', [
                    'message' => $exception->getMessage(),
                    'id'      => $contact->id,
                ]);
                // continue
                return;
            }
        });
    }

    private function getHappys(Contact $contact): LazyCollection
    {
        // @phpstan-ignore-next-line
        return $this->happyRepository->findAppIntegrationsByAccountId($contact->account_id);
    }
}
