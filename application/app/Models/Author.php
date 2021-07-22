<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @method static create(array $author)
 * @method static paginate(int $perPage)
 * @method static orderBy(string $string, string $order)
 */
class Author extends Model
{
    use HasFactory, Notifiable;

    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    const ALLOWED_ORDER = [
        self::ORDER_ASC,
        self::ORDER_DESC,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * @param string $order
     * @return bool
     */
    public static function validateOrder(string $order): bool
    {
        return in_array($order, self::ALLOWED_ORDER);
    }
}
