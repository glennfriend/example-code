<?php

namespace Modules\Account\AttributeCastors;

use InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Modules\Account\ValueObjects\AccountConfig;
use Modules\Account\Entities\Account;

class AccountConfigCastor implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Account $model
     * @param mixed $value
     */
    public function get($model, string $key, $value, array $attributes): AccountConfiguration
    {
        $data = json_decode((string) data_get($attributes, 'config') ?? '{}', true);

        return new AccountConfig($data);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Account $model
     * @param AccountConfiguration $value
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if (!$value instanceof AccountConfiguration) {
            throw new InvalidArgumentException('The given value is not an `' . get_class($this) . '` instance.');
        }

        return [
            'config' => json_encode($value->toArray()),
        ];
    }
}
