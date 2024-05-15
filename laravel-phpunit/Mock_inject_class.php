<?php

use Mockery;
use Tests\TestCase;

class HelloServiceTest extends TestCase
{
    /**
     * @test
     */
    public function perform_should_work()
    {
        // mock inject class
        $this->mock(HelloRepository::class)
            ->makePartial()     // 應該不用
            ->shouldReceive('all')
            ->once()
            ->withArgs(function (array $data) {
                return $data['accountId'] === 100;
            })
            // ->andReturn(collect([$this->TCPATelemarketingRestriction]))
            ;

        // 主程式 不需要 mock
        $this->service = app(HelloService::class);
        $this->service->perform();
    }

    /**
     * @deprecated phpunit 用 $this->mock() 即包含該功能
     */
     * 
     */
    private function initMock(string $className): object
    {
        return $this->app->instance($className, Mockery::mock($className));
    }
}

class HelloService
{
    public function __construct(private readonly HelloRepository $repository) {}

    public function perform(): Collection
    {
        return $this->repository->all();
    }
}