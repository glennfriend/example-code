<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions\Structs;

use Exception;
use Modules\Expander\Services\Actions\DataTransferObjects\ExpandGenericParam;

class ExpandGenericParentAction extends ParentAction
{
    protected ExpandGenericParam $dto;

    /**
     * false 並不代表錯誤, 只是未符合向下延伸的資格
     *
     * @param ExpandGenericParam $dto
     * @return bool
     * @throws Exception
     */
    public function require(ExpandGenericParam $dto): bool
    {
        $this->dto = $dto;
        if (!$this->check()) {
            return false;
        }
        $this->main();
        return true;
    }
}
