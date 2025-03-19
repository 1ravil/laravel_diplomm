<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
//    use Translatable;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'img',
    ];

    // у тебя не получается просто потому что у тебя связи в моделях нет

    public function products()
    {
        return $this->hasMany(Products::class);
    }

}
