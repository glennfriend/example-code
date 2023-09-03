<?php

namespace Modules\AppIntegration\Repositories;

use Illuminate\Support\LazyCollection;
use Prettus\Repository\Eloquent\BaseRepository;

class HappyRepository extends BaseRepository
{
    public function model(): string
    {
        return Happy::class;
    }

    public function findAppIntegrationsByAccountId(int $accountId): LazyCollection
    {
        return $this->model
            ->where('account_id', $accountId)
            ->lazy();

        /*
            // 錯誤的寫法, l5-repository 不支援 lazy() 的方式, 在 findWhere() 的時候已經全部抓出來了
            $criteria = [
                'account_id' => $accountId,
            ];
            return $this->findWhere($criteria)->lazy();
        */
    }
}
