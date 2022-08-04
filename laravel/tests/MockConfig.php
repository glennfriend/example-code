<?php

class HelloServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('hello.user.id', $this->userId);

    }
}