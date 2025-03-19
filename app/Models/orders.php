<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
    'name',
    'phone_number',
    'status',
];
    public function products()
    {
        return $this->belongsToMany(Products::class)->withPivot('count')->withTimestamps();
    }



    public function getFullPrice(){
        $sum = 0;
        foreach($this -> products as $product){
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    public function customer()
    {
        return $this->belongsTo(customers::class);
    }
}
