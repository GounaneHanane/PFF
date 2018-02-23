<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesClientsSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Types_Clients_Subscribe', function (Blueprint $table) {
            $table->increments('idTypesClientsSubscribe');
            $table->integer('id_type_client')->unsigned();
            $table->foreign('id_type_client')->references('id_types_clients')->on('types_clients');
            $table->integer('id_subscribe')->unsigned();
            $table->foreign('id_subscribe')->references('idSubscribe')->on('Subscribe');
            $table->unique(['id_type_client','id_subscribe']);
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
