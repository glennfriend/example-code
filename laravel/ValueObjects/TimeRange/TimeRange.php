<?php

namespace Modules\TCPA\ValueObjects;

use Carbon\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * 有關 Eddie 程式的導讀
 *      - attribute 用 private, 提供 public method to access
 *      - 可以用 create() 產生
 *      - __construct() 只存資料, 無邏輯
 */
class TimeRange
{
    private readonly string $from;

    private readonly string $to;

    private function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function create(string $from, string $to): static
    {
        $regex = '/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/';

        if (!Str::match($regex, $from)) {
            throw new InvalidArgumentException("'{$from}' is not in the 'HH:mm' format");
        }

        if (!Str::match($regex, $to)) {
            throw new InvalidArgumentException("'{$to}' is not in the 'HH:mm' format");
        }

        if ($from > $to) {
            throw new InvalidArgumentException("from time '{$from}' must less than to time '{$to}'");
        }

        return new static($from, $to);
    }

    public static function default(): static
    {
        return self::create('08:00', '21:00');
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getFromHour(): int
    {
        $times = explode(':', $this->from);

        return intval($times[0]);
    }

    public function getFromMinute(): int
    {
        $times = explode(':', $this->from);

        return intval($times[1]);
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getToHour(): int
    {
        $times = explode(':', $this->to);

        return intval($times[0]);
    }

    public function getToMinute(): int
    {
        $times = explode(':', $this->to);

        return intval($times[1]);
    }

    public function getDiffInSeconds(): int
    {
        $now = Carbon::now();

        $fromTime = $now
            ->copy()
            ->setHour($this->getFromHour())
            ->setMinute($this->getFromMinute());

        $toTime = $now
            ->copy()
            ->setHour($this->getToHour())
            ->setMinute($this->getToMinute());

        return $toTime->diffInSeconds($fromTime);
    }

    public function isBetween(Carbon $time): bool
    {
        $fromTime = $time
            ->copy()
            ->setHour($this->getFromHour())
            ->setMinute($this->getFromMinute())
            ->setSecond(0);

        $toTime = $time
            ->copy()
            ->setHour($this->getToHour())
            ->setMinute($this->getToMinute())
            ->setSecond(0);

        return $time >= $fromTime && $time < $toTime;
    }
}
