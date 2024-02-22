<?php
$host = '127.0.0.1';  // Your MySQL host, 127.0.0.1 is the localhost
$port = '3307';       // Your MySQL port, 3307 as per your configuration
$db   = 'ethos_data'; // Your database name
$user = 'root';      // Your database username
$pass = 'Eth!2020';      // Your database password
$charset = 'utf8mb4';         // Set the charset

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
