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
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->timestamps();
        });


        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->string('image')->nullable();
            $table->date('creation_date')->nullable();
            $table->date('expiration_date')->nullable();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tag_id')->constrained('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
        Schema::dropIfExists('tags');
    }
};
