<?php

use GuzzleHttp\Client as HttpClient;
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
        $json = $this->getMockData();

        $httpClient = $this->getHttpClient(200, $json);
        $apiClient->setHttpClient($httpClient);

        //
        $users = new Users($apiClient);
        $this->assertIsArray($users->getUserById());
    }

    private function getHttpClient(int $status, string $body = null)
    {
        $mock = new MockHandler([new Response($status, [], $body)]);
        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);
        return $client;
    }

    private function getMockData(): string
    {
        return file_get_contents(__DIR__ . '/' . 'hello_service.json');
        return file_get_contents(__DIR__ . '/../Data/Account/account.json');
    }
}