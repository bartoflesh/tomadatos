<?php

$id = isset($_GET['item']) ? ($_GET['item']): 1 ;


// parametros para establecer la conexion
$DB_HOST = "localhost";
$DB_USER = "id17727901_especifica";
$DB_PASS = "Argentina2021#";
$DB_NAME = "id17727901_rara";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME ) or die("No puedo conectar al servidor");

$ssql = "DELETE FROM `tarjetas` WHERE id = $id";

// echo $ssql;

$guardado = mysqli_query($conn, $ssql) or die($ssql);

if ($guardado) {
    $arr = array(
        'status' => 200, 
        'data' => $guardado
        );
    echo json_encode([$arr]);
} else {
    $arr = array(
        'status' => 400, 
        'data' => 'Algo anda mal'
        );
    echo json_encode([$arr]);
}

