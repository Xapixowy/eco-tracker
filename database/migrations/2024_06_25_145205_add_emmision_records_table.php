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
        Schema::create('emmision_records', function (Blueprint $table) {
            $table->id();
            $table->morphs('sourcable');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->decimal('co2_emmision', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emmision_records');
    }
};
