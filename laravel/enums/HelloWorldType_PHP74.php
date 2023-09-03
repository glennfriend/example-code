<?php

namespace Modules\______\Enums;

use Ydin\ThirdParty\Laravel\Enums\Concerns\Enumerable;

class HelloWorldType
{
    use Enumerable;

    public const ENABLED    = 1;
    public const DISABLED   = 0;

    public const GOOGLE     = 'google';
    public const FACEBOOK   = 'facebook';

    private static array $valueToName = [
        self::ENABLED   => 'enabled',
        self::DISABLED  => 'disabled',

        self::GOOGLE    => 'Google',
        self::FACEBOOK  => 'Facebook',
    ];
}
