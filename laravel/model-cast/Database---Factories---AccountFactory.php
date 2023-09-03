<?php

namespace Modules\Account\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Account\ValueObjects\AccountConfig;
use Modules\Account\Entities\Account;

class AccountFactory extends Factory
{

    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->lexify('?????'),
            'signature' => $this->faker->text(),
            'address' => $this->faker->streetAddress(),
            'parent_id' => $this->faker->randomDigit(),
            'config' => new AccountConfig([
                'type' => 'abc',
                'other' => [],
            ]),
        ];
    }

}
