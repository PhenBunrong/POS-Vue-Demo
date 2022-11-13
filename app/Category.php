<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table ='category';

    protected $fillable =['name', 'name_kh', 'dsc'];

    public function products(){

        return $this->hasMany('Product::class' , 'category');
    }

}
