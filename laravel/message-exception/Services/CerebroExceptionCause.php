<?php

declare(strict_types=1);

namespace Modules\Cerebro\Services;

use Exception;

class CerebroExceptionCause
{
    private static Exception $exception;

    public static function exception(Exception $exception): CerebroExceptionCause
    {
        static::$exception = $exception;
        return new static();
    }

    public static function isEmptyPhoneNumbers(): bool
    {
        if ('400' === (string)static::$exception->getCode()
            && preg_match('/Items is empty/is', static::$exception->getMessage())
        ) {
            return true;
        }
        return false;
    }

    public static function isBuyPhoneNumberFail(): bool
    {
        if ('400' === (string)static::$exception->getCode()
            && preg_match('/failed purchase \(phonenumber/is', static::$exception->getMessage())
        ) {
            return true;
        }
        return false;
    }

}
