<?php
require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Get first 5 users with role 'user'
$users = User::where('role', 'user')->take(5)->get();

echo "Available users:\n";
foreach ($users as $user) {
    echo "ID: " . $user->id . " - Name: " . $user->name . "\n";
}

echo "\nTest completed!\n";