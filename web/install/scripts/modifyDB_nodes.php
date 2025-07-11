<?php
$jsonSchemaFile = './sql/db.json';  // Your JSON file path
$schemaJson = file_get_contents($jsonSchemaFile);
if (!$schemaJson) {
    die("[ERROR] Failed to load JSON schema file.<br>");
}
$schema = json_decode($schemaJson, true);
if (!$schema) {
    die("[ERROR] Failed to decode JSON schema.<br>");
}

echo "[INFO] Loaded JSON schema.<br>";

foreach ($schema as $table => $columns) {
    echo "<br>[INFO] Validating table: '$table'<br>";

    // Check if table exists
    $res = $sql->query("SHOW TABLES LIKE '" . $sql->real_escape_string($table) . "'");
    $tableExists = ($res && $res->num_rows > 0);

    if (!$tableExists) {
        echo "[WARN] Table '$table' does not exist. Creating empty table...<br>";
        // Create empty table with just a primary key column or id (adjust as needed)
        // For example: create a table with the first column as primary key if exists
        $primaryKeyCol = null;
        foreach ($columns as $colName => $colProps) {
            // Pick the first column marked NOT NULL or just the first column as primary key
            $primaryKeyCol = $colName;
            break;
        }
        if ($primaryKeyCol) {
            $colType = $columns[$primaryKeyCol]['type'];
            $sqlCreate = "CREATE TABLE `$table` (`$primaryKeyCol` $colType PRIMARY KEY) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            if ($sql->query($sqlCreate)) {
                echo "[PASS] Created empty table '$table' with column '$primaryKeyCol'.<br>";
            } else {
                echo "[FAIL] Failed to create table '$table': " . $sql->error . "<br>";
                continue;
            }
        } else {
            echo "[FAIL] No columns found to create table '$table'. Skipping.<br>";
            continue;
        }
    } else {
        echo "[INFO] Table '$table' exists.<br>";
    }

    // Fetch existing columns info
    $existingColsRes = $sql->query("SHOW COLUMNS FROM `$table`");
    $existingCols = [];
    while ($row = $existingColsRes->fetch_assoc()) {
        $existingCols[$row['Field']] = $row;
    }

    // Check each column in schema
    foreach ($columns as $colName => $colProps) {
        if (isset($existingCols[$colName])) {
            echo "[SKIP] Column '$colName' already exists in table '$table'.<br>";
            // Optionally: compare column types and attributes here to ALTER if needed
            continue;
        }

        // Build the column definition SQL for ALTER TABLE ADD COLUMN
        $colSql = "`$colName` " . $colProps['type'];

        if (!empty($colProps['not_null'])) {
            $colSql .= " NOT NULL";
        } else {
            $colSql .= " NULL";
        }

        if (isset($colProps['default'])) {
            $default = $colProps['default'];
            if (is_string($default)) {
                $default = "'" . $sql->real_escape_string($default) . "'";
            }
            $colSql .= " DEFAULT " . $default;
        }

        if (!empty($colProps['auto_increment'])) {
            $colSql .= " AUTO_INCREMENT";
        }

        // Run ALTER TABLE to add the column
        $alterSql = "ALTER TABLE `$table` ADD COLUMN $colSql";
        echo "[DEBUG] Running SQL: $alterSql<br>";

        if ($sql->query($alterSql)) {
            echo "[PASS] Added column '$colName' to table '$table'.<br>";
        } else {
            echo "[FAIL] Failed to add column '$colName' to table '$table': " . $sql->error . "<br>";
        }
    }
}

echo "<br>[DONE] Schema sync complete.<br>";
?>
