<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::all();
foreach ($users as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | Account ID: {$u->account_id} | Raw Hash: " . var_export($u->getRawOriginal('profile_hash'), true) . "\n";
    if (empty($u->getRawOriginal('profile_hash'))) {
        $u->profile_hash = App\Models\User::generateUniqueProfileHash();
        $u->saveQuietly();
        echo "  -> Generated & Saved Hash: {$u->profile_hash}\n";
    }
}
