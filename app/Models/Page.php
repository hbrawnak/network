<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    const SOURCE_TYPE = 1;


    public function posts()
    {
        return $this->hasMany(Post::class, 'source_id', 'uuid')->where('source_type', '=', self::SOURCE_TYPE);
    }
}
