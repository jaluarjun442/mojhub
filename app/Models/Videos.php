<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'thumbnail',
        'video_url',
        'platform',
        'category_id',
        'duration',
        'added_on',
        'status'
    ];
}
