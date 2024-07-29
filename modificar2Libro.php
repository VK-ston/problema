<?php
session_start(); // Inicia la sesión
ob_start(); // Inicia el almacenamiento en búfer de salida

if ($_POST['codigo'] == 'codigolibro2231,') {

    //echo '<pre>';
    //print_r($_POST);
    //print_r($_FILES);
    //echo '</pre>';

    $pos = $_POST['posicion'];
    $libros = json_decode(file_get_contents('libros.json'), true);

    // Comprobar si se ha subido una nueva imagen
    if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
        $ficheroPath = $_FILES['portada']['tmp_name'];
        $ficheroNombre = $_FILES['portada']['name'];
        $ficheroTipo = $_FILES['portada']['type'];
        $ficheroSize = $_FILES['portada']['size'];

        // Se calcula la extensión del archivo
        $ficheroTabla = explode('.', $ficheroNombre);
        $extension = strtolower(end($ficheroTabla));
        $permitirExtensiones = array('jpg', 'gif', 'png');

        // Se cambia el nombre del archivo
        $nombre = md5(time() . $ficheroNombre) . '.' . $extension;
        if (in_array($extension, $permitirExtensiones)) {
            if ($ficheroSize < 500000) {  // Asegúrate de que el tamaño sea menor a 500000 (500 KB)
                $destino = './images/portadas/' . $nombre;

                // Eliminar la imagen anterior si existe
                if (isset($libros[$pos]['Portada']) && !empty($libros[$pos]['Portada'])) {
                    $rutaAnterior = './images/portadas/' . $libros[$pos]['Portada'];
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                        //echo 'Imagen anterior eliminada correctamente.<br>';
                    } else {
                        //echo 'No se encontró la imagen anterior para eliminar.<br>';
                    }
                }

                // Mover la nueva imagen a la carpeta de destino
                if (move_uploaded_file($ficheroPath, $destino)) {
                    //echo 'Se ha subido la foto correctamente.<br>';
                    $libros[$pos]['Portada'] = $nombre; // Guardar el nombre del nuevo archivo
                } else {
                    //echo '<div class="error-portada">Algo ha salido mal al mover el archivo.</div>';
                }
            } else {
                //echo '<div class="error-portada">Archivo superior a 500 KB.</div>';
            }
        } else {
            //echo '<div class="error-portada">Extensión de archivo no permitida.</div>';
        }
    } else {
        if (isset($_FILES['portada'])) {
            //echo 'Código de error: ' . $_FILES['portada']['error'] . '<br>';
        }
    }

    //echo 'Imprimir antes<br>';
    //print_r($libros[$pos]);

    $libros[$pos]['Titulo'] = $_POST['titulo'];
    $libros[$pos]['Autor'] = $_POST['autor'];
    $libros[$pos]['FechaInicio'] = $_POST['fecha-inicio'];
    $libros[$pos]['FechaFin'] = $_POST['fecha-fin'];
    $libros[$pos]['Formato'] = $_POST['formato'];
    $libros[$pos]['Paginas'] = $_POST['num-paginas'];
    $libros[$pos]['Notas'] = $_POST['notas'];

    //echo 'Imprimir después<br>';
    //print_r($libros[$pos]);

    // Guardar los cambios en el archivo libros.json
    file_put_contents("libros.json", json_encode($libros));
  
  	// Almacenar el mensaje de éxito en la sesión
    $_SESSION['mensaje'] = "Libro editado correctamente";

    // Redirigir al usuario de vuelta al índice
    header('Location: index.php');
    ob_end_clean(); // Limpiar el búfer de salida
    exit();
} else {
    // Establecer el mensaje de notificación de código incorrecto
    $_SESSION['mensajeCodigoIncorrecto'] = 'Código incorrecto';
    // Redirigir al índice
    header('Location: index.php');
    ob_end_clean(); // Limpiar el búfer de salida
    exit();
}
?>
