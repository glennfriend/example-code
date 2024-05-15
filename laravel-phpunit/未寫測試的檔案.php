<?php

use Mockery;
use Tests\TestCase;

class HelloService extends TestCase
{
    public function testSomething(): void
    {
        $this->markTestIncomplete('測試程式必須要完成');    // 有錯誤訊息
        $this->markTestSkipped('未完成測試');               // 無錯誤訊息
    }
}


