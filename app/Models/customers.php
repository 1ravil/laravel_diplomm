<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $table = 'customers'; // Убедитесь, что имя таблицы указано правильно

    protected $fillable = [
        'customer_name',
        'customer_surname',
        'email',
        'phone',
    ];



}
