<?php

namespace Modules\Core\Exceptions;

use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Exceptions\DomainException;
use Throwable;

/**
 * 取得外部的 response (e.g. from External API), 得到非預期的資料
 * Error 422
 */
class SuspectedIncorrectDataException extends DomainException
{
    public function __construct(object $object, array $context = [], Throwable $previous = null)
    {
        parent:: __construct(
            $this->getTitle() . ': ' . $object::class,
            $context,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $previous
        );
    }

    public function getTitle(): string
    {
        return 'Suspected incorrect data';
    }
}
