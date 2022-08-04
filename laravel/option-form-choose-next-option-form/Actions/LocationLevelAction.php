<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions;

use Exception;
use Modules\Expander\Services\Actions\Structs\ExpandGenericParentAction as ParentAction;

class LocationLevelAction extends ParentAction
{
    public const DESCRIPTION = 'choose location level';
    public const STATE = 'state';
    public const CITY = 'city';
    public const ZIP = 'zip';

    public function childrenActions(): array
    {
        return [];
    }

    protected function check(): bool
    {
        if (TypeAction::GEO !== $this->dto->type) {
            return false;
        }

        $scope = [
            self::STATE,
            self::CITY,
            self::ZIP,
        ];
        if (!in_array($this->dto->locationLevel, $scope)) {
            throw new Exception('location level not found');
        }

        return true;
    }

    protected function main()
    {
    }
}
