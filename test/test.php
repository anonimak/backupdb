<?php 
require_once "./database/Conn.php";
require_once "../helpers/backup.php";

// buat koneksi ke database
$conn = new Conn;
$pdo = $conn->db;

// lokasi file yg dibackup dan nama filenya
$filePath = '/database/backup/'.time().'.sql';

// spesifik tabel yang akan di backup
// 
// 
// untuk detail tabel bisa spt ini
// $tables = ['nama_table1', 'nama_table2','nama_tableN'];
// 
// 
// untuk semua table
$tables = ['*'];

backupDatabaseTables($pdo, $tables, $filePath);

?>