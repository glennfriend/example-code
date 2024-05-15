<?php

// ================================================================================
//  example 1
// ================================================================================

    // 首先跑一些 seed
    $jobItemId = 1;

    $mockRefund = $this
        ->getMockBuilder(Refund::class)
        ->setMethods([
            // 至少要有一個 method 參數
            // 該白名單表示需要被 mock, 不在名單中的, 都會正常執行
            'callRefundApi',
        ])
        ->setConstructorArgs([$jobItemId])
        ->getMock();

    $apiReturnData = ['一些你假造的資料'];
    $mockRefund
        ->method('callRefundApi')
        ->willReturn($apiReturnData);

    $mockRefund->handle(
        new JobItems()
        , new Alerts()
        , $this->createMock(ServiceApi::class)  // 不需要測試的才需要 mock
    );

    