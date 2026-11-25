<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('account_id', '20239')->first();
if (!$user) {
    die("User 20239 not found\n");
}

// Test setting routine off days
$user->routine_off_days = [6, 7];
$user->off_day_notes = 'Libur Akhir Pekan (Sabtu & Minggu)';
$user->save();

echo "User updated successfully.\n";
echo "Routine off days: " . json_encode($user->routine_off_days) . "\n";
echo "Off day notes: " . $user->off_day_notes . "\n";
echo "Has configured off days? " . ($user->hasConfiguredOffDays() ? 'YES' : 'NO') . "\n";
echo "Off days labels: " . implode(', ', $user->off_days_labels) . "\n";

echo "Is 2026-11-21 (Saturday) off day? " . ($user->isOffDay('2026-11-21') ? 'YES' : 'NO') . "\n";
echo "Is 2026-11-22 (Sunday) off day? " . ($user->isOffDay('2026-11-22') ? 'YES' : 'NO') . "\n";
echo "Is 2026-11-23 (Monday) off day? " . ($user->isOffDay('2026-11-23') ? 'YES' : 'NO') . "\n";
echo "Is 2026-11-24 (Tuesday) off day? " . ($user->isOffDay('2026-11-24') ? 'YES' : 'NO') . "\n";

// Test HTTP request to /jurnal as authenticated user
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Auth::login($user);
$controller = $app->make(App\Http\Controllers\SimakController::class);
$req = Request::create('/jurnal', 'GET', ['date' => '2026-11-21']);
$req->setUserResolver(fn() => $user);

$view = $controller->journals($req);
$rendered = $view->render();

echo "\n--- View Render Check ---\n";
echo "Contains 'Hari Libur / Off Shift'? " . (str_contains($rendered, 'Hari Libur / Off Shift') ? 'YES' : 'NO') . "\n";
echo "Contains 'user-x'? " . (str_contains($rendered, 'user-x') ? 'YES' : 'NO') . "\n";
echo "Contains 'Atur Hari Libur'? " . (str_contains($rendered, 'Atur Hari Libur') ? 'YES' : 'NO') . "\n";
echo "Contains 'modal-jadwal-libur'? " . (str_contains($rendered, 'modal-jadwal-libur') ? 'YES' : 'NO') . "\n";

// Check button for 21 in rendered HTML
preg_match('/<a[^>]*2026-11-21[^>]*>.*?<\/a>/s', $rendered, $m21);
if ($m21) {
    echo "\nTile for 21:\n" . $m21[0] . "\n";
}

// Check button for 22 in rendered HTML
preg_match('/<a[^>]*2026-11-22[^>]*>.*?<\/a>/s', $rendered, $m22);
if ($m22) {
    echo "\nTile for 22:\n" . $m22[0] . "\n";
}
