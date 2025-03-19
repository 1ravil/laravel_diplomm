<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders_products extends Model
{
    protected $table = 'orders_products'; // Убедитесь, что имя таблицы указано правильно

    protected $fillable = [
        'orders_id',
        'products_id',
        'count',
    ];
}
