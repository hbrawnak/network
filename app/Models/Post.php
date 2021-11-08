<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    const SOURCE_TYPE_USER = 0;
    const SOURCE_TYPE_PAGE = 1;

    const SOURCE_TYPE = [
        self::SOURCE_TYPE_USER => 'User',
        self::SOURCE_TYPE_PAGE => 'Page'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'source_id', 'uuid');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'source_id', 'uuid');
    }

    public function owner()
    {
        if ($this->source_type === self::SOURCE_TYPE_USER) {
            return $this->belongsTo(User::class, 'source_id', 'uuid');
        } else if ($this->source_type === self::SOURCE_TYPE_PAGE)
            return $this->belongsTo(Page::class, 'source_id', 'uuid');
    }

}
