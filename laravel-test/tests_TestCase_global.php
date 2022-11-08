<?php

use Mockery;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 *  嘗試將所有 外部的 API query 都寫在這裡 ??
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
    	parent::setUp();

        // NOTE: should globally mock this service to prevent fetching data from external service when testing
        $this->mock(
            LocationService::class,
            function ($mock) {
                $mock
                    ->shouldReceive('findDataByAreaCode')
                    ->andReturn([
                        'city' => 'Los Angeles',
                        'state' => 'CA',
                        'zip_code' => '90011',
                    ]);
            }
        );

	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
}
