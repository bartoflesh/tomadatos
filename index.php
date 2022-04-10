<?PHP
/** 
 * Se habilitan los errores
 */ 
error_reporting(E_ALL);

/**
 * Parametros para establecer la conexion
 */ 
$DB_HOST = "localhost";
$DB_USER = "id17727901_especifica";
$DB_PASS = "Argentina2021#";
$DB_NAME = "id17727901_rara";

/**
 * Conexion DB
 */ 
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME ) or die("No puedo conectar al servidor");


/**
 * Preparo el SQL para grabar la informacion
 */ 
$ssql = "SELECT id, COUNT(*) AS cantidad, tarjeta, DATE_FORMAT(created_at, '%Y-%m-%d') AS FechaStr FROM `tarjetas` GROUP BY tarjeta, FechaStr ORDER BY FechaStr DESC";


/**
 * Preparo el SQL para Grafico
 */ 
$ssql_label = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS y, count(*) AS a FROM `tarjetas` GROUP BY y";
$result_label = mysqli_query($conn, $ssql_label) or die($ssql_label);
while ($row = mysqli_fetch_array($result_label)) {
	$ldata [ ] = array(
        'y' => $row['y'],
        'a' => $row['a']
	);
};
// var_dump($ldata);




$ssql_grafico = "SELECT COUNT(*) AS cantidad FROM `tarjetas`";
$result_grafico = mysqli_query($conn, $ssql_grafico) or die($ssql_grafico);
while ($row = mysqli_fetch_array($result_grafico)) {
	$sdata [ ] = array(
        'cantidad' => $row['cantidad']
	);
};
// var_dump($sdata);


$result = mysqli_query($conn, $ssql) or die($ssql);

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    
    <title>Bartoflesh!</title>
</head>
<body style="background-color: #5D6166">
      
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h3><b>CUENTA ACCESOS</b></h3>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-dark">
                        <h5 class="card-title text-white mb-2">Tabla</h5>
                        <div class="table-resposive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th># ID</th>
                                        <th>Catidad</th>
                                        <th>Tarjeta</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $valores = []; ?>
                                <?php while ($row = mysqli_fetch_array($result)) : ?>
                                <tr>
                                    <td><?=$row['id']?></td>
                                    <td class="text-center"><a href="/items.php?id=<?=$row['FechaStr']?>" title="Ver detalle del registro"><?=$row['cantidad']?></a></td>
                                    <td><?=$row['tarjeta']?></td>
                                    <td><?=$row['FechaStr']?></td>
                                </tr>
                                <?php 
                                
                                    $valores1[] =  $row['cantidad'];
                                    $valores2[] =  $row['FechaStr'];

                                ?>
                                <?php endwhile; 
                                /*
                                    echo '<pre>';
                                    var_dump($valores1, $valores2);
                                    echo '</pre>';
                                */
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>

            </div>
            <div class="col-md-6 mt-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-dark">
                        <h5 class="card-title text-white mb-2">Grafico</h5>
                        <div id="respuestaGrafico"></div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>

        // Obtener una referencia al elemento canvas del DOM
        const $grafica = document.querySelector("#respuestaGrafico");
        // Las etiquetas son las que van en el eje X. 
        const etiquetas = <?php echo json_encode($ldata) ?>;
        
        console.log(etiquetas);
        
        Morris.Line({
          element: $grafica,
          data: etiquetas,
          xkey: 'y',
          ykeys: ['a'],
          labels: ['INGRESOS'],
          resize: true
        });
    </script>



  </body>
</html>