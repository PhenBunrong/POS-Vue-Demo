<?php

namespace App\POS;

use Illuminate\Database\Eloquent\Model;

class Product_order extends Model
{
    protected $table ='product_orders';

    protected $fillable =['order', 'product', 'price', 'qty'];


    public function products(){

        return $this->hasMany('Product::class' , 'product_orders');
    }
}
