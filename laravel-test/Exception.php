<?php

class HelloServiceTest extends TestCase
{
    /**
     * @test
     * 
     * 格式不正確時應該拋出 Exception
     */
    public function birth_format_should_not_work()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Birth string format validation failed !");
        $this->expectExceptionMessageRegExp('/Birth string format validation failed$/');

        // Throwable ???

        HelloService::birth('20000-01-01');
    }

    /**
     * @test
     */
    public function perform_should_return_404(): void
    {
        $service = Mockery::mock(YourService::class);
        $service
            ->shouldReceive('perform')
            ->andThrow(new Exception('error', 404));
        $this->app->instance(YourService::class, $service);

        $response = $this->get('http://domain/api/resource-name');
        $response->assertStatus(404);
    }

}