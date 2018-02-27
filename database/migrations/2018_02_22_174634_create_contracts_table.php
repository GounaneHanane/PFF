<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONTRACTS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('urlContract',100);

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
        Schema::dropIfExists('Contract');
    }
}
