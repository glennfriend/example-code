<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions\Contracts;

use Modules\Expander\Services\Actions\Contracts;

interface ShouldAction
{
    // public function require(ActionDataTransferObjects $dto);

    // actionKeypublic function actionKey(): string;

    public function childrenActions(): array;

    public function config(): array;
}
