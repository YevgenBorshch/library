<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Book extends AdminModel
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'category_id',
        'series_id',
        'current_page',
        'image',
        'pages',
        'readed',
        'title',
        'year',
    ];
}
