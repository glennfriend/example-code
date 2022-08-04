<?php

// 感謝 Eddie 的建議
/*

    API 程式使用 proxy pattern 會更清楚
    
        user ----> ApiProxyService -----> ApiService ----> remote service

    如果只想 cache 部份的 method, 用以下的 Proxy pattern
*/

class CerebroApiService implements CerebroApiInterface
{
    public function getByIdAndName($id, $name) {}
    public function list() {}
}

class CerebroApiProxyService implements CerebroApiInterface
{
    public function __construct(CerebroApiService $service)
    {
    }

    public function getByIdAndName($id, $name)
    {
        return Cache::remember($key, $time, function () {
            return parent::CerebroApiService->getByIdAndName($id, $name);
        });
    }

    // list() 不需要 cache, 所以就不建立
    // public function list()
    // {
    //     throw new Exception('xx');  // 如果建立, 但是因為不想 cache 而導出 Exception, 會違反 "里氏替換原則"
    // }
}
