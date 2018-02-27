<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesCustomersSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TYPES_CUSTOMERS_SUBSCRIBES', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_type_customer')->unsigned();
            $table->foreign('id_type_customer')->references('id')->on('types_customers');
            $table->integer('id_subscribe')->unsigned();
            $table->foreign('id_subscribe')->references('id')->on('types_subscribeS');
            $table->unique(['id_type_customer','id_subscribe']);
            $table->float('price');
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
        Schema::dropIfExists('Types_Clients_Subscribe');
    }
}
