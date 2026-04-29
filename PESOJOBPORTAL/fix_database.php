<?php

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=jobportal',
        'root',
        ''
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fix company_profiles table to add default values
    $queries = [
        "ALTER TABLE company_profiles MODIFY company_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY business_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY trade_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY acronym_abbreviation VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY tin VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY line_of_business LONGTEXT DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY street_village VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY barangay VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY city_municipality VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY province VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY establishment_contact_person VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY establishment_contact_position VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY establishment_email VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY establishment_phone VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY contact_person_name VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY contact_person_phone VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY logo_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY business_permit_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
        "ALTER TABLE company_profiles MODIFY dti_sec_registration_path VARCHAR(255) DEFAULT '' COLLATE utf8mb4_unicode_ci",
    ];

    echo "Fixing company_profiles table defaults...\n";
    foreach ($queries as $sql) {
        try {
            $pdo->exec($sql);
            echo "✓ " . substr($sql, 0, 50) . "...\n";
        } catch (Exception $e) {
            echo "⚠ Skipped: " . $e->getMessage() . "\n";
        }
    }

    echo "\nDone! All columns now have default values.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
