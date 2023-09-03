<?php

use Mockery;

/**
 * 在 Laravel 有時候要 mock 主要的 class 程式
 * 因為雖然要測試 public method
 * 但是可能會想要阻止 protected method 做事
 * 
 * 這個時候 __construct() 裡面不要想要自己代入的情況下
 * 可以使用 mock instance 的方式
 */
class HelloJob
{
    public function __construct(
        AvaAppIntegration $appIntegration
    )
    {
        $this->appIntegration = $appIntegration;
    }
    
    public function handle()
    {
        $this->appIntegration->callExternalApi();  // 外部的 API call
    }
}

class HelloJobTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();

        $this->appIntegration = Mockery::mock(AvaAppIntegration::factory()->create());

        // 以下這個方式是 將 DI 實體替換掉
        // 因為這個例子的參數是在 construct 傳入, 所以下面這個就無法適用於這個例子
        // $this->appIntegration = $this->app->instance(AvaAppIntegration::class, Mockery::mock(AvaAppIntegration::class));


        //
        $this->phoneNumberMock = Mockery::mock(PhoneNumber::class);
        $this->SmsMessageMock = Mockery::mock(SmsMessage::class);

        $xxxClientMock = Mockery::mock(Client::class);
        $xxxClientMock->phoneNumber = $this->phoneNumberMock;
        $xxxClientMock->sms = $this->SmsMessageMock;

        $this->job = new HelloJob(
            $this->appIntegration
        );
        $this->job->client = $xxxClientMock;
    }

    /**
     * @test
     */
    public function perform_should_work()
    {
        $this->appIntegration
            ->shouldReceive('callExternalApi')
            ->once()
            ->andReturn([]);

        $this->app->call([$this->job, 'handle']);
    }
}