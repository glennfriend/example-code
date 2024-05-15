<?php


Cache::shouldHaveReceived('put')
    ->once()
    ->with('name', 'Taylor', 10);

