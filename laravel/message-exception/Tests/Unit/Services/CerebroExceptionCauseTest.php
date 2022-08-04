<?php

namespace Modules\Cerebro\Tests\Unit\Services;

use Exception;
use Modules\Cerebro\Services\CerebroExceptionCause;
use Tests\TestCase;

class CerebroExceptionCauseTest extends TestCase
{
    /**
     * @test
     */
    public function isEmptyPhoneNumbers_should_work()
    {
        $result = null;
        try {
            throw new Exception('is error',400);
        } catch (Exception $exception) {
            $result = CerebroExceptionCause::exception($exception)->isEmptyPhoneNumbers();
        }
        $this->assertEquals(null, $result);

        $result = null;
        try {
            throw new Exception('ooo Items is empty ooo',400);
        } catch (Exception $exception) {
            $result = CerebroExceptionCause::exception($exception)->isEmptyPhoneNumbers();
        }
        $this->assertEquals(true, $result);

        $result = null;
        try {
            throw new Exception('Items is empty',400);
        } catch (Exception $exception) {
            $result = CerebroExceptionCause::exception($exception)->isEmptyPhoneNumbers();
        }
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function isBuyPhoneNumberFail_should_work()
    {
        $result = null;
        try {
            throw new Exception('failed purchase (phonenumber: 13058889999)');
        } catch (Exception $exception) {
            $result = CerebroExceptionCause::exception($exception)->isBuyPhoneNumberFail();
        }
        $this->assertEquals(false, $result);

        $result = null;
        try {
            throw new Exception('failed purchase (phonenumber: 13058889999)',400);
        } catch (Exception $exception) {
            $result = CerebroExceptionCause::exception($exception)->isBuyPhoneNumberFail();
        }
        $this->assertEquals(true, $result);
    }
}
