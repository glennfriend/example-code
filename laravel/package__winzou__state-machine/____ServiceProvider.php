<?php

namespace Modules\Expansion\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Expansion\Services\States\StateMachineManager;

class ____ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * @var StateMachineManager $stateMachineManager
         */
        $stateMachineManager = app(StateMachineManager::class);
        $stateMachine = $stateMachineManager->factory();

    }
}
