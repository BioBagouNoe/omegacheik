<?php

use App\Models\Agency;
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
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->string('num_travel');
            $table->date('arrival_date');
            $table->date('docking_date');
            $table->date('end_unloading');
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->onDelete('cascade');
            $table->foreignId('ship_id')->nullable()->constrained('ships')->onDelete('cascade');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'canceled']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel');
    }
};
