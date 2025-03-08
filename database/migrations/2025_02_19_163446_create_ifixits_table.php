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
        Schema::create('ifixits', function (Blueprint $table) {
            $table->id();
            $table->string('data_type');
            $table->integer('guide_id')->unique();
            $table->string('locale');
            $table->integer('revision_id');
            $table->timestamp('modified_date');
            $table->timestamp('prereq_modified_date')->nullable();
            $table->text('url'); // Cambia esta línea
            $table->string('type');
            $table->string('category');
            $table->string('subject');
            $table->string('title');
            $table->text('summary');
            $table->string('difficulty');
            $table->integer('time_required_max')->nullable();
            $table->boolean('public');
            $table->integer('user_id');
            $table->string('username');
            $table->json('flags')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ifixits');
    }
};
