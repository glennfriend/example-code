<?php

namespace Modules\AppIntegration\Tests\Unit\Services;

use Modules\Account\Entities\Account;
use Modules\AppIntegration\Entities\AvaAppIntegration;
use Modules\AppIntegration\Entities\ContactLead;
use Modules\AppIntegration\Repositories\ContactLeadRepository;
use Modules\AppIntegration\Services\GetContactLeadService;
use Modules\Contact\Entities\Contact;
use Tests\TestCase;

class GetContactLeadServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
        $this->avaAppIntegration = AvaAppIntegration::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->contact = Contact::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->contactLead = ContactLead::factory()->create([
            'contact_id' => $this->contact->id,
            'app_integration_id' => $this->avaAppIntegration->id,
        ]);

        $this->repository = app(ContactLeadRepository::class);
        $this->service = app(GetContactLeadService::class);
    }

    /**
     * @test perform()
     */
    public function perform_should_work()
    {
        $contactLead = $this->service->perform($this->contact->id, $this->avaAppIntegration->id);

        $this->assertSame($this->contactLead->id, $contactLead->id);
        $this->assertSame($this->contactLead->contact_id, $contactLead->contact_id);
        $this->assertSame($this->contactLead->app_integration_id, $contactLead->app_integration_id);
    }
}
