<?php

require_once 'model/DatabaseConnection.php';

define('BACKUP_DIR', 'backups');


// Get all backups
$files = scandir(BACKUP_DIR);
$backups = [];
foreach ($files as $file)
	if (strpos($file, 'backup_') === 0)
		$backups[] = $file;

// Sort the backups by date (most recent first)
usort($backups, function($a, $b) {
	$dateStrA = str_replace(['backup_', '.sql'], '', $a);
	$timestampA = DateTime::createFromFormat('Y-m-d_H-i-s', $dateStrA)->getTimestamp();
	$dateStrB = str_replace(['backup_', '.sql'], '', $b);
	$timestampB = DateTime::createFromFormat('Y-m-d_H-i-s', $dateStrB)->getTimestamp();
	return $timestampB - $timestampA;
});

// Create a new backup if there are no backups or if the most recent backup is more than a week old
if(empty($backups) ||
	DateTime::createFromFormat('Y-m-d_H-i-s', str_replace(['backup_', '.sql'], '', $backups[0]))->getTimestamp() < time() - 7 * 24 * 60 * 60) {
	// Create a new backup
	$database = new DatabaseConnection();

	$backupFile = BACKUP_DIR . '/backup_' . date('Y-m-d_H-i-s') . '.sql';
	$fileHandle = fopen($backupFile, 'w');

	// Get all tables
	$tables = $database->execute('SHOW TABLES');

	// Loop through all tables
	foreach ($tables as $tableRow) {
		$tableName = $tableRow["Tables_in_compta"];

		// Write the table structure
		$createTableResult = $database->execute("SHOW CREATE TABLE $tableName");
		$createTableSql = $createTableResult[0]["Create Table"];
		fwrite($fileHandle, "\n\n" . $createTableSql . ";\n\n");

		// Write the table data
		$rows = $database->execute("SELECT * FROM $tableName");
		foreach ($rows as $row) {
			$rowValues = array_map(function($value) {
				return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
			}, $row);
			$rowValuesString = implode(", ", $rowValues);
			fwrite($fileHandle, "INSERT INTO $tableName VALUES ($rowValuesString);\n");
		}
	}

	fclose($fileHandle);


	// Delete older backup if there are more than 3 backups
	if(count($backups) >= 3)
		unlink(BACKUP_DIR . '/' . $backups[count($backups) - 1]);


	// Save the backup on Git
	chdir(BACKUP_DIR);
	shell_exec('git add .');
	shell_exec('git commit -m "Automatic backup ' . date('Y-m-d H:i:s') . '"');
	shell_exec('git push');
	chdir('..');
}
