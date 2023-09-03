<?php

namespace Modules\Account\Tests\Unit\Supports;

use Carbon\Carbon;
use Modules\Account\Supports\BusinessHoursTimeSlotter;
use Modules\Account\ValueObjects\BusinessHour;
use Modules\Account\ValueObjects\OperationSetting;
use Tests\TestCase;

class BusinessHoursTimeSlotterTest extends TestCase
{
    readonly private BusinessHoursTimeSlotter $slotter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->slotter = app(BusinessHoursTimeSlotter::class);
    }

    /**
     * @group only
     * @test
     * @dataProvider time_range_limit
     */
    public function should_match_time_range(string $time, BusinessHour $businessHour, bool $isMatch): void
    {
        $businessHour->open = true;
        $operationSetting = OperationSetting::create(['business_hours' => [$businessHour]]);

        $currentTime = Carbon::parse($time);
        $timeRange = $this->slotter->getNextBusinessHoursTimeRange(
            $currentTime,
            'Asia/Taipei',
            $operationSetting->businessHours,
        );

        $this->assertSame($isMatch, (null !== $timeRange));
    }

    public function time_range_limit(): array
    {
        $hour = function (string $start, string $end) {
            return new BusinessHour([
                'weekday'    => 'Sunday',
                'open'       => true,
                'start_time' => $start,
                'end_time'   => $end,
            ]);
        };
        return [
            ['2000-01-01T09:59:59+0800', $hour('10:00', '12:00'), false],
            ['2000-01-01T10:00:00+0800', $hour('10:00', '12:00'), true],
            ['2000-01-01T11:59:59+0800', $hour('10:00', '12:00'), true],
            ['2000-01-01T12:00:00+0800', $hour('10:00', '12:00'), false],
        ];
    }
}
