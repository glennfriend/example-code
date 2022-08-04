<?php

declare(strict_types=1);

use Exception;
use Illuminate\Support\Facades\Log;
use Aaa\Services\AaaExceptionCause;
use HelloWorld\Exceptions\HelloWorldPhoneNumberNotFoundException;
use HelloWorld\Exceptions\HelloWorldBuyFailException;

class Your_packages
{
    public function buyPhoneNumber(string $phoneNumber)
    {
        try {
            $result = $this->api->buyNumberByAreaCode($phoneNumber);
        } catch (Exception $exception) {
            if (AaaExceptionCause::exception($exception)->isEmptyPhoneNumbers()) {
                Log::info('phone numbers is empty', [
                    'phoneNumber' => $phoneNumber,
                    'exception'   => [
                        'code'      => $exception->getCode(),
                        'message'   => $exception->getMessage(),
                    ],
                ]);
                throw new HelloWorldPhoneNumberNotFoundException();
            } elseif (AaaExceptionCause::exception($exception)->isBuyPhoneNumberFail()) {
                Log::info('buy phone number fail', [
                    'phoneNumber' => $phoneNumber,
                    'exception'   => [
                        'code'      => $exception->getCode(),
                        'message'   => $exception->getMessage(),
                    ],
                ]);
                throw new HelloWorldBuyFailException();
            }
            throw $exception;
        }
    }
}

class Your_service_or_controller
{
    public function perform()
    {
        try {
            $result = $service->buyPhoneNumber($areaCode, $phoneNumber, $type, $options);
        }
        catch (HelloWorldPhoneNumberNotFoundException $exception) {
            // 只要是失敗, 就嘗試下一個 area code
        }
        catch (HelloWorldBuyFailException $exception) {
            // 只要是失敗, 就嘗試下一個 area code
        }
    }
}
