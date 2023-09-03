<?php

namespace Modules\Account\ValueObjects;

use Illuminate\Support\Collection;
use JsonSerializable;

class AccountConfiguration implements JsonSerializable
{
    public const TYPE_CAT = 'cat';
    public const TYPE_Dog = 'dog';

    /**
     * @var String
     */
    public $type;

    /**
     * @var Collection<OtherValueObject>
     */
    public $other;

    /**
     * create AccountConfiguration object
     */
    public function __construct(?array $attributes)
    {
        $this->type = data_get($attributes, 'type', self::TYPE_CAT);
        $this->other = collect(data_get($attributes, 'OtherValueObject', []))
            ->map(function (array $data) {
                return new OtherValueObject($data);
            });
    }

    public function toArray(): array
    {
        return [
            'type'  => $this->type,
            'other' => $this->other->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
