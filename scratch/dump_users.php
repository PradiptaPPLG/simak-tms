<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::with(['batch', 'mentor', 'evaluation', 'enrolledBatches'])->get();
foreach ($users as $u) {
    echo "ID: {$u->id} | Role: {$u->role} | Account ID: {$u->account_id} | Username: {$u->username} | Name: {$u->name} | Email: {$u->email} | Mentor: " . ($u->mentor ? $u->mentor->name : 'None') . " | Batch: " . ($u->batch ? $u->batch->batch_name : 'None') . " | Status: {$u->status}\n";
}
echo "\nTotal users: " . $users->count() . "\n";
