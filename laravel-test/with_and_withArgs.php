<?php

class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(HelloService::class)->makePartial();
        $this->service
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getClient')
            ->andReturn($this->clientMock);
    }
    
    /**
     * @test perform()
     */
    public function create_lead_should_work()
    {
        $this->leadId = 10;
        $this->accountId = 100;
        $this->leadInfo = [
            'phone' => '1234567890',
            'zip_code' => '90071',
        ];

        $this->leadsMock
            ->shouldReceive('create')
            ->once()
            // 如果全部單純比對參數是否一樣, 用 with 即可
            ->with($this->accountId, $this->leadInfo)
            /*
            ->withArgs(function (int $accountId, array $leadInfo) {
                dump($this->accountId, $accountId);
                return $this->accountId === $accountId
                    && $this->leadInfo === $leadInfo;
            }) */
            ->andReturn([
                'data' => [
                    'id' => $this->leadId,
                ],
            ]);

        $this->service->perform($this->accountId, $this->leadInfo);
    }
}