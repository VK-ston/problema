<?php
session_start(); // Inicia la sesión

// Verificar que 'codigo' y 'posicion' están presentes
if (isset($_GET['codigo']) && $_GET['codigo'] === 'codigolibro2231,' && isset($_GET['posicion'])) {
    $pos = intval($_GET['posicion']); // Asegúrate de que 'posicion' sea un número entero

    $libros = json_decode(file_get_contents('libros.json'), true);
    if (isset($libros[$pos])) {
        // Se borran las imágenes físicamente del sistema de archivos
        if (isset($libros[$pos]['Portada'])) {
            $destino = './images/portadas/'.$libros[$pos]['Portada'];
            if (file_exists($destino)) {
                unlink($destino);
            }	
        }

        // Eliminar el libro del array
        unset($libros[$pos]);

        // Reindexar el array para evitar agujeros en los índices
        $libros = array_values($libros);

        // Guardar los cambios en el archivo JSON
        file_put_contents('libros.json', json_encode($libros));

        // Mensaje de éxito en la sesión
        $_SESSION['mensajeEliminar'] = "Libro eliminado correctamente";
    } else {
        $_SESSION['mensajeEliminar'] = "No se encontró el libro para eliminar";
    }
} else {
    // Establecer el mensaje de notificación de código incorrecto
    $_SESSION['mensajeCodigoIncorrecto'] = 'Código incorrecto o parámetros faltantes';
}

header('Location: index.php');
exit(); // Asegúrate de que no haya más salida después de la redirección
?>
