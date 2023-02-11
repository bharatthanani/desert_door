<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_item_by_users', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_inventory_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('sell_item')->nullable();
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
        Schema::dropIfExists('sell_item_by_users');
    }
};
