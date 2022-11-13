<?php

namespace App;

use App\POS\Order;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table ='product';

    protected $fillable =['name', 'name_kh', 'price','photo','dsc','category'];

    public function category(){

        return $this->belongsTo('Category::class' , 'category');
    }

    public function product_orders(){

        return $this->belongsTo('Product_order::class' , 'product_orders');
    }

    public function order(){
        return $this->belongsToMany(Order::class,'product_orders','product','order');
    }
}
