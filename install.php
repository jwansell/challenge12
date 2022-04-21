<?php

echo 'Starting Install...<br />';

require_once __DIR__ . '/bootstrap.php';

// Once we are here we should execute the database.sql file
global $connection;
echo 'Installing...<br />';
$connection->exec(file_get_contents(__DIR__ . '/src/sql/database.sql')); // TODO this is an unsafe operation
echo 'Checking install...<br />';
// We need to then verify that the tables are there
$result = $connection->query('SHOW tables');
$tables = $result->fetchAll();
$expectedTables = [
    'users',
    'contacts'
];
$tables = array_map(function ($table) {
    return $table[0];
}, $tables);
$missing = false;
foreach ($expectedTables as $table) {
    if (!in_array($table, $tables)) {
        $missing = true;
        echo "Missing expected table: $table<br />";
    }
}
if (!$missing) echo 'Finished install!';
else echo 'Installation failed';
