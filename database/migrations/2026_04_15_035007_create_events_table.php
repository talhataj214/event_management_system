<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title'); 
            $table->text('description')->nullable();
            $table->string('location'); 
            $table->dateTime('event_datetime');
            $table->integer('total_seats'); 
            $table->integer('available_seats')->nullable();

            // Foreign key (Created by user)
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete(); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};