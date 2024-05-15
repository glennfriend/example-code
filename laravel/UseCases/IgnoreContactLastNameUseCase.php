<?php

namespace Modules\Contact\UseCases;

use OnrampLab\CleanArchitecture\UseCase;

/**
 * @see https://trello.com/c/tv4UsPkV/1072-do-not-store-as-lead-if-last-name-is-aacsdqa
 * @method static bool perform(mixed $args)
 */
class IgnoreContactLastNameUseCase extends UseCase
{
    /*
        #[UnsignedInteger]
        public int $accountId;

        #[BooleanType]
        public bool $isSandbox;

        #[ArrayType]
        public array $dateRange;

        #[ArrayType, Nullable]
        public array $reportGroups;
    */

    public string $lastName;

    public function handle(): bool
    {
        if (strtolower(trim($this->lastName)) === 'aacsdqa') {
            // to log
            return true;
        }

        return false;
    }
}
