<?php

use Mockery;

/**
 * 我們想要測試 GoogleCampaign()->addCampaign();
 * 但是 GoogleCampaign 裡面的 mutate 會真的 call 外部的 API
 * 要阻止 mutate 的行為
 */
class Google
{
    public function campaign()
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

class HelloService
{
    public function perform()
    {
        // 我們的邏輯, 要測試該程式
        $google = $this->fetchGoogle();
        $google->campaign()->addCampaign(); // 會呼叫外部 API
    }
    protected function fetchGoogle()        // 包裝 外部程式, 拉一層 method, 寫測試較為容易
    {
        return new Google();
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

        $service = $this->initMock(HelloService::class);
        $service
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('fetchGoogle')
            ->andReturn($this->mockGoogle());
    }

    private function mockGoogle()
    {
        $campaign = Mockery::mock(GoogleCampaign::class);
        $campaign
            ->makePartial()
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('mutate')
            ->once()
            ->withArgs(function (array $campaign) {
                return (
                       $campaign->getResourceName() === 'customers/1111/campaigns/9999'
                    && $campaign->getId() === 9999
                );
            });

        $google = $this->initMock(Google::class);
        $google->shouldReceive('campaign')
            ->andReturn($campaign);

        return $google;
    }

    private function initMock(string $className): object
    {
        return $this->app->instance($className, Mockery::mock($className));
    }
}