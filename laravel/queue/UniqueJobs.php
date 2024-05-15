<?php

namespace Modules\Trigger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Modules\Contact\Entities\Contact;
use Modules\Trigger\Entities\Trigger;
use Modules\Trigger\Services\TriggerService;

/**
 * 掛上 ShouldBeUnique 之後
 * 可以設定 $uniqueFor 在多少秒之內不能重覆執行
 * 一定要正確設定 uniqueId()
 * 如果沒有設定好 唯一的範圍 會導致本來該進來的 job 會消失
 * @see https://learnku.com/docs/laravel/9.x/queues/12236#2a39e9
 */
class UniqueJobs implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int, the unit is seconds
     */
    public int $uniqueFor = 5 * 60;

    public int $tries = 1;
    public readonly Trigger $trigger;
    public readonly Contact $contact;

    public function __construct(Trigger $trigger, Contact $contact)
    {
        $this->trigger = $trigger;
        $this->contact = $contact;

        self::onQueue('high');
    }

    public function uniqueId(): string
    {
        return $this->contact->id . '/' . $this->trigger->id;
    }


    public function handle(TriggerService $triggerService): void
    {
        \Log::debug('execute the job');
    }
}
