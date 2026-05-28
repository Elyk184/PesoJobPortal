<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = app('db');
$columns = $db->select("DESCRIBE jobseeker_profiles");

echo "Jobseeker Profiles Table Structure:\n";
echo "=====================================\n";

foreach ($columns as $col) {
    echo $col->Field . " (" . $col->Type . ")" . PHP_EOL;
}
