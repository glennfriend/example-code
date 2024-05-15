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
            ->times(1)
            ->withArgs(function ($message) {
                $expected = '/Not support the resource: stdClass/';
                return in_array(preg_match($expected, $message), [1, true]);
            });

        $className = get_class(new Stdclass());
        HelloService::perform($className);
    }

    /**
     * @test
     * 
     * Log 是否有正確匹配
     */
    public function create_log_should_work()
    {
        $messages = [
            'start',
            'migration time zone.',
            'migration time zone finished',
        ];
        foreach ($messages as $expectedMessage) {
            Log::shouldReceive('info')
                ->once()
                ->times(1)
                ->withArgs(function (string $message) use ($expectedMessage) {
                    return strpos($message, $expectedMessage) !== false;
                });
        }

        $className = get_class(new Stdclass());
        HelloService::perform($className);
    }
}