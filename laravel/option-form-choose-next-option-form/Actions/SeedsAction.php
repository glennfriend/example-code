<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions;

use Exception;
use Modules\Expander\Services\Actions\Structs\ExpandGenericParentAction as ParentAction;

class SeedsAction extends ParentAction
{
    public const DESCRIPTION = 'choose campaign ids, adGroup ids';

    public function childrenActions(): array
    {
        return [
            //Action1::class,
            //Action2::class,
        ];
    }

    protected function check(): bool
    {
        if ($this->dto->level === LevelAction::CAMPAIGN) {
            if (!$this->dto->seedCampaignIds) {
                throw new Exception('seedCampaignIds not found');
            }
        } elseif ($this->dto->level === LevelAction::AD_GROUP) {
            if (!$this->dto->seedCampaignIds) {
                throw new Exception('seedCampaignIds not found');
            }
            if (1 !== count($this->dto->seedCampaignIds)) {
                throw new Exception('type not match seedCampaignIds');
            }
            if (!$this->dto->seedAdGroupIds) {
                throw new Exception('seedAdGroupIds not found');
            }
        } else {
            throw new Exception('type not match seedCampaignIds or seedAdGroupIds');
        }

        return true;
    }

    protected function main()
    {
        if ($this->dto->level === LevelAction::CAMPAIGN) {
            //
        }
        elseif ($this->dto->level === LevelAction::CAMPAIGN) {
            // 將新增的 AdGroup(s) 複製到另一個新的 Campaign Action -> require()
        }
    }
}
