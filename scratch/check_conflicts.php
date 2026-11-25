<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\DailyJournal;

$user = User::where('account_id', '20239')->first();
$journals = DailyJournal::where('user_id', $user->id)->get();

echo "User: " . $user->name . " (Off days: " . json_encode($user->routine_off_days) . ")\n";
echo "Total journals: " . $journals->count() . "\n";

$conflicts = [];
foreach ($journals as $j) {
    $d = substr((string)$j->journal_date, 0, 10);
    $isOff = $user->isOffDay($d);
    $dayName = \Carbon\Carbon::parse($d)->translatedFormat('l');
    if ($isOff) {
        $conflicts[] = $j;
        echo "[NABRAK LIBUR] ID: {$j->id} | Tanggal: {$d} ({$dayName}) | Judul: {$j->activity_title}\n";
    } else {
        echo "[AMAN HARI KERJA] ID: {$j->id} | Tanggal: {$d} ({$dayName}) | Judul: {$j->activity_title}\n";
    }
}

echo "Total konflik nabrak hari libur: " . count($conflicts) . "\n";
