<?php

namespace Modules\AppIntegration\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\AppIntegration\Events\LeadCreatedEvent;
use Modules\AppIntegration\Events\LeadUpdatedEvent;
use Modules\AppIntegration\Listeners\LeadCreatedListener;
use Modules\AppIntegration\Listeners\LeadUpdatedListener;
use Modules\AppIntegration\Listeners\SyncContactOptInStatusListener;
use Modules\Contact\Events\ContactOptedInEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        ContactCreateFailedEvent::class => [
            ContactCreateFailedListener::class,
        ],
        LeadCreatedEvent::class => [
            LeadCreatedListener::class,
        ],
        LeadUpdatedEvent::class => [
            LeadUpdatedListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
