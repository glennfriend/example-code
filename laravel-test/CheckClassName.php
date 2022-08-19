<?php

use Tests\TestCase;

class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->factory = app(HelloServiceFactory::class);
    }

    /**
     * @test
     */
    public function factory_google_service_should_work()
    {
        $config = [
            'create' => 'Google',   // Google, Facebook
        ];
        $googleService = $this->factory->create($config);
        $this->assertInstanceOf(GoogleService::class, $googleService);
    }

}