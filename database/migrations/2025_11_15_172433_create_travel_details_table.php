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
        Schema::create('travel_details', function (Blueprint $table) {
            $table->id();
            $table->string('bar_code')->unique();
            $table->string('bl');
            $table->string('consignor');
            $table->string('destination');
            $table->string('consignor_adress');
            $table->string('chassis');
            $table->string('mark');
            $table->string('type');
            $table->year('year_make');
            $table->timestamps();
        });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_details');
    }
};
