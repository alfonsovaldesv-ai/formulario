<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

$codigo = $data['codigo'] ?? '';
$nombre = $data['nombre'] ?? '';
$bodega = $data['bodega'] ?? '';
$sucursal = $data['sucursal'] ?? '';
$moneda = $data['moneda'] ?? '';
$precio = $data['precio'] ?? 0;
$materiales = $data['materiales'] ?? [];
$descripcion = $data['descripcion'] ?? '';

$host = '127.0.0.1';
$port = '5432';
$db   = 'productos';
$user = 'postgres';
$pass = 'postgres';
$dsn  = "pgsql:host=$host;port=$port;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ------------------ ID SUCURSAL ------------------
    $stmtSucursal = $pdo->prepare("
        SELECT s.id_sucursal 
        FROM sucursal s
        JOIN bodega b ON s.id_bodega = b.id_bodega
        WHERE s.nombre_sucursal = :sucursal AND b.nombre_bodega = :bodega
    ");
    $stmtSucursal->execute([
        'sucursal' => $sucursal,
        'bodega'   => $bodega
    ]);
    $idSucursal = $stmtSucursal->fetchColumn();
    if (!$idSucursal) throw new Exception("Sucursal no encontrada para la bodega seleccionada.");

    // ------------------ ID MONEDA ------------------
    $stmtMoneda = $pdo->prepare("SELECT id_moneda FROM moneda WHERE nombre_moneda = :moneda");
    $stmtMoneda->execute(['moneda' => $moneda]);
    $idMoneda = $stmtMoneda->fetchColumn();
    if (!$idMoneda) throw new Exception("Moneda no encontrada.");

    // ------------------ INSERTAR PRODUCTO ------------------
    $stmtProducto = $pdo->prepare("
        INSERT INTO producto(codigo, nombre, id_sucursal, precio, id_moneda, descripcion)
        VALUES (:codigo, :nombre, :id_sucursal, :precio, :id_moneda, :descripcion)
    ");
    $stmtProducto->execute([
        'codigo'     => $codigo,
        'nombre'     => $nombre,
        'id_sucursal'=> $idSucursal,
        'precio'     => $precio,
        'id_moneda'  => $idMoneda,
        'descripcion'=> $descripcion
    ]);

    // ------------------ INSERTAR MATERIALES ------------------
    $stmtMat = $pdo->prepare("SELECT id_material FROM material WHERE nombre_material = :nombre");
    $stmtInsertMat = $pdo->prepare("INSERT INTO material_producto(id_material, codigo_producto) VALUES (:id_material, :codigo_producto)");

    foreach ($materiales as $mat) {
        $stmtMat->execute(['nombre' => $mat]);
        $idMat = $stmtMat->fetchColumn();
        if ($idMat) {
            $stmtInsertMat->execute([
                'id_material'    => $idMat,
                'codigo_producto'=> $codigo
            ]);
        }
    }

    echo json_encode(["status" => "ok"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
