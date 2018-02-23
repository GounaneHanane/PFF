<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("CLIENTS", function (Blueprint $table) {
            $table->increments('idClients');
            $table->string('cin',45);
            $table->string('name',45);
            $table->string('contact',45);
            $table->string('email',45);
            $table->string('city',45);
            $table->string('phone',45);
            $table->integer('id_type_client')->unsigned();
            $table->foreign('id_type_client')->references('id_types_clients')->on('types_clients');
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
        Schema::dropIfExists('Clients');
    }
}
