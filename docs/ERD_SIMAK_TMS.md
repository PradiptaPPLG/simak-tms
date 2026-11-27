# Entity Relationship Diagram (ERD) — SIMAK-TMS

Dokumen ini menggambarkan struktur basis data relasional **SIMAK-TMS** (Sistem Informasi Manajemen Aktivitas, Karya & Sertifikasi Siswa PKL PT. Teknologi Multi Sistem), termasuk arsitektur **3-tabel Pivot** (`batches` $\leftrightarrow$ `batch_students` $\leftrightarrow$ `users`) untuk mendukung multi-angkatan dan multi-sertifikat per peserta.

---

## Diagram ERD (Mermaid)

```mermaid
erDiagram
    batches ||--o{ batch_students : "memiliki peserta (pivot)"
    users ||--o{ batch_students : "mengikuti angkatan (siswa)"
    users ||--o{ batch_students : "membimbing (mentor)"

    batches ||--o{ users : "angkatan utama"
    users ||--o{ users : "mentor_id (pembimbing)"

    batches ||--o{ showcase_projects : "memiliki proyek"
    users ||--o{ showcase_projects : "creator_id"

    batches ||--o{ tasks : "penugasan batch"
    users ||--o{ tasks : "mentor_id"
    tasks ||--o{ task_submissions : "dikumpulkan"
    users ||--o{ task_submissions : "user_id"

    users ||--o{ daily_journals : "mengisi logbook"
    users ||--o{ daily_journals : "mereview (mentor)"

    users ||--o{ evaluations : "evaluasi legacy"
    users ||--o| pkl_registrations : "mendaftar PKL"

    batches {
        bigint id PK
        string batch_name
        string period_year
        date start_date
        date end_date
        boolean is_active
    }

    users {
        bigint id PK
        bigint batch_id FK
        bigint mentor_id FK
        string account_id UK
        string profile_hash UK
        string name
        string email UK
        string role
        string nis_nim
        string school_origin
        string major
        string status
        json routine_off_days
    }

    batch_students {
        bigint id PK
        bigint batch_id FK
        bigint user_id FK
        bigint mentor_id FK
        string role_title
        string institution_name
        string major
        string status
        int technical_skill
        int discipline
        int teamwork
        int initiative
        decimal final_score
        string grade
        text mentor_notes
        string certificate_number
        date issue_date
        boolean is_published
    }

    daily_journals {
        bigint id PK
        bigint user_id FK
        bigint mentor_id FK
        date journal_date
        string activity_title
        text activity_detail
        text challenges
        text solution
        string evidence_photo
        string commit_url
        string status
        text mentor_feedback
    }

    tasks {
        bigint id PK
        bigint mentor_id FK
        bigint batch_id FK
        string title
        text description
        date deadline
        string priority
        string status
    }

    task_submissions {
        bigint id PK
        bigint task_id FK
        bigint user_id FK
        string repo_url
        text notes
        int score
        string status
    }

    showcase_projects {
        bigint id PK
        bigint batch_id FK
        bigint creator_id FK
        string title
        string project_category
        string tech_stack
        string team_members
        text short_description
        string status
        string repo_url
        string live_url
    }

    evaluations {
        bigint id PK
        bigint user_id FK
        bigint mentor_id FK
        int technical_skill
        int discipline
        int teamwork
        int initiative
        decimal final_score
        string grade
        string certificate_number
        date issue_date
        boolean is_published
    }

    pkl_registrations {
        bigint id PK
        bigint user_id FK
        string registration_code UK
        string full_name
        string nis
        string email
        string school_origin
        string skill_competency
        string status
    }

    partner_institutions {
        bigint id PK
        string name
        string pic_name
        string pic_phone
        string address
    }

    app_settings {
        bigint id PK
        string key UK
        text value
    }
```

---

## Ringkasan Relasi Utama

1. **Pivot Angkatan, Peserta, Mentor, Nilai & Sertifikat (`batches` $\leftrightarrow$ `batch_students` $\leftrightarrow$ `users`)**:
   - Satu peserta (`users.id`) dapat mengikuti lebih dari satu angkatan PKL (`batches.id`), misalnya saat SMK dan saat Kuliah.
   - Setiap keikutsertaan tercatat di `batch_students` dengan `mentor_id`, nilai 4 pilar (`technical_skill`, `discipline`, `teamwork`, `initiative`), `final_score`, `grade`, dan `certificate_number` yang berdiri sendiri per angkatan.
2. **Proyek Angkatan (`batches` $\rightarrow$ `showcase_projects`)**:
   - Setiap angkatan dapat memiliki lebih dari 1 proyek digital (`creator_id` + `team_members`).
3. **Logbook & Penugasan (`users` $\rightarrow$ `daily_journals`, `tasks`, `task_submissions`)**:
   - Logbook harian siswa diverifikasi oleh mentor pembimbing (`mentor_id`, `mentor_feedback`, `status`).
4. **Pengaturan Sistem (`app_settings`)**:
   - Menyimpan konfigurasi dinamis seperti `director_name`, `director_signature_name`, dan `director_title` untuk tanda tangan E-Sertifikat.
