<?php
// Support both individual DB env vars (DB_HOST/DB_PORT/DB_NAME/DB_USER/DB_PASS)
// and a single DATABASE_URL (example: mysql://user:pass@host:3306/dbname).
$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl) {
    $parts = parse_url($databaseUrl);
    $host = $parts['host'] ?? 'localhost';
    $port = isset($parts['port']) ? (int)$parts['port'] : null;
    $db   = isset($parts['path']) ? ltrim($parts['path'], '/') : (getenv('DB_NAME') ?: 'nviridian_shop');
    $user = $parts['user'] ?? getenv('DB_USER') ?: 'appuser';
    $pass = $parts['pass'] ?? getenv('DB_PASS') ?: 'app_pass';
} else {
    $host = getenv('DB_HOST') ?: 'db';
    $port = getenv('DB_PORT') ?: null;
    $db   = getenv('DB_NAME') ?: 'nviridian_shop';
    $user = getenv('DB_USER') ?: 'appuser';
    $pass = getenv('DB_PASS') ?: 'app_pass';
}

try {
    $dsn = "mysql:host={$host}";
    if (!empty($port)) {
        $dsn .= ";port={$port}";
    }
    $dsn .= ";dbname={$db};charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
