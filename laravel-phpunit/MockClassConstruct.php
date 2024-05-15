<?php

/**
 * 在 Laravel 有時候要 mock 主要的 class 程式
 * 因為雖然要測試 public method
 * 但是可能會想要阻止 protected method 做事
 * 
 * 這個時候 __construct() 裡面不要想要自己代入的情況下
 * 可以使用 mock instance 的方式
 */
class HelloService
{
    protected ExternalService $externalService;

    public function __construct(ExternalService $externalService)
    {
        $this->externalService = $externalService;
    }
    
    public function perform()
    {
        $this->callApi();                   // 你在測試的時候, 不想要真的打 callApi()
        $this->externalService->call();     // 你在測試的時候, 不想要真的打 call()
    }

    protected function callApi()
    {
        // 不測試 protected
    }
}

class HelloServiceTest extends TestCase
{
    /**
     * @test
     */
    public function perform_should_work()
    {
        $mock = $this->initMock(ExternalService::class);
        $mock->makePartial()->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('call')
            ->andReturn([200, 'Success']);

        $helloService = app(HelloService::class);           // 用這個方式產生, 可以不用擔心 inject 的問題
        $mock = Mockery::instanceMock($helloService);       // 這時要用到 instanceMock() 來代入 instance
        $mock->makePartial()->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('callApi');
    }
}