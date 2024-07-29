<?php
session_start();

// Definir el tema por defecto (claro)
$theme = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'dark' : 'light';

// Definir los archivos CSS según el tema seleccionado
$phpCssFile = $theme === 'dark' ? 'css/php-dark.css?v=1' : 'css/php.css?v=1';
$leerLibroCssFile = $theme === 'dark' ? 'css/leerlibro-dark.css?v=1' : 'css/leerlibro.css?v=1';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="<?php echo $phpCssFile; ?>" id="php-theme-style">
    <link rel="stylesheet" type="text/css" href="<?php echo $leerLibroCssFile; ?>" id="leerlibro-theme-style">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title><?php echo isset($pageTitle) ? $pageTitle : 'La Archivoteca'; ?></title>

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Script para cambiar el tema de claro a oscuro -->
<script>
function toggleTheme() {
    var phpThemeStyle = document.getElementById('php-theme-style');
    var leerLibroThemeStyle = document.getElementById('leerlibro-theme-style');
    
    // Cambiar el tema y guardar en la cookie
    if (phpThemeStyle.getAttribute('href').includes('php.css')) {
        phpThemeStyle.setAttribute('href', 'css/php-dark.css?v=1');
        leerLibroThemeStyle.setAttribute('href', 'css/leerlibro-dark.css?v=1');
        document.cookie = "theme=dark; path=/";
    } else {
        phpThemeStyle.setAttribute('href', 'css/php.css?v=1');
        leerLibroThemeStyle.setAttribute('href', 'css/leerlibro.css?v=1');
        document.cookie = "theme=light; path=/";
    }
}

// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
}

// Al cargar la página, aplicar el tema desde la cookie
window.onload = function() {
    var theme = getCookie('theme');
    if (theme) {
        var phpThemeStyle = document.getElementById('php-theme-style');
        var leerLibroThemeStyle = document.getElementById('leerlibro-theme-style');
        if (theme === 'dark') {
            phpThemeStyle.setAttribute('href', 'css/php-dark.css?v=1');
            leerLibroThemeStyle.setAttribute('href', 'css/leerlibro-dark.css?v=1');
        } else {
            phpThemeStyle.setAttribute('href', 'css/php.css?v=1');
            leerLibroThemeStyle.setAttribute('href', 'css/leerlibro.css?v=1');
        }
    }
}
</script>
</head>
