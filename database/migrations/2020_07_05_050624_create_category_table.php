<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /* $sql =" Create View category as SELECT
        p.id,
        p.name,
        p.name_kh,
        CONCAT(c.name, '-', c.name_kh) AS category_name
        FROM category c    INNER JOIN product p ON p.category = c.id"; */


/* DB::statement($sql); */
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_kh');
            $table->string('dsc');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /*  DB::statement(" drop view if exists category;"); */
        Schema::dropIfExists('category');
    }
}
