<?php

$mockAlerts = Mockery::mock('alias:Alerts');
$mockAlerts
    ->shouldReceive('get')
    ->withAnyArgs()
    ->andReturn($alert);
