<?php

namespace App\POS;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Order extends Model
{
    protected $table="orders";
    protected $fillable=[
        'order_date',
        'table',
        'user',
        'customer',
        'totalPay',
        'cashIn',
    ];
	
    public function product(){
        return $this->belongsToMany(Product::class,'product_orders','order','product');
    }
}
