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
        Schema::create('ai_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline');
            $table->string('tagline_th');
            $table->text('description');
            $table->text('description_th');
            $table->string('logo_url')->nullable();
            $table->string('website_url');
            $table->string('pricing_type')->default('freemium'); // free, freemium, paid, open_source
            $table->string('pricing_details')->nullable();
            $table->string('pricing_details_th')->nullable();
            $table->json('features')->nullable();
            $table->json('features_th')->nullable();
            $table->json('tasks')->nullable();
            $table->json('tasks_th')->nullable();
            $table->json('strengths')->nullable();
            $table->string('best_for')->nullable();
            $table->string('best_for_th')->nullable();
            $table->integer('popularity_score')->default(80);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_tools');
    }
};
