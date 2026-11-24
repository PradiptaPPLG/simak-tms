<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('account_id', '20239')->first();
$candidates = [
    'tmshebatsukses', 'tmsadmin123', 'password', '12345678', 'admin123', 'pradipta123',
    '20239', 'smkn1ciamis', 'pradipta02032009', 'pradipta', 'maspkl2026'
];
foreach ($candidates as $c) {
    if (\Illuminate\Support\Facades\Hash::check($c, $u->password)) {
        echo "Found password for Pradipta: $c\n";
        exit;
    }
}
echo "Not in common list\n";
