<?php

use Illuminate\Support\Facades\Log;

class HelloServiceTest extends TestCase
{
    /**
     * @test
     * 
     * Log 是否有正確匹配
     */
    public function xxxx_should_not_work()
    {
        Log::shouldReceive('warning')
            ->once()
            ->withArgs(function ($message) {
                $expected = '/Not support the resource: stdClass/';
                return in_array(preg_match($expected, $message), [1, true]);
            });

        $className = get_class(new Stdclass());
        HelloService::perform($className);
    }

}