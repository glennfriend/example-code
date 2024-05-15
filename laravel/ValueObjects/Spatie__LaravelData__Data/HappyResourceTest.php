<?php

namespace Modules\Demo\Tests\Unit\ValueObjects;

use Modules\Demo\ValueObjects\HappyResource;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class HappyResourceTest extends TestCase
{
    /**
     * @group only
     * @test
     */
    public function should_work(): void
    {
        // $resource = HappyResource::validateAndCreate([
        $resource = HappyResource::from([
            'account_id' => 11,
            'first_name' => 'Jackson',
            'last_name'  => 'Michael',
            'status'     => 'enabled',
        ]);

        dump($resource->toArray());

        $this->assertEquals(11, $resource->accountId);
        $this->assertEquals('Michael Jackson', $resource->fullName);
        $this->assertEquals('enabled', $resource->status->value);
        $this->assertTrue(is_array($resource->options));
    }
}
