<?php

namespace Modules\Contact\Exceptions;

use Modules\Contact\Entities\Contact;
use OnrampLab\CleanArchitecture\Exceptions\DomainException;

class SyncLeadException extends DomainException
{
    protected string $title = 'Sync lead error';

    public function __construct(Contact $contact)
    {
        parent::__construct($this->title, $this->getContext($contact));
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    private function getContext(...$objects): array
    {
        $content = [];
        foreach ($objects as $instance) {
            if ($instance instanceof Contact) {
                $content['contact_id'] = $instance->id;
            };
        }

        return $content;
    }
}
