<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const SOURCE_TYPE_USER = 0;
    const SOURCE_TYPE_PAGE = 1;

    const SOURCE_TYPE = [
        self::SOURCE_TYPE_USER => 'User',
        self::SOURCE_TYPE_PAGE => 'Page'
    ];


    public function user()
    {
        return $this->hasOne(User::class, 'uuid', 'source_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'uuid', 'source_id');
    }

}
