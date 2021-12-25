<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class WatchAuthor extends AdminModel
{
    use HasFactory, Notifiable;

    protected $table = 'watch_authors';

    /**
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];
}
