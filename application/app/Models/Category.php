<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $category)
 */
class Category extends Model
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
}
