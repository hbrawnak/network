<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    const SOURCE_TYPE_USER = 0;
    const SOURCE_TYPE_PAGE = 1;

    const SOURCE_TYPE = [
        self::SOURCE_TYPE_USER => 'User',
        self::SOURCE_TYPE_PAGE => 'Page'
    ];
}
