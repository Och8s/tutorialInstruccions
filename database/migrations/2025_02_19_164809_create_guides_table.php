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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->integer('guide_id')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('subject');
            $table->text('summary');
            $table->text('introduction_raw');
            $table->text('introduction_rendered');
            $table->text('conclusion_raw');
            $table->text('conclusion_rendered');
            $table->string('difficulty');
            $table->integer('time_required_min')->nullable();
            $table->integer('time_required_max')->nullable();
            $table->boolean('public');
            $table->string('locale');
            $table->string('type');
            $table->string('url');
            $table->json('documents')->nullable();
            $table->json('flags')->nullable();
            $table->json('image')->nullable();
            $table->json('prerequisites')->nullable();
            $table->json('steps')->nullable();
            $table->json('tools')->nullable();
            $table->integer('author_id');
            $table->string('author_username');
            $table->json('author_image')->nullable();
            $table->timestamp('created_date');
            $table->timestamp('published_date')->nullable();
            $table->timestamp('modified_date')->useCurrent(); // Cambiado aquí
            $table->timestamp('prereq_modified_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
