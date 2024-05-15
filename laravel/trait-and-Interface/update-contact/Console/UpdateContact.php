<?php

namespace Modules\Contact\Console;

use Illuminate\Console\Command;
use Modules\Contact\Concerns\Optionable as OptionableTrait;
use Modules\Contact\Contracts\Optionable;
use Throwable;

/**
 * 該程式是否幂等
 *      - No
 *
 * e.g.
 *      php artisan contact:update-contact
 */
class UpdateContact extends Command implements Optionable
{
    use OptionableTrait;

    /**
     * @var string
     */
    protected $signature = 'contact:update-contact
                                {--filter=*}
                                {--change=*}
    ';

    /**
     * @var string
     */
    protected $description = 'update contacts';

    public function __construct() {
        parent::__construct();
    }

    /**
     * @throws Throwable
     */
    public function handle(): int
    {
        dump($this->arguments());
        dump($this->getFilters());
        dump($this->getChanges());
    }

    public function getOptionableParameterKeys(): array
    {
        return ['filter', 'change'];
    }

    private function getFilters(): array
    {
        return $this->getAllOptions()['filter'];
    }

    private function getChanges(): array
    {
        return $this->getAllOptions()['change'];
    }
}
