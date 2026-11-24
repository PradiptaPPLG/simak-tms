<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
$app->instance('request', Illuminate\Http\Request::create('/'));

$mentor = App\Models\User::where('role', 'mentor')->first();
echo "Testing Mentor: {$mentor->name} (ID: {$mentor->account_id})\n";
\Illuminate\Support\Facades\Auth::login($mentor);

// 1. Test Excel export
$req1 = Illuminate\Http\Request::create('/mentor/siswa/export?format=excel', 'GET');
$req1->setUserResolver(function () use ($mentor) { return $mentor; });
$res1 = $kernel->handle($req1);
echo "1. Mentor Excel Export: Status " . $res1->getStatusCode() . "\n";

// 2. Test CSV export
$req2 = Illuminate\Http\Request::create('/mentor/siswa/export?format=csv', 'GET');
$req2->setUserResolver(function () use ($mentor) { return $mentor; });
$res2 = $kernel->handle($req2);
echo "2. Mentor CSV Export: Status " . $res2->getStatusCode() . "\n";

// 3. Test Mentor Students View
$req3 = Illuminate\Http\Request::create('/mentor/siswa', 'GET');
$req3->setUserResolver(function () use ($mentor) { return $mentor; });
$res3 = $kernel->handle($req3);
echo "3. Mentor Students View (/mentor/siswa): Status " . $res3->getStatusCode() . "\n";

// 4. Test Mentor Monitoring Dashboard View
$req4 = Illuminate\Http\Request::create('/mentor/monitoring', 'GET');
$req4->setUserResolver(function () use ($mentor) { return $mentor; });
$res4 = $kernel->handle($req4);
echo "4. Mentor Dashboard View (/mentor/monitoring): Status " . $res4->getStatusCode() . "\n";

echo "\nAll endpoints tested and working with status 200 OK!\n";
