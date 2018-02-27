<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DETAILS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_contract')->unsigned();
            $table->foreign('id_contract')->references('id')->on('contracts');
            $table->integer('id_vehicle')->unsigned();
            $table->foreign('id_vehicle')->references('id')->on('vehicles');
            $table->integer('id_type_customer_subscribe')->unsigned();
            $table->foreign('id_type_customer_subscribe')->references('id')->on('types_customers_subscribes');
            $table->integer('id_boxe')->unsigned();
            $table->foreign('id_boxe')->references('id')->on('Boxes');
            $table->unique('id_vehicle');
            $table->float('price');
            $table->boolean('offer');

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
        Schema::dropIfExists('Details');
    }
}
