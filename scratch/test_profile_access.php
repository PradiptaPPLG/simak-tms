<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
$app->instance('request', Illuminate\Http\Request::create('/'));

$user = App\Models\User::where('role', 'siswa')->first();
echo "User: " . $user->name . "\n";
echo "Profile Hash in DB: " . var_export($user->getRawOriginal('profile_hash'), true) . "\n";
echo "Computed Hash: " . $user->profile_hash . "\n";
echo "Profile URL: " . $user->profile_url . "\n";

$req1 = Illuminate\Http\Request::create('/profile/' . $user->profile_hash, 'GET');
$res1 = $kernel->handle($req1);
echo "Status /profile/{hash}: " . $res1->getStatusCode() . "\n";
if ($res1->isRedirection()) {
    echo "Redirects to: " . $res1->headers->get('Location') . "\n";
}

// Test with empty session / unauthenticated request to /profile
$req2 = Illuminate\Http\Request::create('/profile', 'GET');
$res2 = $kernel->handle($req2);
echo "Status /profile: " . $res2->getStatusCode() . " -> Redirects to: " . $res2->headers->get('Location') . "\n";

if ($user->evaluation) {
    echo "Certificate number: " . $user->evaluation->certificate_number . "\n";
    $req3 = Illuminate\Http\Request::create('/verifikasi/' . $user->evaluation->certificate_number, 'GET');
    $res3 = $kernel->handle($req3);
    echo "Status /verifikasi/{cert}: " . $res3->getStatusCode() . "\n";
}
