<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class create_orders_products_customers_table extends Model
{
    protected $table = 'orders_products_customers'; // Убедитесь, что имя таблицы указано правильно

    protected $fillable = [
        'order_id',
        'customer_id',
        'terms',
    ];
    
}
