<?php

namespace Modules\Core\Supports;

use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Log;
use Modules\TCPA\Entities\TCPATelemarketingRestriction;
use Prettus\Repository\Contracts\RepositoryInterface;

// TODO: move to DataTransferObjects
class PaginatePayload
{
    public int $page = 1;
    public int $size = 1;
    public ?string $sort = null;
    public array $filter = [];

    public function __construct(array $payload)
    {
        if (isset($payload['page'])) {
            $this->page = $payload['page'];
        }
        if (isset($payload['size'])) {
            $this->size = $payload['size'];
        }
        if (isset($payload['sort'])) {
            $this->sort = $payload['sort'];
        }
        if (isset($payload['filter'])) {
            $this->filter = $payload['filter'];
        }
    }
}

/**
 * dependency "andersao/l5-repository" package
 */
class Paginate
{
    public function __construct(private readonly PaginatePayload $payload, private readonly RepositoryInterface $repository)
    {
    }

    public function render(): LengthAwarePaginator
    {
        return $this->repository->paginate($this->payload->size);
    }

    public static function factoryDataTransferObject(array $payload): PaginatePayload
    {
        return new PaginatePayload($payload);
    }

    // 目前的狀況下, 只能有一種整體的 query, 所以要把 filter 參數在裡面做 query
    public function customRule(Closure $callback): void
    {

    }
/*
    public function applyFindWhere(array $where, $columns = ['*']): void
    {
        return $this->repository
            ->scopeQuery(function ($query) use ($where, $columns) {
                return $query->findWhere($where, $columns);
            });
    }
*/
    /**
     * e.g. "name" -> "name like $value"
     */
    // 應該也只是 一種按例 而以
    public function applyLikeCondition(string $fieldName): void
    {
        $this->repository
            ->scopeQuery(function ($query) use ($fieldName) {
                /**
                 * @var Builder $query
                 */
                $value = data_get($this->payload->filter, $fieldName);
                if (!$value) {
                    return $query;
                }
                return $query->where($fieldName, 'like', "%{$this->payload->filter[$fieldName]}%");
            });
    }

    // 測試用
    public function orWhereNotIn(): void
    {
        $this->repository
            ->scopeQuery(function ($query){
                /**
                 * @var Builder $query
                 */
                return $query->whereNotIn('id', [1,2]);
            });
    }

    /**
     * e.g. "-age, name"
     */
    public function applySorting(): void
    {
        $sort = $this->payload->sort;
        if (!$sort) {
            return;
        }

        collect(explode(',', $sort))
            ->each(function (string $fieldName) {
                $direction = 'ASC';

                if (Str::startsWith($fieldName, '-')) {
                    $fieldName = Str::substr($fieldName, 1);
                    $direction = 'DESC';
                }

                $this->repository->orderBy($fieldName, $direction);
            });
    }
}

/*
// type 1
$paginate = new Paginate(Paginate::factoryDataTransferObject($payload), $repository);

$paginate->applyLikeCondition('state');         -> 這些 filter 條件不可能連在一起, 因為實際上是不同的 條件
$paginate->applyLikeCondition('state_code');    ->

$paginate->applySorting();
return $paginate->render();
*/
