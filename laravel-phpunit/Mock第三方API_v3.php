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
        // mock 主要程式內有使用到的 class
        $this->mock(AppendUserDataItemService::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('append')
            ->once()
            ->withArgs(function (array $data) {
                return $data['accountId'] === 100;
            });

        // 主要的程式
        $this->service = Mockery::mock(HelloService::class)->makePartial();
        $this->service->perform();
    }
}