<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\User::where('account_id', '20239')->first();
$path = public_path($student->avatar);
echo "Path: " . $path . PHP_EOL;
echo "Exists: " . (file_exists($path) ? 'YES' : 'NO') . PHP_EOL;

// List files in public/uploads and public/uploads/avatars
$uploadsDir = public_path('uploads');
echo "Uploads dir exists: " . (is_dir($uploadsDir) ? 'YES' : 'NO') . PHP_EOL;
if (is_dir($uploadsDir)) {
    print_r(scandir($uploadsDir));
}
$avatarsDir = public_path('uploads/avatars');
echo "Avatars dir exists: " . (is_dir($avatarsDir) ? 'YES' : 'NO') . PHP_EOL;
if (is_dir($avatarsDir)) {
    print_r(scandir($avatarsDir));
}
