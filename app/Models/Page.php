<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{

    const SOURCE_TYPE_USER = 0;
    const SOURCE_TYPE_PAGE = 1;

    const SOURCE_TYPE = [
        self::SOURCE_TYPE_USER => 'User',
        self::SOURCE_TYPE_PAGE => 'Page'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->toFormattedDateString();
    }


    /**
     * @return HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'source_id', 'uuid')->where('source_type', '=', self::SOURCE_TYPE_PAGE);
    }
}
