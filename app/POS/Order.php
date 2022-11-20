<?php

namespace App\POS;

use App\User;
use App\Product;
use App\Customer;
use App\POS\Table;
use Illuminate\Database\Eloquent\Model;

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

    public function tables(){
        return $this->belongsTo(Table::class,'table','id');
    }

    public function customers(){
        return $this->belongsTo(Customer::class,'customer','id');
    }

    public function users(){
        return $this->belongsTo(User::class,'user','id');
    }
}
