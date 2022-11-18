<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table ='tables';

    protected $fillable =['name', 'dsc'];

    public function products(){

        return $this->hasMany('Product::class' , 'tables');
    }
}
