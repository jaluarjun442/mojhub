<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable = [
        'title',
        'parent_category_id',
        'platform',
        'slug',
        'platform_category_id',
        'thumbnail',
        'status',
    ];
}
