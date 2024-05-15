<?php

use Illuminate\Support\Facades\Config;

class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('hello.user.id', $this->userId);

    }
}