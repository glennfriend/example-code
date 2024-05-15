<?php

    /**
     * @group only
     * @test perform()
     */
    public function query_correct_keys_with_succeeded()
    {
        $result = $this->query();

        $targetKeys = collect(data_get($result, 'result.0'))->keys()->toArray();
        $expectedKeys = ['id', 'name', 'status', 'created_at'];
        $this->assertEquals(
            array_diff($expectedKeys, $targetKeys),
            array_diff($targetKeys, $expectedKeys),
            'All elements must contain' // 所有的元素都必須包含, 無視順序
        );
    }

    /**
     * @group only
     * @test perform()
     */
    public function update_data_with_succeeded()
    {
        // 必須檢查 所有變動的值 有正確變動
        // 必須檢查 其它所有的值 沒有被更動
    }
