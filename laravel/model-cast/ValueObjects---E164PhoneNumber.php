<?php

namespace Modules\Core\ValueObjects;

use Exception;
use Illuminate\Support\Str;

// Eddie
class E164PhoneNumber
{
    public const PATTERN = '/^\+\d{10,14}$/';

    /**
     * @var string $e164PhoneNumber
     */
    private $e164PhoneNumber;

    private function __construct(string $phoneNumber)
    {
        // Eddie: 不要在這裡呼叫 create(), 只放 validate 就好, 所以把這裡改為 private
        // Eddie: constructor 只做 assign property 或 validation

        // 以 FileLogger 為例, 如果在 construct 裡面判斷 log 目錄不存在就建立, 是 "不正確" 的
        // 創建目錄和文件 的任務應該移到應用程序本身的引導階段


        $valid = preg_match(self::PATTERN, $phoneNumber);
        if (!$valid) {
            throw new Exception("phone number is not valid E164 format.");
        }

        $this->e164PhoneNumber = $phoneNumber;
    }

    public static function create(string $phoneNumber): E164PhoneNumber
    {
        // number is already an E164 format
        if (preg_match('/^\+/', $phoneNumber)) {
            return new E164PhoneNumber($phoneNumber);
        }

        // 912345678 -> +886912345678
        if (preg_match('/^9[0-9]{8}$/', $phoneNumber)) {
            return new E164PhoneNumber('+886' . $phoneNumber);
        }

        // 0912345678 -> +886912345678
        if (preg_match('/^09[0-9]{8}$/', $phoneNumber)) {
            return new E164PhoneNumber(Str::replaceFirst('0', '+886', $phoneNumber));
        }

        // 886912345678 -> +886912345678
        if (preg_match('/^8869[0-9]{8}$/', $phoneNumber)) {
            return new E164PhoneNumber('+' . $phoneNumber);
        }

        // 2011234567 -> +120112345678
        if (preg_match('/^[0-9]{10}$/', $phoneNumber)) {
            return new E164PhoneNumber('+1' . $phoneNumber);
        }

        // 12011234567 -> +120112345678
        if (preg_match('/^1[0-9]{10}$/', $phoneNumber)) {
            return new E164PhoneNumber('+' . $phoneNumber);
        }

        // number in any format
        if (!preg_match('/^\+/', $phoneNumber)) {
            $phoneNumber = Str::replace([' ', '-'], '', $phoneNumber);

            return new E164PhoneNumber('+' . $phoneNumber);
        }

        return new E164PhoneNumber($phoneNumber);
    }

    public function toLocalString(): string
    {
        return Str::replace(['+886', '+1', '+'], '', $this->e164PhoneNumber);
    }

    public function __toString(): string
    {
        return $this->e164PhoneNumber;
    }
}
