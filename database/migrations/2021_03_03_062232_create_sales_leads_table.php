<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->boolean('is_customer')->default(false);
            $table->string('position')->nullable();
            $table->string("name")->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('board_id')->nullable(); //status
            $table->string('category')->nullable(); //board
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('source')->nullable();
            $table->integer('sort_order')->default(0);
            $table->text("notes")->nullable();
            $table->string('last_contacted')->nullable();
            $table->string('class')->nullable();
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
        Schema::dropIfExists('sales_leads');
    }
}
