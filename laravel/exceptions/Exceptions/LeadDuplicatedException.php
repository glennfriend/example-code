<?php

declare(strict_types=1);

namespace Modules\HelloWorld\Exceptions\DomainExceptions;

use Illuminate\Http\Response;
use OnrampLab\CleanArchitecture\Exceptions\DomainException;
use Throwable;

// by Fish
// 其它參考: ContactDuplicatedException by Eric
// 其它參考: NoAvailableBusinessHourException by Eric
class LeadDuplicatedException extends DomainException
{
    public function __construct(
        string $message,
        array $context = [],
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $context, Response::HTTP_CONFLICT, $previous);
    }
    public function getTitle(): string
    {
        return 'Lead Already Exists!';
    }
}
