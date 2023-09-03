<?php

namespace Modules\AppIntegration\Services;

use Modules\AppIntegration\Entities\ContactLead;
use Modules\AppIntegration\Repositories\ContactLeadRepository;

class GetContactLeadService
{
    public function __construct(private readonly ContactLeadRepository $contactLeadRepository)
    {
    }

    public function perform(int $contactId, int $appIntegrationId): ?ContactLead
    {
        return $this->contactLeadRepository->getByContactIdAndAppIntegrationId($contactId, $appIntegrationId);
    }
}
