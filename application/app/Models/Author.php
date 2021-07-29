<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $author)
 * @method static paginate(int $perPage)
 * @method static orderBy(string $string, string $order)
 */
class Author extends AdminModel
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];
}
