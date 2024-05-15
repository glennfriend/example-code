<?php

use Mockery;

/**
 * 我們想要測試 GoogleCampaign()->addCampaign();
 * 但是 GoogleCampaign 裡面的 mutate 會真的 call 外部的 API
 * 要阻止 mutate 的行為
 */
class Google
{
    public function campaing()
    {
        return new GoogleCampaign();
    }
}

class GoogleCampaign
{
    public function addCampaign()
    {
        $this->mutate(); // 這行真的會呼叫外部的 API, 但我們只想測試, 不想真的 call google API
    }

    protected function mutate()
    {
        // call google API
    }
}

class HelloServiceTest extends TestCase
{
    /**
     * @test
     */
    public function perform_should_work()
    {
        // 寫入測試
        $this->mockGoogle()
            ->campaign()
            ->addCampaign(new Campaign());
    }

    private function mockGoogle()
    {
        $service = $this->mock(GoogleCampaign::class);
        $service
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('mutate')
            ->once()
            ->withArgs(function (array $campaign) { // 呼叫 mutate 時的參數傳入值
                return (
                       $campaign->getResourceName() === 'customers/1111/campaigns/9999'
                    && $campaign->getId() === 9999
                );
            });

        $google = $this->mock(Google::class);
        $google->shouldReceive('campaign')
            ->andReturn($service);

        return $google;
    }

    private function initMock(string $className): object
    {
        return $this->app->instance($className, Mockery::mock($className));
    }
}