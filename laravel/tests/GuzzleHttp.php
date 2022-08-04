<?php

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function getUserById_should_work()
    {
        $config = [
            'apiToken' => 'test-token',
            'baseUrl'  => 'https://example.com'
        ];
        $apiClient = new ApiClient($config);

        //
        $json = file_get_contents(__DIR__ . '/' . 'HelloServiceTest.json');
        $mock = new MockHandler([
            new Response(200, [], $json)
        ]);
        $client = new GuzzleHttpClient([
            'handler' => HandlerStack::create($mock)
        ]);
        $apiClient->setHttpClient($client);

        //
        $users = new Users($apiClient);
        $this->assertIsArray($users->getUserById());
    }

}