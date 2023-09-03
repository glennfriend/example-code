<?php

namespace Modules\Account\ValueObjects;

use DateTimeZone;
use JsonSerializable;

class OperationSetting implements JsonSerializable
{
    // 看是不是都改使用 private 
    readonly public string $timezone;

    /**
     * @var BusinessHour[]
     */
    readonly public array $businessHours;

    public function __construct(array $data)
    {
        $this->timezone = $data['timezone'];
        $this->businessHours = $data['business_hours'];
    }

    public static function create(array $data = []): static
    {
        $timezone = new DateTimeZone(data_get($data, 'timezone', config('app.timezone')));
        $businessHours = data_get($data, 'business_hours', self::getDefaultBusinessHours());
        $businessHours = self::convertBusinessHours($businessHours);

        return new static([
            'timezone' => $timezone->getName(),
            'business_hours' => $businessHours,
        ]);
    }

    public function toArray(): array
    {
        $businessHours = [];
        foreach ($this->businessHours as $businessHour) {
            $businessHours[] = $businessHour->toArray();
        }

        return array_filter([
            'timezone'       => $this->timezone,
            'business_hours' => $businessHours,
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return BusinessHour[]
     */
    public static function getDefaultBusinessHours(): array
    {
        $sunday = new BusinessHour([
            'weekday'    => 'Sunday',
            'start_time' => '08:00',
            'end_time'   => '16:00',
            'open'       => false,
        ]);
        $monday = new BusinessHour([
            'weekday'    => 'Monday',
            'start_time' => '07:00',
            'end_time'   => '18:00',
            'open'       => true,
        ]);
        $tuesday = new BusinessHour([
            'weekday'    => 'Tuesday',
            'start_time' => '07:00',
            'end_time'   => '18:00',
            'open'       => true,
        ]);
        $wednesday = new BusinessHour([
            'weekday'    => 'Wednesday',
            'start_time' => '07:00',
            'end_time'   => '18:00',
            'open'       => true,
        ]);
        $thursday = new BusinessHour([
            'weekday'    => 'Thursday',
            'start_time' => '07:00',
            'end_time'   => '18:00',
            'open'       => true,
        ]);
        $friday = new BusinessHour([
            'weekday'    => 'Friday',
            'start_time' => '07:00',
            'end_time'   => '18:00',
            'open'       => true,
        ]);
        $saturday = new BusinessHour([
            'weekday'    => 'Saturday',
            'start_time' => '08:00',
            'end_time'   => '16:00',
            'open'       => false,
        ]);
        return [
            $sunday,
            $monday,
            $tuesday,
            $wednesday,
            $thursday,
            $friday,
            $saturday,
        ];
    }

    /**
     * @return BusinessHour[]
     */
    private static function convertBusinessHours(?array $businessHours): array
    {
        $collection = collect($businessHours)
            ->map(function (BusinessHour|array $businessHour) {
                if (is_array($businessHour)) {
                    return new BusinessHour($businessHour);
                }
                return $businessHour;
            });
        return $collection->toArray();
    }
}
