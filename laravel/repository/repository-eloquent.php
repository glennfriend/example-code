<?php

class HelloRepository
{
    public function model(): string
    {
        return Hello::class;
    }

    public function findActivatableOnes(int $accountId): LazyCollection
    {
        return $this->model
            ->where('account_id', $accountId)
            ->where('is_opt_out', false)
            ->whereBetween('created_at', [now()->subDays(Contact::ACTIVE_DAYS), now()])
            ->lazy();
        }
    }

}
