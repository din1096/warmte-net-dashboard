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
        Schema::create('model_objects', function (Blueprint $table) {
            $table->id();

            $table->string('object_code');
            $table->string('type');
            $table->string('layer')->nullable();

            $table->timestamps();

            $table->unique(['object_code', 'type', 'layer']);
        });
    }
  

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_objects');
    }
};
