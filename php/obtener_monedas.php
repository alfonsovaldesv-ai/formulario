<?php
header('Content-Type: application/json');

$host='127.0.0.1'; 
$port='5432'; 
$db='productos'; 
$user='postgres'; 
$pass='postgres';
$dsn="pgsql:host=$host;port=$port;dbname=$db;";

try {
    $pdo = new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT nombre_moneda FROM moneda ORDER BY id_moneda");
    $monedas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(["status"=>"ok","monedas"=>$monedas]);

} catch(PDOException $e){
    echo json_encode(["status"=>"error","message"=>$e->getMessage()]);
}
