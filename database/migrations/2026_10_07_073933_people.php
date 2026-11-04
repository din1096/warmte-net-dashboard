<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('city');
            $table->string('country');
            $table->string('Signup_date');
            $table->string('amount');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
