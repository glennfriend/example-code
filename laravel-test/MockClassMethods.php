<?php

/**
 * 未完成
 *
 * 測試 list()
 * 必須包裝有用到的所有 method
 * 在此例子是 search()
 * 但實際上通常會有多個 method
 */
class HelloService
{
    protected ApiClient $apiClient;

    public function list(string $id)
    {
        $name = 'hello ' . $id;
        return $this->apiClient->search($name);
    }
}


class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // service
        $this->service = Mockery::mock(HelloService::class);
        $this->service->makePartial()->shouldAllowMockingProtectedMethods();

        // service members
        $this->apiClient = Mockery::mock(ApiClient::class);
        $this->service->apiClient = $this->apiClient;
    }

    /**
     * @test
     */
    public function list_should_work()
    {
        $this->apiClient
            ->shouldReceive('search')
            ->once()
            ->andReturn([]);

        $this->service->list('100');
    }

    /**
     * @test
     */
    public function list_should_work()
    {
        $id = '100';
        $helloResponse = Mockery::mock(HelloResponse::class);
        $this->apiClient
            ->shouldReceive('search')
            ->once()
            ->with('param1', 'param2')
            ->withArgs(function (string $name) use ($id) {
                return true;
                /*
                return $this->customerId === $customerId
                    && preg_match($campaignCondition, $query)
                    && preg_match($statusCondition, $query);
                */
            })
            ->andReturn($helloResponse);

        $this->service->list($id);
    }

}