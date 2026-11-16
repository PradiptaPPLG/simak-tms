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
        // 1. Batches Table
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name', 100);
            $table->year('period_year')->default(2026);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add extra columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('batch_id')->nullable()->after('id')->constrained('batches')->nullOnDelete();
            $table->string('role', 20)->default('siswa')->after('email'); // 'siswa', 'mentor', 'admin_tms'
            $table->string('school_origin', 150)->nullable()->default('SMKN 1 Ciamis')->after('role');
            $table->string('major', 100)->nullable()->default('PPLG')->after('school_origin');
            $table->string('phone_number', 25)->nullable()->after('major');
            $table->string('avatar', 255)->nullable()->after('phone_number');
        });

        // 3. Tasks Table (Modul LMS)
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('description');
            $table->dateTime('deadline');
            $table->string('priority', 20)->default('sedang'); // 'rendah', 'sedang', 'tinggi'
            $table->string('attachment_file', 255)->nullable();
            $table->string('status', 20)->default('aktif'); // 'aktif', 'selesai', 'diarsipkan'
            $table->timestamps();
        });

        // 4. Task Submissions
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('repo_url', 255)->nullable();
            $table->string('demo_url', 255)->nullable();
            $table->text('submission_notes')->nullable();
            $table->string('status', 20)->default('submitted'); // 'submitted', 'revisi', 'approved'
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        // 5. Daily Journals Table
        Schema::create('daily_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('journal_date');
            $table->string('activity_title', 200);
            $table->text('activity_detail');
            $table->text('challenges')->nullable();
            $table->text('solution')->nullable();
            $table->string('evidence_photo', 255)->nullable();
            $table->string('commit_url', 255)->nullable();
            $table->string('status', 20)->default('pending'); // 'pending', 'approved', 'revisi'
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('mentor_feedback')->nullable();
            $table->timestamps();
        });

        // 6. Showcase Projects Table
        Schema::create('showcase_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('team_members', 255)->nullable();
            $table->string('title', 200);
            $table->string('tech_stack', 255)->default('Laravel, Tailwind, MySQL');
            $table->string('short_description', 255);
            $table->text('full_description')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('live_url', 255)->nullable();
            $table->string('repo_url', 255)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        // 7. Evaluations Table
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mentor_id')->constrained('users')->cascadeOnDelete();
            $table->integer('technical_skill')->default(85);
            $table->integer('discipline')->default(90);
            $table->integer('teamwork')->default(88);
            $table->integer('initiative')->default(85);
            $table->decimal('final_score', 5, 2)->default(87.0);
            $table->string('certificate_number', 100)->nullable();
            $table->text('general_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('showcase_projects');
        Schema::dropIfExists('daily_journals');
        Schema::dropIfExists('task_submissions');
        Schema::dropIfExists('tasks');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn(['batch_id', 'role', 'school_origin', 'major', 'phone_number', 'avatar']);
        });

        Schema::dropIfExists('batches');
    }
};
