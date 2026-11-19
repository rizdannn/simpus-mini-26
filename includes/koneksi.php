<?php
$config = require __DIR__ . '/config.php';

try {
    $dsn = "pgsql:host={$config['db_host']};"
         . "port={$config['db_port']};"
         . "dbname={$config['db_name']};"
         . "sslmode={$config['db_sslmode']}";

    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Detail error hanya masuk log server, jangan ditampilkan ke pengunjung.
    error_log('Koneksi database gagal: ' . $e->getMessage());
    http_response_code(500);
    exit('Koneksi database tidak tersedia. Silakan coba kembali.');
}