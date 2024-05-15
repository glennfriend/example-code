<?php

use Modules\Contact\Entities\Contact;
\DB::enableQueryLog();

// Mars: 建議不要使用 whereDate，它會對資料庫的內容做轉換再比對

Contact::where(       'created_at', '2000-01-01')->get();
Contact::whereDate(   'created_at', '2000-01-01')->get();
Contact::whereBetween('created_at', ['2000-01-01', '2000-01-02'])->get();



dump(\DB::getQueryLog());
// "select * from `contacts` where `created_at` = ? and `contacts`.`deleted_at` is null",
// "select * from `contacts` where date(`created_at`) = ? and `contacts`.`deleted_at` is null",
// "select * from `contacts` where `created_at` between ? and ? and `contacts`.`deleted_at` is null",
