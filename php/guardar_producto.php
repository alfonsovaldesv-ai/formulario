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

// Recibir datos del formulario
$codigo = trim($_POST["codigo"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$id_sucursal = $_POST["sucursal"] ?? null;
$precio = $_POST["precio"] ?? null;
$id_moneda = $_POST["moneda"] ?? null;
$descripcion = trim($_POST["descripcion"] ?? "");

// Validar que todos los campos obligatorios estén presentes
if (!$codigo || !$nombre || !$id_sucursal || !$precio || !$id_moneda) {
    echo json_encode(["error" => "Faltan campos obligatorios"]);
    exit;
}

// Verificar que el código no exista ya
$stmt = $pdo->prepare("SELECT COUNT(*) FROM producto WHERE codigo = :codigo");
$stmt->execute([':codigo' => $codigo]);
if ($stmt->fetchColumn() > 0) {
    echo json_encode(["error" => "El código ya existe"]);
    exit;
}

// Insertar el producto en la base de datos
try {
    $sql = "INSERT INTO producto (codigo, nombre, id_sucursal, precio, id_moneda, descripcion)
            VALUES (:codigo, :nombre, :id_sucursal, :precio, :id_moneda, :descripcion)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':codigo' => $codigo,
        ':nombre' => $nombre,
        ':id_sucursal' => $id_sucursal,
        ':precio' => $precio,
        ':id_moneda' => $id_moneda,
        ':descripcion' => $descripcion
    ]);

    echo json_encode(["status" => "ok"]);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
