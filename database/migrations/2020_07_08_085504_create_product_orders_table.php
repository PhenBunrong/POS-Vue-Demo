<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* $sql =" Create View product_orders as SELECT
                        p.id,
                        p.name,
                        p.name_kh,
                        CONCAT(c.name, '-', c.name_kh) AS category_name
                        FROM category c  INNER JOIN product p ON p.category = c.id"; */


        Schema::create('product_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order');
            $table->unsignedBigInteger('product');
            $table->float('price');
            $table->tinyInteger('qty');

            
            $table->foreign('order')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['order','product']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_orders');
    }
}
