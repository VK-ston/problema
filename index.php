<?php
	session_start(); // Inicia la sesión
	require_once 'header.php';
?>
<body>
    <div id="container">
        <div class="columna-izq-desktop">
            <div class="box-busqueda">
                <input class="input-busqueda" type="text" id="search" placeholder="Buscar libro o autor">
                <button class="btn-buscar" id="btn-buscar">
                    <p>Buscar</p>
                </button>
            </div>
            <div class="box">
                <div class="formulario-agregar" id="formulario-agregar" style="display:none;">
                    <form id="form-libro" action="agregarLibro.php" method="post" enctype="multipart/form-data">
                        <div class="campo-doble-titulo-autor">
                            <div class="columna-izq-titulo-autor">
                                <label for="titulo">Título de la obra:</label>
                                <input class="input-busqueda-form" type="text" id="titulo" name="titulo" required>
                            </div>
                            <div class="columna-der-titulo-autor">    	
                                <label for="autor">Autor:</label>
                                <input class="input-busqueda-form" type="text" id="autor" name="autor" required>
                            </div>
                        </div>
                        <div class="campo-cuadruple">
                            <div class="campo-doble">
                                <div class="columna-izq">
                                    <label for="fecha-inicio">Fecha de inicio:</label>
                                    <input class="input-busqueda-form" type="date" id="fecha-inicio" name="fecha-inicio" required>
                                </div>
                                <div class="columna-der">
                                    <label for="fecha-fin">Fecha de fin:</label>
                                    <input class="input-busqueda-form" type="date" id="fecha-fin" name="fecha-fin">
                                </div>
                            </div>
                            <div class="campo-doble">
                                <div class="columna-izq">
                                    <label for="formato">Formato:</label>
                                    <input class="input-busqueda-form" type="text" id="formato" name="formato" required>
                                </div>
                                <div class="columna-der">
                                    <label for="paginas">Páginas:</label>
                                    <input class="input-busqueda-form" type="number" id="num-paginas" name="num-paginas" required>
                                </div>
                            </div>
                        </div>	
                        <div>
                            <label for="notas">Notas:</label>
                            <textarea class="textarea-notas" id="notas" name="notas" placeholder="Introduce aquí tus notas"></textarea>
                        </div>
                        <div class="campo-doble-portada-agregar">
                            <div class="columna-izq-portada-agregar">
                                <label for="portada">Portada:</label>
                                <input class="input-portada" type="file" id="portada" name="portada">
                            </div>
                            <div class="columna-izq-portada-agregar">
                                <label for="codigo">Código:</label>
                                <input class="input-busqueda-form" type="password" id="codigo" name="codigo">
                            </div>							
                            <div class="columna-der-portada-agregar">
                                <button class="btn-agregar" type="submit" id="btn-agregar-libro">
                                    <p>Agregar libro</p>
                                </button>
                            </div>					
                        </div>
                    </form>
                </div>
                <div class="columna-der-portada-agregar" id="inicial-boton-container">
                    <button class="btn-agregar" id="btn-mostrar-formulario">
                        <p>Agregar libro</p>
                    </button>
                </div>		    
            </div>
          
            <!-- Notificación de código incorrecto -->
            <?php
            if (isset($_SESSION['mensajeCodigoIncorrecto'])) {
              echo '<div class="mensaje-notificacion-eliminado">';
              echo '<span>' . $_SESSION['mensajeCodigoIncorrecto'] . '</span>'; // Mensaje de notificación
              echo '<span class="cerrar-notificacion-eliminado">&times;</span>'; // Icono de cerrar con clase para identificarlo
              echo '</div>';
              unset($_SESSION['mensajeCodigoIncorrecto']); // Eliminar el mensaje después de mostrarlo
            }
            ?>
            <!-- Notificación de libro agregado correctamente -->
            <?php
            if (isset($_SESSION['mensajeAgregar'])) {
                echo '<div class="mensaje-notificacion">';
                echo '<span>' . $_SESSION['mensajeAgregar'] . '</span>'; // Mensaje de notificación
                echo '<span class="cerrar-notificacion">&times;</span>'; // Icono de cerrar
                echo '</div>';
                unset($_SESSION['mensajeAgregar']); // Eliminar el mensaje después de mostrarlo
            }
            ?>
            <!-- Notificación de libro editado correctamente -->
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="mensaje-notificacion">';
                echo '<span>' . $_SESSION['mensaje'] . '</span>'; // Mensaje de notificación
                echo '<span class="cerrar-notificacion">&times;</span>'; // Icono de cerrar
                echo '</div>';
                unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
            }
            ?>
            <!-- Notificación de libro eliminado correctamente -->
            <?php
            if (isset($_SESSION['mensajeEliminar'])) {
                echo '<div class="mensaje-notificacion">';
                echo '<span>' . $_SESSION['mensajeEliminar'] . '</span>'; // Mensaje de notificación
                echo '<span class="cerrar-notificacion">&times;</span>'; // Icono de cerrar con clase para identificarlo
                echo '</div>';
                unset($_SESSION['mensajeEliminar']); // Eliminar el mensaje después de mostrarlo
            }
            ?>


        </div>
        <div class="columna-der-desktop">
            <div class="box-desplegable">
				<div class="box-bombilla-desplegable">	
                  <select class="desplegable" name="year-list" id="year-list">
                        <option value="todos">Todos los años</option>
                        <?php
                            $libros = json_decode(file_get_contents('libros.json'), true);
                            $years = array();
                            foreach ($libros as $libro) {
                                $year = date("Y", strtotime($libro['FechaInicio']));
                                if (!in_array($year, $years)) {
                                    $years[] = $year;
                                }
                            }
                            rsort($years);
                            foreach ($years as $year) {
                                echo '<option value="'.$year.'">'.$year.'</option>';
                            }
                        ?>
                    </select>
                    <div>
                      <button class="bombilla" onclick="toggleTheme()">
                        <span>💡</span>
                      </button>  
                    </div>
              	</div>  
                <h2 id="num-libros">Libros leídos: </h2>
            </div>
            <div class="book-grid">
				<?php
					$libros = json_decode(file_get_contents('libros.json'), true);
				function fecha($valor)
				{
    				return($valor['FechaInicio']);
				}
				$librosOrdenados = array_map("fecha", $libros);
				arsort($librosOrdenados);

				foreach ($librosOrdenados as $index => $libro) {
					$year = date("Y", strtotime($libros[$index]['FechaInicio']));
					echo '<div class="book-card" data-year="'.$year.'">';
					echo '<a href="leerLibro.php?posicion='.$index.'">';
					echo "<div class='portada'";
					if (isset($libros[$index]['Portada'])) {
						echo 'style="background-image: url(\'images/portadas/'.$libros[$index]['Portada'].'\')")';
					}	
					echo "></div>";
					echo '</a>';
					echo "<div class='titulo'>{$libros[$index]['Titulo']}</div>";
					echo "<div class='autor'>{$libros[$index]['Autor']}</div>";
					echo '</div>';
				}
				?>
            </div>
			<footer>
				<div class="copyright">
                  <div class="texto-footer">
					<p id="footer-year"> <!--© XXXX - La Archivoteca - Todos los derechos reservados.--></p>
                 	<span class="solo-desktop"> - Todos los derechos reservados.</span>
                  </div>  
					<a href="#top" onclick="scrollToTop(event)">	
                  		<span id="ir_arriba"> Ir arriba ↑ </span><!-- .to-the-top-long -->
              		</a>	
				</div>	
			</footer>				
        </div>
    </div>
    <script src="index.js"></script>			
</body>
</html>
