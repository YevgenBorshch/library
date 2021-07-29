<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $category)
 * @method static orderBy(string $string, mixed $orderBy)
 * @method static validateOrder(mixed $orderBy)
 * @method static find(\Illuminate\Support\HigherOrderCollectionProxy|mixed $id)
 */
class Category extends AdminModel
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];
}
