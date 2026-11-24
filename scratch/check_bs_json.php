<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$bs = App\Models\BatchStudent::with('student')->where('student_id', 11)->first();
if (!$bs) {
    $bs = App\Models\BatchStudent::with('student')->first();
}
echo "BS ID: " . $bs->id . PHP_EOL;
echo "BS student relation loaded: " . ($bs->student ? 'YES' : 'NO') . PHP_EOL;
echo "JSON bs: " . json_encode($bs) . PHP_EOL;
echo "JSON student: " . json_encode($bs->student) . PHP_EOL;
