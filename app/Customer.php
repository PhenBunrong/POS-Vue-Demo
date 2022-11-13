<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    //Customers id,name,gender,phone,address 
    protected $table ='customers';

    protected $fillable =['name', 'gender', 'phone', 'address'];

    
}
