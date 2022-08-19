<?php

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
        // ....
        $this->mutate(); // 這行真的會呼叫外部的 API, 但我們不想要這樣
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
        $service = $this->initMock(GoogleCampaign::class);
        $service
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
            ->andReturn($service);

        return $google;
    }
}