<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gas_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_id')->constrained();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('fuel_type_id')->constrained();
            $table->float('gas_consumption');
            $table->timestamps();
        });

        Schema::create('energy_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_id')->constrained();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('fuel_type_id')->constrained();
            $table->float('energy_consumption');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_usages');
        Schema::dropIfExists('energy_usages');
    }
};
