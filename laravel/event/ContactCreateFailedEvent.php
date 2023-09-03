<?php

namespace Modules\Contact\Events;

use Carbon\Carbon;

class ContactCreateFailedEvent
{
    public array $data;
    public int $accountId;
    public string $errorMessage;
    public Carbon $timestamp;

    public function __construct(array $data, int $accountId, string $errorMessage)
    {
        $this->data = $data;
        $this->accountId = $accountId;
        $this->errorMessage = $errorMessage;
        $this->timestamp = now();
    }
}
