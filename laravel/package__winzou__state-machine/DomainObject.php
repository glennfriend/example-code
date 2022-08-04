<?php

namespace Modules\Expansion\Services\States;

class DomainObject
{
    private string $defaultState = 'start';
    // private string $stateA = 'checkout';
    // private string $stateB = 'checkout';

    public function getDefaultState(): string
    {
        return $this->defaultState;
    }

    public function setDefaultState($state)
    {
        $this->defaultState = $state;
    }

    /*
    public function getStateA(): string
    {
        return $this->stateA;
    }

    public function setStateA($state)
    {
        $this->stateA = $state;
    }

    public function getStateB(): string
    {
        return $this->stateB;
    }

    public function setStateB($state)
    {
        $this->stateB = $state;
    }
    */

    public function setConfirmedNow()
    {
        var_dump('I (the object) am set confirmed at ' . date('Y-m-d') . '.');
    }
}
