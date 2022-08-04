<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions;

use Exception;
use Modules\Expander\Services\Actions\Structs\ExpandGenericParentAction as ParentAction;

class LevelAction extends ParentAction
{
    public const DESCRIPTION = 'choose level';
    public const CAMPAIGN = 'campaign';
    public const AD_GROUP = 'ad_group';

    public function childrenActions(): array
    {
        return [
            SeedsAction::class,
        ];
    }

    protected function check(): bool
    {
        $scope = [
            self::CAMPAIGN,
            self::AD_GROUP,
        ];
        if (!in_array($this->dto->level, $scope)) {
            throw new Exception('level not found');
        }

        return true;
    }

    protected function main()
    {
        $nextClass = app($this->childrenActions()[0]);
        $nextClass->require($this->dto);
    }
}
