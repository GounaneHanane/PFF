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
        Schema::create('Details', function (Blueprint $table) {
            $table->increments('idDetails');
            $table->integer('id_contract')->unsigned();
            $table->foreign('id_contract')->references('idContract')->on('contract');
            $table->integer('id_vehicle')->unsigned();
            $table->foreign('id_vehicle')->references('idVehicles')->on('Vehicles');
            $table->integer('id_type_clients_subscribe')->unsigned();
            $table->foreign('id_type_clients_subscribe')->references('idTypesClientsSubscribe')->on('Types_Clients_Subscribe');
            $table->integer('id_boxe')->unsigned();
            $table->foreign('id_boxe')->references('idBoxes')->on('Boxes');
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
