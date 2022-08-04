<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions;

use Modules\Expander\Services\Actions\Structs\ExpandGenericParentAction as ParentAction;

class EnterAction extends ParentAction
{
    public const DESCRIPTION = '';

    public function childrenActions(): array
    {
        return [
            TypeAction::class,
            LevelAction::class,
        ];
    }
}
