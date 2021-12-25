<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class WatchBook extends AdminModel
{
    use HasFactory, Notifiable;

    protected $table = 'watch_book';

    /**
     * @var string[]
     */
    protected $fillable = [
        'book_id',
        'series_id',
        'title',
        'url',
    ];
}
