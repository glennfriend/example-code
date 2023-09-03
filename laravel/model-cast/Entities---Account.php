<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\AttributeCastors\AccountConfigCastor;
use Modules\Account\Database\Factories\AccountFactory;
use Modules\Account\ValueObjects\AccountConfig;

/**
 * @property AccountConfig $config
 */
class Account extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'config',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'config' => AccountConfigCastor::class,
        /*
        'type' => TypeEnum::class,
        'is_qualified' => 'boolean',
        'country_code_qualified' => 'boolean',
        'areacode_qualified' => 'boolean',
        */
    ];

    protected static function newFactory(): Factory
    {
        return AccountFactory::new();
    }
}
