<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $table = 'website';

    protected $fillable = [
        'title',
        'slug',
        'logo',
        'header_script',
        'header_style',
        'footer_script',
        'sidebar',
        'status',
    ];
}
