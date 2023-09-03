<?php

namespace Modules\TCPA\Tests\Unit\Entities;

use Carbon\Carbon;
use Modules\TCPA\ValueObjects\TimeRange;
use Tests\TestCase;

final class TimeRangeTest extends TestCase
{
    /**
     * @test
     * @testWith ["08:00", "09:00", "2023-01-01T08:30:00z", true]
     *           ["08:00", "09:00", "2023-01-01T09:30:00z", false]
     *           ["12:00", "13:00", "2023-01-01T12:59:00z", true]
     *           ["12:00", "13:00", "2023-01-01T13:00:00z", false]
     *           ["12:00", "13:00", "2023-01-01T14:00:00z", false]
     */
    public function is_between($from, $to, $timeStr, $expectedResult): void
    {
        $time = Carbon::parse($timeStr);
        $range = TimeRange::create($from, $to);
        $actualResult = $range->isBetween($time);

        $this->assertEquals($expectedResult, $actualResult);
    }
}
