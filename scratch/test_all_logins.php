<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$testLogins = [
    ['role' => 'admin_tms', 'id' => 'admin', 'password' => 'tmsadmin123'],
    ['role' => 'mentor', 'id' => '27848', 'password' => 'tmshebatsukses'],
    ['role' => 'mentor', 'id' => 'mentortest', 'password' => 'tmshebatsukses'],
    ['role' => 'siswa', 'id' => '20239', 'password' => 'tmshebatsukses'],
    ['role' => 'siswa', 'id' => 'pradipta', 'password' => 'tmshebatsukses'],
    ['role' => 'siswa', 'id' => '19468', 'password' => 'tmshebatsukses'],
];

foreach ($testLogins as $t) {
    $user = App\Models\User::where('account_id', $t['id'])
        ->orWhere('username', $t['id'])
        ->orWhere('email', $t['id'])
        ->first();

    if ($user && \Illuminate\Support\Facades\Hash::check($t['password'], $user->password)) {
        $canLogin = !($user->role === 'siswa' && (empty($user->account_id) || empty($user->mentor_id)));
        echo "Check [{$t['role']}] ID: '{$t['id']}' | User: '{$user->name}' -> " . ($canLogin ? "SUCCESS (Ready to login)" : "BLOCKED (Missing account_id or mentor_id)") . "\n";
    } else {
        echo "Check [{$t['role']}] ID: '{$t['id']}' -> FAILED (User or password mismatch)\n";
    }
}
