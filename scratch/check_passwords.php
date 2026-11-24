<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
foreach ($users as $u) {
    echo "User: {$u->name} ({$u->role}) | Login ID: {$u->account_id} / {$u->username} / {$u->email}\n";
    $passwords = ['password', 'tmsadmin123', 'tmshebatsukses', '12345678'];
    $matched = [];
    foreach ($passwords as $p) {
        if (\Illuminate\Support\Facades\Hash::check($p, $u->password)) {
            $matched[] = $p;
        }
    }
    echo "  Matched passwords: " . (count($matched) ? implode(', ', $matched) : 'CUSTOM / UNKNOWN') . "\n";
}
