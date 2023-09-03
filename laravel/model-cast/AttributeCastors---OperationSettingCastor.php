<?php

namespace Modules\Account\AttributeCastors;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;
use Modules\Account\Entities\Account;
use Modules\Account\ValueObjects\OperationSetting;

class OperationSettingCastor implements CastsAttributes
{
    private const FIELD_NAME = 'operation_setting';

    /**
     * @param Account $model
     */
    public function get($model, string $key, mixed $value, array $attributes): OperationSetting
    {
        $data = json_decode((string) data_get($attributes, self::FIELD_NAME) ?? '{}', true);
        return OperationSetting::create((array) $data);
    }

    /**
     * @param Account $model
     */
    public function set($model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof OperationSetting) {
            throw new InvalidArgumentException('The given value is not an `' . get_class($this) . '` instance.');
        }
        return [
            self::FIELD_NAME => json_encode($value->toArray()),
        ];
    }
}
