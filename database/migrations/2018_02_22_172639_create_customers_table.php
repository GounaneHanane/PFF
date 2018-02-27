<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create("CUSTOMERS", function (Blueprint $table) {
        $table->increments('id');
        $table->string('cin',45);
        $table->string('name',45);
        $table->string('contact',45);
        $table->string('contact_phone',14);
        $table->string('email',45);
        $table->string('city',45);
        $table->string('phone',45);
        $table->integer('id_type_customer')->unsigned();
        $table->foreign('id_type_customer')->references('id')->on('types_customers');
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
