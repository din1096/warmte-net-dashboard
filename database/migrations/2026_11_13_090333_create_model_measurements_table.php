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
        Schema::create('model_measurements', function (Blueprint $table) {
            $table->id();

            // makes relationships with the other tables
            $table->foreignId('model_object_id')
                ->constrained('model_objects')
                ->cascadeOnDelete();

            $table->foreignId('import_file_id')
                ->constrained('import_files')
                ->cascadeOnDelete();

            // CSV data
            $table->dateTime('time');
            $table->string('attribute');
            $table->longText('value')->nullable();

            $table->timestamps();

            // Indexes for dashboard queries
            $table->index(['time', 'attribute']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_measurements');
    }
};
