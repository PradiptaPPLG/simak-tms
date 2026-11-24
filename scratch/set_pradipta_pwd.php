<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('account_id', '20239')->first();
if ($u) {
    $u->password = \Illuminate\Support\Facades\Hash::make('tmshebatsukses');
    $u->save();
    echo "Updated Pradipta password to 'tmshebatsukses' successfully!\n";
}
