<?php
session_start(); // Inicia la sesión


if ($_GET['codigo']=='democode1234') {
$pos = $_GET['posicion'];
//echo $pos;
$libros = json_decode(file_get_contents('libros.json'),true);
// Se borran las imágenes físicamente del sistema de archivos
if (isset($libros[$pos]['Portada'])) {
	$destino = './images/portadas/'.$libros[$pos]['Portada'];
	if (file_exists($destino)) {
		unlink($destino);
	}	
}	
//echo '<pre>';
  
// Eliminar el libro del array
unset($libros[$pos]);
//echo 'Después de borrar:<br>';
// Guardar los cambios en el archivo JSON
file_put_contents("libros.json",json_encode($libros));

// Mensaje de éxito en la sesión
$_SESSION['mensajeEliminar'] = "Libro eliminado correctamente";
} else {
    // Establecer el mensaje de notificación de código incorrecto
    $_SESSION['mensajeCodigoIncorrecto'] = 'Código incorrecto';
}

header('Location: index.php');
?>
