<?php
$libros = json_decode(file_get_contents('libros.json'), true);
$posicion = $_GET['posicion'];
$libro = $libros[$posicion];
$pageTitle = 'La Archivoteca - ' . htmlspecialchars($libro['Titulo']);
require_once 'header.php';

// Determinar la clase para el botón basado en el estado de Favorito
$favoritoClase = $libro['Favorito'] ? 'favorito' : 'no-favorito';
?>
<body>
    <?php
    echo '<div id="container">
            <div class="columna-izq-desktop">
                <div class="box-volver">
                    <button class="btn-volver" onclick="window.location.href=\'https://archivoteca.adriamachin.com/\'">
                        <p>Volver</p>
                    </button>
                    <button class="favorito-cuadrado ' . htmlspecialchars($favoritoClase) . '" onclick="window.location.href = \'toggleFavorito.php?posicion=' . urlencode($posicion) . '&origen=modificarLibro\';">
                        <span>⭐</span>
                    </button>
                </div>
                <div class="box">
                    <div class="formulario-agregar" id="formulario-agregar" style="display:block;">
                        <form id="form-libro" action="modificar2Libro.php" method="post" enctype="multipart/form-data">';

    // Aquí ya no es necesario volver a definir las variables
    // $libros = json_decode(file_get_contents('libros.json'), true);
    // $posicion = $_GET['posicion'];
    // $libro = $libros[$posicion];

    echo '              <div class="campo-doble-titulo-autor">
                                <div class="columna-izq-titulo-autor">
                                    <label for="titulo">Título de la obra:</label>
                                    <input class="input-busqueda-form" type="text" id="titulo" name="titulo" required value="' . htmlspecialchars($libro['Titulo']) . '">
                                </div>
                                <div class="columna-der-titulo-autor">     
                                    <label for="autor">Autor:</label>
                                    <input class="input-busqueda-form" type="text" id="autor" name="autor" required value="' . htmlspecialchars($libro['Autor']) . '">
                                </div>
                            </div>
                            <div class="campo-cuadruple">
                                <div class="campo-doble">
                                    <div class="columna-izq">
                                        <label for="fecha-inicio">Fecha de inicio:</label>
                                        <input class="input-busqueda-form" type="date" id="fecha-inicio" name="fecha-inicio" required value="' . htmlspecialchars($libro['FechaInicio']) . '">
                                    </div>
                                    <div class="columna-der">
                                        <label for="fecha-fin">Fecha de fin:</label>
                                        <input class="input-busqueda-form" type="date" id="fecha-fin" name="fecha-fin" value="' . htmlspecialchars($libro['FechaFin']) . '">
                                    </div>
                                </div>
                                <div class="campo-doble">
                                    <div class="columna-izq">
                                        <label for="formato">Formato:</label>
                                        <input class="input-busqueda-form" type="text" id="formato" name="formato" required value="' . htmlspecialchars($libro['Formato']) . '">
                                    </div>
                                    <div class="columna-der">
                                        <label for="paginas">Páginas:</label>
                                        <input class="input-busqueda-form" type="number" id="num-paginas" name="num-paginas" required value="' . htmlspecialchars($libro['Paginas']) . '">
                                    </div>
                                </div>
                            </div>   
                            <div>
                                <label for="notas">Notas:</label>
                                <textarea class="textarea-notas" id="notas" name="notas" placeholder="Introduce aquí tus notas">' . htmlspecialchars($libro['Notas']) . '</textarea>
                            </div>
                            <div class="campo-triple-por-gua-eli">
                                <div class="columna-izq-portada-agregar">
                                    <label for="portada">Portada:</label>
                                    <input class="input-portada-form-modificar" type="file" id="portada" name="portada">
                                </div>
                                <div class="columna-izq-portada-agregar">
                                    <label for="codigo">Código:</label>
                                    <input class="input-portada-form-modificar" type="password" id="codigo" name="codigo" onblur="agregarParametro();">
                                </div>                                   
                                <input type="hidden" name="posicion" value="' . htmlspecialchars($posicion) . '">
                                <div class="columna-guardar-eliminar">
                                    <button class="btn-agregar" type="submit" id="btn-agregar-libro">
                                        <p>Guardar cambios</p>
                                    </button>
                                </div>
                                <div class="columna-guardar-eliminar">
                                    <div class="btn-eliminar">
                                        <a id="borrarEnlace" href="borrarLibro.php?posicion=' . urlencode($posicion) . '" id="btn-agregar-libro">
                                            Eliminar libro
                                        </a>
                                    </div>
                                </div>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="columna-der-desktop">
                <div class="box-card">
                    <div class="flex-container-card-outer">
                        <div class="portada-container">
                            <div class="portada"';
    if (isset($libro['Portada'])) {
        echo ' style="background-image: url(\'images/portadas/' . htmlspecialchars($libro['Portada']) . '\');"';
    }

    echo '></div>
                        </div>
                        <div class="info-container">';
                        
    echo '              <div class="titulo-card">' . htmlspecialchars($libro['Titulo']) . '</div>';
    echo '              <div class="autor-card">' . htmlspecialchars($libro['Autor']) . '</div>';

    echo '              <div class="grid-container">'; // Inicia el contenedor del grid

    echo '                  <div class="flex-container-card">
                                <div class="flex-item">Formato:</div>
                                <div class="texto-flex-item">' . htmlspecialchars($libro['Formato']) . '</div>
                            </div>';
    echo '                  <div class="flex-container-card">
                                <div class="flex-item">Páginas:</div>
                                <div class="texto-flex-item">' . htmlspecialchars($libro['Paginas']) . '</div>
                            </div>';

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

    echo '                  <div class="flex-container-card">
                                <div class="flex-item">Fecha de inicio:</div>
                                <div class="texto-flex-item">' . htmlspecialchars($fechaInicioFormatted) . '</div>
                            </div>';
    echo '                  <div class="flex-container-card">
                                <div class="flex-item">Fecha de fin:</div>
                                <div class="texto-flex-item">' . htmlspecialchars($fechaFinFormatted) . '</div>';
    echo '                  </div>';
    echo '                  <div class="flex-container-card">
                                <div class="flex-item">Días totales:</div>
                                <div class="texto-flex-item">' . htmlspecialchars($diasTotalesTexto) . '</div>
                            </div>';

    echo '              </div>'; // Cierra el contenedor del grid

    echo '              <div class="notas-container">'; // Inicia el contenedor de notas
    echo '                  <div class="notas-card">Notas:</div>';
    echo '                  <div class="texto-notas-card">' . htmlspecialchars($libro['Notas']) . '</div>';
    echo '              </div>'; // Cierra el contenedor de notas

    echo '          </div>
                </div>
            </div>';

    // Cálculo de las posiciones para los enlaces de navegación
    $totalLibros = count($libros);
    $posicionAnterior = ($posicion + 1) % $totalLibros;
    $posicionSiguiente = ($posicion - 1 + $totalLibros) % $totalLibros;

    echo '          <div class="box-navegacion">
                        <div class="boton-navegacion">
                            <a href="modificarLibro.php?posicion=' . urlencode($posicionAnterior) . '" class="btn-navegacion-siguiente">
                                <p>Siguiente</p>
                            </a>
                        </div>
                        <div class="boton-navegacion">
                            <a href="modificarLibro.php?posicion=' . urlencode($posicionSiguiente) . '" class="btn-navegacion-anterior">
                                <p>Anterior</p>
                            </a>
                        </div>    
                    </div>';

    echo '      </div>
            </div>
        </div>
        <script src="index.js"></script>
    </body>
    </html>';
    ?>
