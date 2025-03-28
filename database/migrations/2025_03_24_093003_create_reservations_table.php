<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
    
    
return new class extends Migration
{   
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('plant_id');
            $table->foreign('plant_id')->references('id')->on('plantes');
            $table->integer('done');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
