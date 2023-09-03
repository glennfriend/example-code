<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions\DataTransferObjects;

use Exception;
use Modules\Expander\Services\Actions\Contracts\ActionParam;

class ExpandGenericParam implements ActionParam
{
    public string $type;
    public string $level;
    public array $seedCampaignIds;
    public array $seedAdGroupIds;
    public ?string $locationLevel;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->type = (string)$data['type'];
        $this->level = (string)$data['level'];
        $this->seedCampaignIds = (array)$data['seedCampaignIds'];
        $this->seedAdGroupIds = (array)$data['seedAdGroupIds'] ?? [];
        $this->locationLevel = isset($data['locationLevel']) ? (string)$data['locationLevel'] : null;

    }

    /**
     * @throws Exception
     */
    public function validate()
    {
        if (!$this->type) {
            throw new Exception("type not found");
        }
        if (!$this->level) {
            throw new Exception("seeds not found");
        }
        if (!$this->seedCampaignIds) {
            throw new Exception("seedCampaignIds not found");
        }
    }



    public function createFromAccount(Account $account)
    {
        // Eddie: DTO 這麼做是合理的
        return self::create([
            'xxx' => $account->xxx,
            'xxx' => $account->xxx,
            'xxx' => $account->xxx,
        ]);

    }
}
