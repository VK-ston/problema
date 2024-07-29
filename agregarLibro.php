<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión
ob_start(); // Inicia el almacenamiento en búfer de salida

if ($_POST['codigo'] == 'codigolibro2231,') {

    require_once 'header.php';
    require_once 'config.php'; // Incluir el archivo de configuración

    // Asegúrate de que se muestren los errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Inicializa la variable $nombre
    $nombre = '';

    //echo '<pre>';
    //print_r($_FILES);

    // Subir un archivo de imagen
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $ficheroPath = $_FILES['portada']['tmp_name'];
        $ficheroNombre = $_FILES['portada']['name'];
        $ficheroTipo = $_FILES['portada']['type'];
        $ficheroSize = $_FILES['portada']['size'];

        $ficheroTabla = explode('.', $ficheroNombre);
        $extension = strtolower(end($ficheroTabla));
        $permitirExtensiones = array('jpg', 'gif', 'png');

        $nombre = md5(time() . $ficheroNombre) . '.' . $extension;
        if (in_array($extension, $permitirExtensiones)) {
            if ($ficheroSize < 500000) {
                $destino = './images/portadas/' . $nombre;
                if (move_uploaded_file($ficheroPath, $destino)) {
                    //echo 'Se ha subido la foto correctamente.<br>';
                } else {
                    //echo '<div class="error-portada">Algo ha salido mal al mover el archivo.</div>';
                }
            } else {
                //echo '<div class="error-portada">Archivo superior a 500 KB.</div>';
            }
        } else {
            //echo '<div class="error-portada">Extensión de archivo no permitida.</div>';
        }

        //echo 'Nombre original: ' . $ficheroNombre . '<br>';
        //echo 'Extensión: ' . $extension . '<br>';
        //echo 'Nuevo nombre: ' . $nombre . '<br>';
    } else {
        //echo '<div class="error-portada">No se ha subido ningún archivo o ha habido un error.</div>';
        if (isset($_FILES['portada'])) {
            //echo 'Código de error: ' . $_FILES['portada']['error'] . '<br>';
        }
    }
    //echo '</pre>'; 
?>
<pre>
<?php
    $fichero = file_get_contents('libros.json');
    $libros = json_decode($fichero, true);

    $libro = array(
        'Titulo' => $_POST['titulo'],
        'Autor' => $_POST['autor'],
        'FechaInicio' => $_POST['fecha-inicio'],
        'FechaFin' => $_POST['fecha-fin'],
        'Formato' => $_POST['formato'],
        'Paginas' => $_POST['num-paginas'],
        'Notas' => $_POST['notas'],
        'Portada' => $nombre,
      	'Favorito' => 'false' // Añade el campo Favorito y establece su valor inicial como false

    );
    $libros[] = $libro;

    $librosJSON = json_encode($libros);
    file_put_contents("libros.json", $librosJSON);
  
  	// Establecer el mensaje de notificación
    $_SESSION['mensajeAgregar'] = 'Libro agregado correctamente';
  
} else {
    // Establecer el mensaje de notificación de código incorrecto
    $_SESSION['mensajeCodigoIncorrecto'] = 'Código incorrecto';
}   

ob_end_clean(); // Limpiar el búfer de salida

header('Location: index.php');
exit();
?>
</pre>
</body>
</html>
