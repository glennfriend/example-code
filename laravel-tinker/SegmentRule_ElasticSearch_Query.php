進到 segment page
從 /api/accounts/___/triggers/ 可以得知 segment id

<?php

use Modules\Segment\Entities\Segment;
use Modules\Segment\Repositories\SegmentRepository;
use Modules\Segment\Components\Search\ElasticSearch\QueryBuilder;
use Modules\Segment\Components\Search\ElasticSearch\SearchManager;
use Modules\Segment\Components\Search\ElasticSearch\SecurityMap;


$segmentId = 344;   // local
$segmentId = 1189;  // production

$segmentRepository = app(SegmentRepository::class);
$segment = $segmentRepository->find($segmentId);

dump($segment->toArray());

$builder = new QueryBuilder(app(SecurityMap::class), app(ContactService::class));
$elasticSearchQuery = $builder->build($segment);

// dump($elasticSearchQuery);
$text = json_encode($elasticSearchQuery, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents('/tmp/es.json', $text )

/*
{
    "from": 0,
    "size": 10,
    "query": {
        "bool": {
            "filter": [
                {
                    "term": {
                        "account_id": 1
                    }
                }
            ],
            "must": [
                {
                    "bool": {
                        "must": [
                            {
                                "range": {
                                    "created_at": {
                                        "lt": "2023-10-04 23:14:29",
                                        "gte": "2023-10-03 23:14:29",
                                        "format": "yyyy-MM-dd HH:mm:ss"
                                    }
                                }
                            }
                        ]
                    }
                }
            ]
        }
    },
    "sort": [
        {
            "id": {
                "order": "asc"
            }
        }
    ]
}
*/
