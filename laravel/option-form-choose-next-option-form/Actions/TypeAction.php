<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions;

use Exception;
use Modules\Expander\Services\Actions\Structs\ExpandGenericParentAction as ParentAction;

class TypeAction extends ParentAction
{
    public const DESCRIPTION = 'choose type';

    // 這裡的 geo 並不是單指 geo type, 而是以 geo 為主的 expand 流程之意
    public const GEO = 'geo';

    protected function check(): bool
    {
        if (!$this->dto->type) {
            throw new Exception('type not found');
        }

        return true;
    }
}
