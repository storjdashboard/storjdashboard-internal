<?php
$sqlFile = __DIR__ . '/schema.sql'; // Your exported SQL schema file

// ---- LOAD AND PARSE SCHEMA ----
$schema = file_get_contents($sqlFile);

// Extract table + column definitions from SQL dump
preg_match_all('/CREATE TABLE IF NOT EXISTS `([^`]+)` \((.*?)\)[\s\S]+?;/m', $schema, $matches, PREG_SET_ORDER);

$desiredSchema = [];
foreach ($matches as $tableMatch) {
    $tableName = $tableMatch[1];
    $columnsSql = $tableMatch[2];

    preg_match_all('/`([^`]+)`\s+([a-zA-Z0-9\(\)\s]+)(?:\s+DEFAULT\s+[^,]+)?(?:\s+NOT\s+NULL)?(?:\s+AUTO_INCREMENT)?/i', $columnsSql, $colMatches, PREG_SET_ORDER);

    $desiredSchema[$tableName] = [];
    foreach ($colMatches as $col) {
        $colName = $col[1];
        $colType = trim($col[2]);
        $desiredSchema[$tableName][$colName] = $colType;
    }
}

// ---- GET ACTUAL DATABASE STRUCTURE ----
function getExistingColumns($mysqli, $table, $database) {
    $columns = [];
    $stmt = $mysqli->prepare("
        SELECT COLUMN_NAME, COLUMN_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
    ");
    $stmt->bind_param("ss", $database, $table);
    $stmt->execute();
    $stmt->bind_result($colName, $colType);
    while ($stmt->fetch()) {
        $columns[$colName] = $colType;
    }
    $stmt->close();
    return $columns;
}

// ---- COMPARE AND UPDATE DATABASE ----
foreach ($desiredSchema as $table => $expectedColumns) {

    // Check if table exists
    $checkTable = $mysqli->prepare("SHOW TABLES LIKE ?");
    $checkTable->bind_param("s", $table);
    $checkTable->execute();
    $result = $checkTable->get_result();
    $exists = $result->num_rows > 0;
    $checkTable->close();

    if (!$exists) {
        // Create table directly from schema snippet
        preg_match('/(CREATE TABLE IF NOT EXISTS `' . preg_quote($table, '/') . '` .*?;)/s', $schema, $tableSQL);
        if (isset($tableSQL[1])) {
            echo "[UPDATE] Creating table '$table'..." . PHP_EOL;
            if ($mysqli->query($tableSQL[1])) {
                echo "[PASS] Created table '$table'." . PHP_EOL;
            } else {
                echo "[FAIL] Failed to create table '$table': " . $mysqli->error . PHP_EOL;
            }
        }
        continue;
    }

    // Table exists — check for missing columns
    $existingColumns = getExistingColumns($mysqli, $table, $database);

    foreach ($expectedColumns as $colName => $colType) {
        if (!array_key_exists($colName, $existingColumns)) {
            $alterSQL = "ALTER TABLE `$table` ADD COLUMN `$colName` $colType";
            echo "[UPDATE] Adding column '$colName' to '$table'..." . PHP_EOL;
            if ($mysqli->query($alterSQL)) {
                echo "[PASS] Column '$colName' added to '$table'." . PHP_EOL;
            } else {
                echo "[FAIL] Failed to add column '$colName' to '$table': " . $mysqli->error . PHP_EOL;
            }
        }
    }
}
?>
