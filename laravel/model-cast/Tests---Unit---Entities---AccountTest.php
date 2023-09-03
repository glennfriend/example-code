<?php

namespace Modules\Account\Tests\Unit\Entities;

use Tests\TestCase;
use Modules\Account\ValueObjects\AccountConfig;
use Modules\Account\Entities\Account;

class AccountTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->account = Account::factory()->create();
    }

    /**
     * @test
     */
    public function config_casts_should_work(): void
    {
        $this->account->config = new AccountConfig([
            'type' => 'abc',
            'other' => [
                'enabled' => true,
            ],
        ]);
        $this->account->save();

        $this->assertEquals($this->account->config->type, 'abc');
    }
}
