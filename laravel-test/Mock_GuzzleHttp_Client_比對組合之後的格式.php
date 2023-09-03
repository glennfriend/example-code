<?php

use Tests\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;

class HelloServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockHttpClient();
    }

    /**
     * @test create()
     */
    public function should_create_success()
    {
        $this->client = Client::create('test', false, $this->httpClient);

        $this->client->journey->create(
            $this->leadId,
            $this->accountId,
            $this->campaignId,
            $this->interactionData,
            $this->webhookCustomData,
        );

        /**
         * @var \GuzzleHttp\Psr7\Request $request
         */
        $request = $this->container[0]['request'];

        $expectedHost = "api.messenger.contactloop.com";
        $this->assertEquals($expectedHost, $request->getUri()->getHost());

        $expectedPath = "/api/accounts/{$this->accountId}/campaigns/{$this->campaignId}/journeys";
        $this->assertEquals($expectedPath, $request->getUri()->getPath());

        $json = json_decode($request->getBody()->getContents(), true);
        dump($json);
        // $this->assertEquals($this->leadId, $json['lead_id']);
    }

    private function mockHttpClient(): void
    {
        $this->container = [];
        $history = Middleware::history($this->container);
        $this->mockBody = [];
        $mockResponse = new Response(200, [], json_encode($this->mockBody));
        $mockHandler = new MockHandler([$mockResponse]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $this->httpClient = new HttpClient(['handler' => $handler]);
    }
}