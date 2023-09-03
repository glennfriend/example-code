<?php

use Prettus\Repository\Eloquent\BaseRepository;

class HelloRepository extends BaseRepository
{
    public function model(): string
    {
        return Contact::class;
    }

    /**
     * 取得所有的資料的 count 
     * 包含已經刪除的
     * 也就是 "不希望" 會加上這個語法 "deleted_at is null"
     */
    public function getCountWithTrashed($query): int
    {
        /*
            $query = $this->newQuery();
            $query->whereBetween('updated_at', [
                $updatedAt->copy()->toDate(),
                $updatedAt->copy()->addDay()->toDate(),
            ]);

            if ($accountId) {
                $query->where('account_id', $accountId);
            }
        */

        return $query->withTrashed()->count();
    }

}
