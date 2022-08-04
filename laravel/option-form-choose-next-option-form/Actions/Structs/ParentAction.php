<?php

declare(strict_types=1);

namespace Modules\Expander\Services\Actions\Structs;

use Exception;
use Modules\Expander\Services\Actions\Contracts\ShouldAction;

class ParentAction implements ShouldAction
{
    public const DESCRIPTION = '';

    /*
    public function actionKey(): string
    {
        return self::class;
        // return 'MyselfClassName'; // ?? return self::class;
    }
    */

    public function childrenActions(): array
    {
        return [
            // ChildAction1::class,
            // ChildAction2::class,
        ];
    }

    public function config(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    protected function check(): bool
    {
        // 各種所需的判斷邏輯
        // false 並不代表錯誤, 只是未符合向下延伸的資格
        // 如果是錯誤, 程式請導出 Exception
        return true;
    }

    protected function main()
    {
        // 要真正呼叫執行哪些程式
        // 或是呼叫其它的 Action, 因為它可能是多層的選擇
    }
}
