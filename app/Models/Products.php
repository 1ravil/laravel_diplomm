<?php

namespace App\Models;

use App\Http\Controllers\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Products extends Model
{

//    public static function get()
//    {
//
//    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceForCount() {
        if(!is_null($this->pivot)){
            return $this->pivot->count * ($this->product_price*0.9);
        }
        return ($this->product_price*0.9);
    }

    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'product_color',
        'product_memory',
        'product_img',
        'main_image',
        'product_images',
        'categories_id',
        'product_description',
        'availability'
    ];

}
