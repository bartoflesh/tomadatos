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

$fecha = isset($_GET['id']) ? $_GET['id'] : '1974-02-04';


/**
 * Preparo el SQL para grabar la informacion
*/ 
$ssql = "SELECT *, DATE_FORMAT(created_at, '%Y-%m-%d') AS FechaStr, DATE_FORMAT(created_at, '%h:%m:%s') AS HoraStr FROM `tarjetas` WHERE DATE_FORMAT(created_at, '%Y-%m-%d') = '$fecha'";


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
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-dark">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title text-white mb-2">Tabla</h5><a class="btn btn-outline-primary btn-sm mb-2" href="/">Volver</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th># ID</th>
                                        <th>Tarjeta</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_array($result)) : ?>
                                <tr>
                                    <td><?=$row['id']?></td>
                                    <td><?=$row['tarjeta']?></td>
                                    <td><?=$row['FechaStr']?></td>
                                    <td><?=$row['HoraStr']?></td>
                                    <!--<td><a class="text-center text-danger" href="/delete.php?item=<?=$row['id']?>"><b>Borrar</b></td>-->
                                    <td><a class="text-center text-danger" onclick="destroyItem(<?=$row['id']?>)" style="cursor: pointer"><b>Borrar</b></td>
                                </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        
        const destroyItem = async (id) => {
            
            if (window.confirm("Esta por eliminar el registro!" + id)) {
                const destroyFetch = await fetch('./delete.php?item=' + id);
                const result = await destroyFetch.json();
                console.log(result);
                location.reload();
            }
        }

    </script>
    
  </body>
</html>