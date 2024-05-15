<?php

class HelloWorkerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Bus::fake();

        $this->service = app(HelloWorker::class);
        $this->service = app(HelloRunner::class);
    }

    /**
     * @test
     */
    public function dispatch_job_should_work()
    {
        $param = new HelloWorkParam($this->appIntegration, $this->contact, $this->userListId);
        $this->worker->perform($param);

        Bus::assertDispatched(HelloJob::class, function (object $job) {
            return $job->accountId   === $this->accountId
                && $job->email       === $this->contact->email
                && $job->phoneNumber === (string) $this->contact->e164Phone;
        });
    }
}