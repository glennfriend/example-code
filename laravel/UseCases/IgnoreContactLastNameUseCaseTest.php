<?php

namespace Modules\Contact\Tests\Integration\UseCases;

use Modules\Contact\UseCases\IgnoreContactLastNameUseCase;
use Tests\TestCase;

class IgnoreContactLastNameUseCaseTest extends TestCase
{
    /**
     * @test
     * @testWith ["aacsdqa", true]
     *           [" AACSDQA ", true]
     *           ["aac sdga", false]
     *           ["i am aacsdqa", false]
     *           ["aacsdqa is prefix", false]
     */
    public function perform_should_work(string $lastName, bool $expectedValue): void
    {
        $result = IgnoreContactLastNameUseCase::perform([
            'lastName' => $lastName,
        ]);

        $this->assertEquals($expectedValue, $result);
    }
}
