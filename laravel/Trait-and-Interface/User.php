<?php

declare(strict_types=1);

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use YourLibrary\Concerns\Visit\CanVisit;    // Trait
use YourLibrary\Contracts\Visit\HasVisits;  // Interface

trait CanVisit
{
    abstract function prefix();

    /**
     * trait 請用於至少有一個 public function
     */
	function public getTag($name)
    {
		echo $this->prefix() . $name . "\n";
	}
}


class User extends Model implements HasVisits
{
    use CanVisit;
}
