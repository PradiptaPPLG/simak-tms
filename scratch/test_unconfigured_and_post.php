<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$user = User::where('account_id', '20239')->first();

// 1. Test unconfigured state
$user->routine_off_days = null;
$user->off_day_notes = null;
$user->save();

Auth::login($user);
$controller = $app->make(App\Http\Controllers\SimakController::class);
$req = Request::create('/jurnal', 'GET');
$req->setUserResolver(fn() => $user);

$view = $controller->journals($req);
$rendered = $view->render();

echo "--- Test 1: Unconfigured State ---\n";
echo "Has configured off days? " . ($user->hasConfiguredOffDays() ? 'YES' : 'NO') . "\n";
echo "Notice locked displayed? " . (str_contains($rendered, 'Pengisian Jurnal Terkunci Sementara') ? 'YES' : 'NO') . "\n";
echo "Modal is visible (not hidden)? " . (str_contains($rendered, 'id="modal-jadwal-libur" class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs z-50  flex') ? 'YES' : 'NO') . "\n";

// 2. Test POST /jurnal/jadwal-libur
$postReq = Request::create('/jurnal/jadwal-libur', 'POST', [
    'routine_off_days' => ['6', '7'],
    'off_day_notes' => 'Libur Akhir Pekan (Sabtu & Minggu)',
]);
$postReq->setUserResolver(fn() => $user);

$response = $controller->updateRoutineOffDays($postReq);
echo "\n--- Test 2: Update Routine Off Days via POST ---\n";
echo "Redirect status code: " . $response->getStatusCode() . "\n";
echo "Session success message: " . session('success') . "\n";

$user->refresh();
echo "Updated routine off days: " . json_encode($user->routine_off_days) . "\n";
echo "Updated off day notes: " . $user->off_day_notes . "\n";
echo "Has configured off days now? " . ($user->hasConfiguredOffDays() ? 'YES' : 'NO') . "\n";
