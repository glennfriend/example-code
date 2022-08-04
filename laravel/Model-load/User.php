<?php

declare(strict_types=1);

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';
    protected $guarded = ['id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }
    // 未經測試
    public function 取得爸爸的資料()
    {
        $parentUser = $this->parent();
    }




    // 取得 user 寫的所有 user_articles 文章 ????
    public function getArticles(): HasMany
    {
        // `user_id` in `user_articles`
        // `id`      in `users`
        return $this->hasMany(UserArticles::class, 'user_id', 'id');
    }
    // 取得 user 寫的自我介紹 ????
    // Get articles about myself
    public function get_about_myself_article()
    {
        $this->load('getArticles.getAboutMyselfArticle');

        foreach ($this->getArticles as $property) {
            dump($property);
        }
    }

}
