<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batch_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mentor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('institution_name', 150)->nullable();
            $table->string('major', 100)->nullable();
            $table->string('role_title', 100)->default('Software Engineer Intern');
            $table->string('status', 30)->default('aktif'); // 'aktif', 'lulus', 'drop'
            
            // 4 Pilar Kompetensi & Penilaian Manual DUDI
            $table->integer('technical_skill')->default(85);
            $table->integer('discipline')->default(90);
            $table->integer('teamwork')->default(88);
            $table->integer('initiative')->default(85);
            $table->decimal('final_score', 5, 2)->default(87.00);
            $table->string('grade', 5)->default('A');
            $table->text('mentor_notes')->nullable();
            $table->string('certificate_number', 100)->nullable();
            $table->date('issue_date')->nullable();
            $table->boolean('is_published')->default(true);

            $table->timestamps();
            $table->unique(['batch_id', 'user_id']);
        });

        // Seed data batch_students dari siswa yang sudah ada
        $students = DB::table('users')->where('role', 'siswa')->get();
        $batch = DB::table('batches')->first();
        $batchId = $batch ? $batch->id : 1;

        foreach ($students as $student) {
            $userBatchId = $student->batch_id ?: $batchId;
            $eval = DB::table('evaluations')->where('user_id', $student->id)->first();
            
            DB::table('batch_students')->updateOrInsert(
                [
                    'batch_id' => $userBatchId,
                    'user_id' => $student->id,
                ],
                [
                    'mentor_id' => $student->mentor_id,
                    'institution_name' => $student->school_origin ?? 'SMKN 1 Ciamis',
                    'major' => $student->major ?? 'PPLG',
                    'role_title' => 'Software Engineer Intern',
                    'status' => $student->status === 'alumni' ? 'lulus' : 'aktif',
                    'technical_skill' => $eval->technical_skill ?? 85,
                    'discipline' => $eval->discipline ?? 90,
                    'teamwork' => $eval->teamwork ?? 88,
                    'initiative' => $eval->initiative ?? 85,
                    'final_score' => $eval->final_score ?? 87.00,
                    'grade' => ($eval && $eval->final_score >= 90) ? 'A' : (($eval && $eval->final_score >= 80) ? 'B+' : 'A'),
                    'mentor_notes' => $eval->general_notes ?? 'Menunjukkan dedikasi tinggi selama magang di PT. TMS.',
                    'certificate_number' => $eval->certificate_number ?? ('TMS-CERT-2026-' . ($student->account_id ?: $student->id)),
                    'issue_date' => $eval->issue_date ?? now()->toDateString(),
                    'is_published' => $eval->is_published ?? true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_students');
    }
};
