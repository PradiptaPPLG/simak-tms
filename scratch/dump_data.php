<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

echo "--- PARTNER INSTITUTIONS ---\n";
print_r(\DB::table('partner_institutions')->get()->toArray());

echo "--- BATCHES ---\n";
print_r(\DB::table('batches')->get()->toArray());

echo "--- BATCH_STUDENTS ---\n";
print_r(\DB::table('batch_students')->get()->toArray());

echo "--- EVALUATIONS ---\n";
print_r(\DB::table('evaluations')->get()->toArray());

echo "--- DAILY_JOURNALS ---\n";
print_r(\DB::table('daily_journals')->get()->toArray());

echo "--- SHOWCASE_PROJECTS ---\n";
print_r(\DB::table('showcase_projects')->get()->toArray());
