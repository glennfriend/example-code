<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions\Contracts;

interface ActionParam
{
    public function __construct(array $data = []);

    public function validate();
}
