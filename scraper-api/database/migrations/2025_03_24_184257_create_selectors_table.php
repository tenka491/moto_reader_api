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
        Schema::create('selectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade'); // Foreign key to sites
            $table->enum('pageType', ['feed', 'article'])->default('article');
            $table->string('article');
            $table->string('title');
            $table->string('postDescription');
            $table->string('image');
            $table->string('author');
            $table->string('publishedDate');
            $table->string('siteIcon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selectors');
    }
};
