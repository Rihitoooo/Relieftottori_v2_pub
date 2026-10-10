<?php

$host = 'dummy';
$port = 'dummy';

$dbname = 'dummy';
$user = 'dummy';
$password = 'dummy';

try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    echo '<script>console.log("PostgreSQL 接続成功");</script>';

} catch (PDOException $e) {

    echo '<script>';
    echo 'console.error("DB接続失敗:", ' . json_encode($e->getMessage()) . ');';
    echo '</script>';

    exit;
}