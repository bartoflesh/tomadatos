<?php

error_reporting(E_ALL);

$tarjeta = isset($_GET["tarjeta"]) ? $_GET["tarjeta"] : '';

// obtengo la fecha y hora
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha = date("Ymd");
$hora = date("His");

// parametros para establecer la conexion
$DB_HOST = "localhost";
$DB_USER = "id17727901_especifica";
$DB_PASS = "Argentina2021#";
$DB_NAME = "id17727901_rara";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME ) or die("No puedo conectar al servidor");

$ssql = "INSERT INTO `tarjetas` (tarjeta,  fecha, hora ) values ('$tarjeta', '$fecha', '$hora')";

// echo $ssql;

$guardado = mysqli_query($conn, $ssql) or die($ssql);

if ($guardado) {
    $arr = array('respuesta' => 'ok', 'fecha' => $fecha, 'hora' => $hora);
    echo json_encode([$arr]);
} else {
    $arr = array('respuesta' => 'error', 'fecha' => $fecha, 'hora' => $hora);
    echo json_encode([$arr]);
}
