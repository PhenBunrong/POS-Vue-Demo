<?php

namespace App\POS;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table="tables";
    protected $fillable =['name', 'dsc'];
}
