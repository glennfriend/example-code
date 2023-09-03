<?php

use Prettus\Repository\Eloquent\BaseRepository;

class HelloRepository extends BaseRepository
{
    public function model(): string
    {
        return Hello::class;
    }

    public function findByAccountIds(array $accountIds): Collection
    {
        return $this->findWhere([
            ['account_id', 'IN', $accountIds],
        ]);
    }

    private function countRecentDailyLogs(Contact $contact): int
    {
        return $this->contactDailyLogRepository->count([
            ['contact_id', '=', $contact->id],
            ['delay_at', 'BETWEEN', [now()->subDays(1)->setHour(12), now()->addDays(1)->setHour(12)]],
        ]);
    }

    //
    // retrieve, fetch ?
    //

    public function retrieveAccounts(array $accountIds): Collection
    {
        return $this->accountRepository->findWhere([
            ['enabled', '=', true],
            ['id', 'IN', $accountIds],
        ]);
    }

}
