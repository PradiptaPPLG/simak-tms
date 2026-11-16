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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 60)->nullable()->unique()->after('name');
            $table->string('headline', 180)->nullable()->after('major');
            $table->text('bio')->nullable()->after('headline');
            $table->string('github_url', 255)->nullable()->after('bio');
            $table->string('linkedin_url', 255)->nullable()->after('github_url');
            $table->string('instagram_url', 255)->nullable()->after('linkedin_url');
            $table->string('website_url', 255)->nullable()->after('instagram_url');
            $table->string('skills', 255)->nullable()->after('website_url');
            $table->string('location', 100)->nullable()->default('Ciamis, Jawa Barat, ID')->after('skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'headline',
                'bio',
                'github_url',
                'linkedin_url',
                'instagram_url',
                'website_url',
                'skills',
                'location',
            ]);
        });
    }
};
