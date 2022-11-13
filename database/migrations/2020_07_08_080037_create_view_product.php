<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql =" Create View view_product as SELECT
                        p.id,
                        p.name,
                        p.name_kh,
                        p.price,
                        p.photo,
                        p.dsc,
                        p.category,
                        CONCAT(c.name, '-', c.name_kh) AS category_name
                        FROM category c    INNER JOIN product p ON p.category = c.id";

       /*  Schema::create('view_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        }); */

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* Schema::dropIfExists('view_product'); */
        DB::statement(" drop view if exists view_product;");
    }
}
