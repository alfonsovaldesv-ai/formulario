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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

try {
    $query = "SELECT * FROM bodega";
    $result = $pdo->query($query);
  
    $bodegas = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $bodegas[] = $row['nombre_bodega'];
    }
  
    echo json_encode(["status" => "ok", "bodegas" => $bodegas]);
  } catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
  }