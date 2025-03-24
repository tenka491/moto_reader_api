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
        Schema::create('scraped_items', function (Blueprint $table) {
            $table->id();
            $table->string('siteId');
            $table->text('siteIcon');
            $table->string('siteDisplayName');
            $table->string('title');
            $table->string('description');
            $table->text('url');
            $table->string('author');
            $table->text('imageSrc');
            $table->string('imageAlt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scraped_items');
    }
};
