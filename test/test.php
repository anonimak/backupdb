<?php 
require_once "../Conn.php";
require_once "../backup.php";

$conn = new Conn;
$pdo = $conn->db;

$filePath = '/database/backup/'.time().'.sql';
$tables = ['districts'];

backupDatabaseTables($pdo, $tables, $filePath);

?>