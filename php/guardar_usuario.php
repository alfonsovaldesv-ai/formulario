<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$port = '5432';
$db   = 'productos';
$user = 'postgres';
$pass = 'postgres';
$dsn  = "pgsql:host=$host;port=$port;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");

if ($nombre !== "") {
    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre) VALUES (:nombre)");
    $stmt->execute([':nombre' => $nombre]);
}

// Traer todos los nombres
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($usuarios);
