<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$student = App\Models\User::where('account_id', '20239')->first();
echo "Student ID: " . $student->id . PHP_EOL;
echo "Name: " . $student->name . PHP_EOL;
echo "Avatar raw attribute: " . $student->avatar . PHP_EOL;
echo "Avatar accessor/property: " . json_encode($student->avatar) . PHP_EOL;
echo "JSON student avatar: " . json_decode(json_encode($student))->avatar . PHP_EOL;
