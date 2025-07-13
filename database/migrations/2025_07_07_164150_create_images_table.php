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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('original_image_id')->nullable()->constrained('images')->cascadeOnDelete(); //la imagen se puede modificar, por ejemplo el nombre original es '123456789.png' y la modificada seria 'mod123456789.png'
            $table->string('name');
            $table->string('path');
            $table->integer('width');
            $table->integer('height');
            $table->integer('x');
            $table->integer('y');
            $table->integer('rotate');
            $table->string('format');
            $table->boolean('filter')->default(false);      
            $table->double('size');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
