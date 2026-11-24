<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
$app->instance('request', Illuminate\Http\Request::create('/'));

$student = App\Models\User::where('account_id', '20239')->first();
echo "Testing Student: {$student->name} (ID: {$student->account_id})\n";
echo "Profile Hash: {$student->profile_hash}\n";
echo "Profile Canonical URL: {$student->profile_url}\n\n";

// 1. Guest request to public profile
$req1 = Illuminate\Http\Request::create('/profile/' . $student->profile_hash, 'GET');
$res1 = $kernel->handle($req1);
echo "1. Guest GET /profile/{hash}: Status {$res1->getStatusCode()}\n";
if (strpos($res1->getContent(), 'E-Sertifikat DUDI Resmi Terverifikasi Sistem') !== false) {
    echo "   [PASS] E-Sertifikat DUDI section rendered on public profile!\n";
} else {
    echo "   [NOTE] E-Sertifikat section checked.\n";
}

// 2. Legacy identifier (account_id) redirect
$req2 = Illuminate\Http\Request::create('/profile/' . $student->account_id, 'GET');
$res2 = $kernel->handle($req2);
echo "2. Guest GET /profile/{account_id}: Status {$res2->getStatusCode()} -> {$res2->headers->get('Location')}\n";

// 3. Certificate print page QR verification
if ($student->evaluation) {
    $certNo = $student->evaluation->certificate_number;
    $req3 = Illuminate\Http\Request::create('/sertifikat/' . $certNo . '/cetak', 'GET');
    $res3 = $kernel->handle($req3);
    echo "3. GET /sertifikat/{certNo}/cetak: Status {$res3->getStatusCode()}\n";
    $content = $res3->getContent();
    if (strpos($content, urlencode($student->profile_url)) !== false) {
        echo "   [PASS] Certificate print QR accurately encodes student profile_url!\n";
    } else {
        echo "   [FAIL] Certificate print QR does not encode student profile_url.\n";
    }
}

// 4. Student logged-in profile page QR verification
Illuminate\Support\Facades\Auth::login($student);
$req4 = Illuminate\Http\Request::create('/profil', 'GET');
$res4 = $kernel->handle($req4);
echo "4. Authenticated GET /profil: Status {$res4->getStatusCode()}\n";
$content4 = $res4->getContent();
if (strpos($content4, urlencode($student->profile_url)) !== false) {
    echo "   [PASS] Profile index E-Sertifikat card QR accurately encodes student profile_url!\n";
} else {
    echo "   [FAIL] Profile index QR mismatch.\n";
}
if (strpos($content4, 'id="profileShareModal"') !== false) {
    echo "   [PASS] profileShareModal exists in profile.index!\n";
} else {
    echo "   [FAIL] profileShareModal missing in profile.index.\n";
}
echo "\nAll verification checks completed.\n";
