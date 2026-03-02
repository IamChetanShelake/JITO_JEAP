<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

$db = $app->make('db');
$connection = $db->connection('admin_panel');

try {
    // Check if table exists
    $tables = $connection->getDoctrineSchemaManager()->listTableNames();
    if (in_array('donation_commitments', $tables)) {
        echo "✓ donation_commitments table already exists\n";
    } else {
        echo "✗ donation_commitments table does not exist. Creating...\n";
        $connection->statement("
            CREATE TABLE `donation_commitments` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `donor_id` bigint unsigned NOT NULL,
                `committed_amount` decimal(15, 2) NOT NULL,
                `start_date` date NULL,
                `end_date` date NULL,
                `status` enum('active', 'completed', 'cancelled') NOT NULL DEFAULT 'active',
                `created_at` timestamp NULL,
                `updated_at` timestamp NULL,
                KEY `donation_commitments_donor_id_foreign` (`donor_id`),
                KEY `donation_commitments_donor_id_status_index` (`donor_id`, `status`),
                CONSTRAINT `donation_commitments_donor_id_foreign` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "✓ donation_commitments table created successfully\n";
    }

    // Verify columns
    $columns = $connection->getDoctrineSchemaManager()->listTableColumns('donation_commitments');
    echo "\nTable columns:\n";
    foreach (array_keys($columns) as $col) {
        echo "  - $col\n";
    }
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
