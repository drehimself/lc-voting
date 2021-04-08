<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ledger_category_id');
            $table->foreign('ledger_category_id')->references('id')->on('ledger_categories');
            $table->longText('description');
            $table->string('date');
            $table->float('amount');
            $table->boolean('is_taxable');
            $table->enum('type', ['expense', 'income', 'adjustment']);
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
        Schema::dropIfExists('ledgers');
    }
}
