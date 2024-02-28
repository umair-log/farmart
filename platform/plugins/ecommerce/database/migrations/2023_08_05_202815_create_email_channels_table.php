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
        Schema::create('email_channels', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('gaming_account_id')->constrained('ec_products')->onDelete('cascade')->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('value1')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->tinyInteger('check_box_value')->nullable();
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
        Schema::dropIfExists('email_channels');
    }
};
