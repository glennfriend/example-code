<?php

namespace Modules\Contact\Contracts;

interface Optionable
{
    public function getAllOptions(): array;

    /**
     * example
     *      return ['filter'];
     */
    public function getOptionableParameterKeys(): array;
}
