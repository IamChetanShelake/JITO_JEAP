<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Checking anniversary_photo in donor_personal_details table:\n\n";

$records = DB::connection('admin_panel')
    ->table('donor_personal_details')
    ->select('id', 'anniversary_photo', 'birth_photo')
    ->get();

foreach ($records as $record) {
    echo "ID: " . $record->id . "\n";
    echo "anniversary_photo (raw): " . var_export($record->anniversary_photo, true) . "\n";
    echo "birth_photo (raw): " . var_export($record->birth_photo, true) . "\n";
    echo "---\n";
}
