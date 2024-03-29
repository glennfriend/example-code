<?php

namespace App\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Contact\Services\ContactService;
use Modules\Segment\Components\Search\ElasticSearch\QueryBuilder;
use Modules\Segment\Components\Search\ElasticSearch\SecurityMap;
use Modules\Segment\Repositories\SegmentRepository;

// docker-compose exec 'php7' php artisan hello:try
class HelloConsole extends Command
{
    protected $signature = 'hello:try';
    protected $description = 'hello';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->demo();
        $this->es_query();
        $this->quick_entities();
    }

    private function demo(): void
    {
    }

    private function es_query(): void
    {
        $segmentId = 3;
        $repository = app(SegmentRepository::class);
        $segment = $repository->find($segmentId);
        dump($segment->toArray());
        $builder = new QueryBuilder(app(SecurityMap::class), app(ContactService::class));
        $esQuery = $builder->build($segment);

        dump($esQuery);
    }

    private function quick_entities(): void
    {
        $account = Account::factory()->make();
        dd($account->toArray());
    }
}
