<?php
$libros = json_decode(file_get_contents('libros.json'), true);
$posicion = $_GET['posicion'];
$libro = $libros[$posicion];
$pageTitle = 'La Archivoteca - ' . $libro['Titulo'];
require_once 'header.php';

// Determinar la clase para el botón basado en el estado de Favorito
$favoritoClase = $libro['Favorito'] ? 'favorito' : 'no-favorito';
?>
<body>
<?php
echo '<div id="container">
        <div class="columna-izq-desktop">
            <div class="box-volver">
                <button class="btn-volver" onclick="window.location.href = \'index.php\';">
                    <p>Volver</p>
                </button>
                <button class="favorito-cuadrado ' . htmlspecialchars($favoritoClase) . '" onclick="window.location.href = \'toggleFavorito.php?posicion=' . urlencode($_GET['posicion']) . '&origen=leerLibro\';">
                    <span>⭐</span>
                </button>
            </div>
            <div class="box-busqueda">
                <a href="modificarLibro.php?posicion=' . urlencode($_GET['posicion']) . '" class="btn-editar">
                    <p>Editar</p>
                </a>
            </div>
        </div>
        <div class="columna-der-desktop">
            <div class="box-card">
                <div class="flex-container-card-outer">
                    <div class="portada-container">
                        <div class="portada"';
if (isset($libro['Portada'])) {
    echo 'style="background-image: url(\'images/portadas/' . htmlspecialchars($libro['Portada']) . '\')"';
}
echo '                    ></div>
                    </div>
                    <div class="info-container">';

echo '<div class="titulo-card">' . htmlspecialchars($libro['Titulo']) . '</div>';
echo '<div class="autor-card">' . htmlspecialchars($libro['Autor']) . '</div>';

echo '<div class="grid-container">'; // Inicia el contenedor del grid

echo '<div class="flex-container-card">
        <div class="flex-item">Formato:</div>
        <div class="texto-flex-item">' . htmlspecialchars($libro['Formato']) . '</div>
      </div>';
echo '<div class="flex-container-card">
        <div class="flex-item">Páginas:</div>
        <div class="texto-flex-item">' . htmlspecialchars($libro['Paginas']) . '</div>';
echo '</div>';

// Formatear fechas
$fechaInicio = DateTime::createFromFormat('Y-m-d', $libro['FechaInicio']);
$fechaFin = isset($libro['FechaFin']) ? DateTime::createFromFormat('Y-m-d', $libro['FechaFin']) : false;
$fechaInicioFormatted = $fechaInicio ? $fechaInicio->format('d-m-Y') : 'Leyendo';
$fechaFinFormatted = $fechaFin ? $fechaFin->format('d-m-Y') : 'Leyendo';

// Calcular la diferencia en días si la fecha de fin está disponible
if ($fechaFin) {
    $interval = $fechaInicio->diff($fechaFin);
    $diasTotales = $interval->days + 1; // Sumar 1 para contar ambos días inclusivos
    $diasTotalesTexto = $diasTotales == 1 ? '1 día' : $diasTotales . ' días';
} else {
    $fechaActual = new DateTime();
    $interval = $fechaInicio->diff($fechaActual);
    $diasTotales = $interval->days + 1; // Sumar 1 para contar ambos días inclusivos
    $diasTotalesTexto = 'Leyendo (' . ($diasTotales == 1 ? '1 día' : $diasTotales . ' días') . ')';
}

echo '<div class="flex-container-card">
        <div class="flex-item">Fecha de inicio:</div>
        <div class="texto-flex-item">' . htmlspecialchars($fechaInicioFormatted) . '</div>';
echo '</div>';
echo '<div class="flex-container-card">
        <div class="flex-item">Fecha de fin:</div>
        <div class="texto-flex-item">' . htmlspecialchars($fechaFinFormatted) . '</div>';
echo '</div>';
echo '<div class="flex-container-card">
        <div class="flex-item">Días totales:</div>
        <div class="texto-flex-item">' . htmlspecialchars($diasTotalesTexto) . '</div>';
echo '</div>';

echo '</div>'; // Cierra el contenedor del grid

echo '<div class="notas-container">'; // Inicia el contenedor de notas
echo '<div class="notas-card">Notas:</div>';
echo '<div class="texto-notas-card">' . htmlspecialchars($libro['Notas']) . '</div>';
echo '</div>'; // Cierra el contenedor de notas

echo '          </div>
                </div>
            </div>';

// Cálculo de las posiciones para los enlaces de navegación
$totalLibros = count($libros);
$posicionAnterior = ($posicion + 1) % $totalLibros;
$posicionSiguiente = ($posicion - 1 + $totalLibros) % $totalLibros;

// Enlaces de navegación
echo '<div class="box-navegacion">
        <div class="boton-navegacion">
            <a href="leerLibro.php?posicion=' . urlencode($posicionAnterior) . '" class="btn-navegacion-siguiente">
                <p>Siguiente</p>
            </a>
        </div>
        <div class="boton-navegacion">
            <a href="leerLibro.php?posicion=' . urlencode($posicionSiguiente) . '" class="btn-navegacion-anterior">
                <p>Anterior</p>
            </a>
        </div>
      </div>';

echo '  </div>
      </div>';
?>
</body>
</html>
