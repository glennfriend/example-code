<?php

declare(strict_types=1);

namespace Modules\HelloWorld\Exceptions;

use Exception;
use Throwable;

class HelloWorldBuyFailException extends Exception
{
    public function __construct(string $message = null, int $code = 400, Throwable $previous = null)
    {
        if (!$message) {
            $message = '[HelloWorld] buy phone number fail';
        }
        parent::__construct($message, $code, $previous);
    }
}
