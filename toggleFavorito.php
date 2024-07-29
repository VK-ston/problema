<?php
session_start();

if (isset($_GET['posicion']) && isset($_GET['origen'])) {
    $posicion = $_GET['posicion'];
    $origen = $_GET['origen'];

    // Leer el archivo JSON
    $libros = json_decode(file_get_contents('libros.json'), true);

    // Verificar que la posición es válida
    if (isset($libros[$posicion])) {
        // Alternar el valor de Favorito
        $libros[$posicion]['Favorito'] = !$libros[$posicion]['Favorito'];

        // Guardar los cambios en el archivo JSON
        file_put_contents('libros.json', json_encode($libros));

        // Establecer un mensaje de éxito
        $_SESSION['mensajeFavorito'] = 'El estado de favorito se ha cambiado correctamente.';
    } else {
        // Establecer un mensaje de error
        $_SESSION['mensajeFavoritoError'] = 'La posición especificada no es válida.';
    }
} else {
    // Establecer un mensaje de error
    $_SESSION['mensajeFavoritoError'] = 'No se ha especificado ninguna posición o origen.';
}

// Redirigir a la página de origen
if ($origen === 'leerLibro') {
    header('Location: leerLibro.php?posicion=' . urlencode($posicion));
} elseif ($origen === 'modificarLibro') {
    header('Location: modificarLibro.php?posicion=' . urlencode($posicion));
} else {
    // En caso de que el origen no sea válido, redirigir a una página por defecto
    header('Location: index.php');
}
exit();
?>
