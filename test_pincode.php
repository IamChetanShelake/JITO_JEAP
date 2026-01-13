<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Chapter;
use Illuminate\Support\Facades\DB;

echo "=== Chapter Database Check ===\n";

// Check all chapters
$chapters = Chapter::all();
echo "Total chapters: " . $chapters->count() . "\n";

foreach ($chapters as $chapter) {
    echo "Chapter: {$chapter->chapter_name} (ID: {$chapter->id})\n";
    echo "  Pincode column: '{$chapter->pincode}'\n";
    echo "  Status: {$chapter->status}, Show/Hide: {$chapter->show_hide}\n";

    // Check relationships
    $pincodes = $chapter->pincodes;
    if ($pincodes->count() > 0) {
        echo "  Related pincodes:\n";
        foreach ($pincodes as $pincode) {
            echo "    - {$pincode->pincode}\n";
        }
    } else {
        echo "  No related pincodes\n";
    }
    echo "\n";
}

// Specific check for pincode 425409
echo "=== Checking pincode 425409 ===\n";
$testPincode = '425409';

// Check exact match queries
$queries = [
    'Relationship check' => Chapter::whereHas('pincodes', fn($q) => $q->where('pincode', $testPincode)),
    'Exact column match' => Chapter::where('pincode', $testPincode),
    'Starts with' => Chapter::where('pincode', 'like', $testPincode . ',%'),
    'Contains' => Chapter::where('pincode', 'like', '%,' . $testPincode . ',%'),
    'Ends with' => Chapter::where('pincode', 'like', '%,' . $testPincode),
];

foreach ($queries as $name => $query) {
    $query = $query->where('status', true)->where('show_hide', true);
    $count = $query->count();
    echo "{$name}: {$count} chapters found\n";

    if ($count > 0) {
        $chapters = $query->get();
        foreach ($chapters as $chapter) {
            echo "  Found: {$chapter->chapter_name} (pincode: '{$chapter->pincode}')\n";
        }
    }
}

echo "\n=== Combined Query Test ===\n";
$combinedQuery = Chapter::where(function ($query) use ($testPincode) {
    $query->whereHas('pincodes', fn ($q) => $q->where('pincode', $testPincode))
          ->orWhere('pincode', $testPincode)
          ->orWhere('pincode', 'like', $testPincode . ',%')
          ->orWhere('pincode', 'like', '%,' . $testPincode . ',%')
          ->orWhere('pincode', 'like', '%,' . $testPincode);
})
->where('status', true)
->where('show_hide', true);

echo "Combined query SQL: " . $combinedQuery->toSql() . "\n";
echo "Combined query bindings: " . json_encode($combinedQuery->getBindings()) . "\n";

$result = $combinedQuery->first();
if ($result) {
    echo "Combined query found: {$result->chapter_name} (pincode: '{$result->pincode}')\n";
} else {
    echo "Combined query found nothing\n";
}
