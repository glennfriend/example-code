<?php

declare(strict_types=1);

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use YourLibrary\Concerns\Visit\CanVisit;    // Trait
use YourLibrary\Concerns\Visit\HasVisits;   // Interface

// 參考自 https://github.com/coderflexx/laravisit/tree/main/src
// 但上面這個例子是 trait, interface 都放在 Concerns 目錄之中

class User extends Model implements CanVisit
{
    use HasVisits;
}
