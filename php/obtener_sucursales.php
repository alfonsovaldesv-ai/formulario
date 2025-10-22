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
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $e->getMessage()]);
    exit;
}

// 📥 Recibir el parámetro GET
$bodega = $_GET['bodega'] ?? null;

if (!$bodega) {
    echo json_encode(["status" => "error", "message" => "Falta el parámetro 'bodega'."]);
    exit;
}

try {
    // ✅ Consulta parametrizada
    $query = "SELECT nombre_sucursal 
    FROM sucursal 
    WHERE id_bodega = (
        SELECT id_bodega FROM bodega WHERE nombre_bodega = :bodega
    )";
;

    $stmt = $pdo->prepare($query);
    $stmt->execute(['bodega' => $bodega]);

    // Solo obtener los nombres como arreglo plano
    $sucursales = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(["status" => "ok", "sucursales" => $sucursales]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $e->getMessage()]);
}
