<?php

namespace Modules\KB\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\KB\Adapters\FusionKBSourceItemList;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

readonly class HelloRepository
{
    public function __construct(private ListHello $listHello)
    {
    }

    public function paginatedSearch(int $page, int $size, array $conditions): LengthAwarePaginator
    {
        $total = 10;
        $randomData = TestDataGenerator::generateRandomKnowledgeBaseSourceItem($total);
        return new LengthAwarePaginator($randomData, $total, $size, $page);

        return $this->listHello->getLengthAwarePaginator($page, $size, $conditions);
    }
}


class TestDataGenerator
{
    public static function generateRandomKnowledgeBaseSourceItem(int $count = 1): array
    {
        $faker = Faker::create();

        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'id' => $faker->randomNumber(5),
                'name' => $faker->name(),
                'type' => $faker->randomElement(['Link', 'FAQ', 'WebSite', 'SiteMap']),
                'content_url' => $faker->url(),
                'external_id' => $faker->randomNumber(5),
                'source_url' => $faker->url(),
                'knowledge_base_source_id' => $faker->randomNumber(5),
                'knowledge_base_id' => $faker->randomNumber(5),
                'enabled' => $faker->boolean(),
                'training_status' => $faker->randomElement(['completed', 'in_progress', 'not_started']),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }

        return $data;
    }
}
