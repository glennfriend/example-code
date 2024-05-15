<?php

namespace Modules\Trigger\Tests\Unit\Jobs;

use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Modules\Contact\Entities\Contact;
use Modules\Trigger\Entities\Trigger;
use Tests\TestCase;

/**
 *
 */
class UniqueJobsTest extends TestCase
{
    private Contact $contact;

    private Trigger $trigger;

    private MockInterface $triggerServiceMock;

    private UniqueJobs $job;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contact = Contact::factory()->create();
        $this->trigger = Trigger::factory()->create();

        $this->triggerServiceMock = $this->mock(TriggerService::class);

        $this->job = new UniqueJobs($this->trigger, $this->contact);
    }

    /**
     * @test handle()
     */
    public function handle_should_only_run_once_within_unique_period()
    {
        Queue::fake();
        dispatch($this->job);
        dispatch($this->job);
        dispatch($this->job);
        Queue::assertPushed(UniqueJobs::class, 1);
    }

    /**
     * test handle() 失敗的測試程式
     */
    public function handle_should_only_run_once_within_unique_period_2()
    {
        $contactId = $this->contact->id;
        $triggerId = $this->trigger->id;

        Queue::push($this->job);
        Queue::push($this->job);
        Queue::push($this->job);
        Queue::assertPushed(function (UniqueJobs $job) use ($contactId, $triggerId) {
            $id = $contactId . '/' . $triggerId;
            return $job->uniqueId() === $id;
        });

        Queue::assertPushed(UniqueJobs::class, 1);
    }

    /**
     * test handle() 失敗的測試程式
     */
    public function handle_should_only_run_once_within_unique_period_3()
    {
        $this->triggerServiceMock
            ->shouldReceive('runTriggerWithActionsSynchronously')
            ->once();

        $this->app->call([$this->job, 'handle']);
        $this->app->call([$this->job, 'handle']);
        $this->app->call([$this->job, 'handle']);
    }
}
