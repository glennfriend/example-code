<?php

namespace App\Services;

class JobManager
{
    public function callCampaign(HelloParam $param): void
    {
        /**
         * .env
         *      QUEUE_DRIVER=sync   // 直接執行, 就像是呼叫 dispatchNow() 的行為
         *      QUEUE_DRIVER=redis  // 進到 queue 裡面
         * 
         * 如果在 queue 裡面執行
         *          - see http://127.0.0.1:8080/horizon/dashboard
         *          - tail storage/logs/horizon.log -f
         * 
         */
        CampaignJob::dispatch($param)->onQueue($param->queueName);
    }
}
