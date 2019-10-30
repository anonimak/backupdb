<?php
/**
 * Perform MySQL Database Backup
 *
 * @param $pdo
 * @param string $tables
 * @param string $filePath
 * @return bool
 */
function backupDatabaseTables($pdo, $tables = '*', $filePath = '/')
{
	try {
		
		// Get all of the tables
		if ($tables == '*') {
			$tables = [];
			$query = $pdo->query('SHOW TABLES');
			while ($row = $query->fetch()) {
				$tables[] = $row[0];
				
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',', $tables);
		}
		
		if (empty($tables)) {
			return false;
		}
		
		$out = '';
		
		// Loop through the tables
		foreach ($tables as $table) {
			$query = $pdo->query('SELECT * FROM ' . $table);
			$numColumns = $query->columnCount();
			
			// Add DROP TABLE statement
			$out .= 'DROP TABLE ' . $table . ';' . "\n\n";
			
			// Add CREATE TABLE statement
			$query2 = $pdo->query('SHOW CREATE TABLE ' . $table);
			$row2 = $query2->fetch();
			$out .= $row2[1] . ';' . "\n\n";
			
			// Add INSERT INTO statements
			for ($i = 0; $i < $numColumns; $i++) {
				while ($row = $query->fetch()) {
					$out .= "INSERT INTO $table VALUES(";
					for ($j = 0; $j < $numColumns; $j++) {
						$row[$j] = addslashes($row[$j]);
						$row[$j] = preg_replace("/\n/us", "\\n", $row[$j]);
						if (isset($row[$j])) {
							$out .= '"' . $row[$j] . '"';
						} else {
							$out .= '""';
						}
						if ($j < ($numColumns - 1)) {
							$out .= ',';
						}
					}
					$out .= ');' . "\n";
				}
			}
			$out .= "\n\n\n";
		}
		
		// Save file
		file_put_contents(__DIR__ . $filePath, $out);
		
	} catch (\Exception $e) {
		echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
		return false;
	}
	
	return true;
}

?>