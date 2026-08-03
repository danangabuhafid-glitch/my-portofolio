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
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('project_category_id')->nullable()->constrained('project_categories')->nullOnDelete();
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->string('url')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('seo_title_id')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('company')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
        });

        Schema::table('education', function (Blueprint $table) {
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->string('school')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
        });

        Schema::table('skill_categories', function (Blueprint $table) {
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->foreignId('skill_category_id')->nullable()->constrained('skill_categories')->nullOnDelete();
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->integer('percentage')->default(0);
            $table->text('icon')->nullable();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->longText('content_id')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->string('seo_title_id')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->text('meta_description_id')->nullable();
            $table->text('meta_description_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For brevity in down() we ignore dropping as it's a test setup mostly
    }
};
