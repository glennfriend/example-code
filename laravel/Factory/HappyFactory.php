<?php

declare(strict_types=1);

namespace Modules\Contact\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Account\Entities\Account;
use Modules\AppIntegration\Entities\AvaAppIntegration;
use Modules\Contact\Entities\Contact;

class HappyFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Happy::factory()->withOptIn()->create();
     */
    public function withOptIn(): Factory
    {
        return $this->state([
            'is_opt_out' => false,
            'do_not_email' => false,
        ]);
    }

    /**
     * Happy::factory()->withAccount($this->contact->account)->create();
     */
    public function withAccount(Account $account): static  // self
    {
        return $this->state(function (array $attributes) use ($account) {
            return array_merge(
                $attributes,
                ['account_id' => $account->id],
            );
        });
    }

    /**
     * 應該有更好的寫法
     * Happy::factory()->withAvaAppIntegration(2)->create();
     */
    public function withAvaAppIntegration(int $count = 1): static  // Factory
    {
        $account = Account::factory()->create([
            'id' => 1,
        ]);
        AvaAppIntegration::factory()->count($count)->create([
            'account_id' => $account->id,
            'config' => [
                'api_key' => 'ava_api_key',
            ],
        ]);

        return $this->for($account);
    }
}
