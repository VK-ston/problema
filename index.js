document.addEventListener('DOMContentLoaded', function () {
    const btnMostrarFormulario = document.getElementById('btn-mostrar-formulario');
    const formularioAgregar = document.getElementById('formulario-agregar');
    const inicialBotonContainer = document.getElementById('inicial-boton-container');
    
    btnMostrarFormulario.addEventListener('click', function () {
        inicialBotonContainer.style.display = 'none';
        formularioAgregar.style.display = 'block';
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var bookCards = document.querySelectorAll('.book-card');
    var numLibrosElement = document.getElementById('num-libros');

    function updateNumLibros() {
        var visibleBooks = Array.from(bookCards).filter(function(card) {
            return card.style.display !== 'none';
        }).length;
        numLibrosElement.textContent = 'Libros leídos: ' + visibleBooks;
    }

    var yearList = document.getElementById('year-list');
    yearList.addEventListener('change', function() {
        var selectedYear = this.value;

        bookCards.forEach(function(card) {
            var bookYear = card.getAttribute('data-year');
            if (selectedYear === 'todos' || bookYear === selectedYear) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        updateNumLibros();
    });

    var inputBusqueda = document.getElementById('search');
    var btnBuscar = document.getElementById('btn-buscar');
    var tituloArray = [];
    var autorArray = [];

    // Obtener los títulos y autores de todos los libros
    bookCards.forEach(function(card) {
        var titulo = card.querySelector('.titulo').textContent.toLowerCase();
        var autor = card.querySelector('.autor').textContent.toLowerCase();
        tituloArray.push(titulo);
        autorArray.push(autor);
    });

    // Función para realizar la búsqueda
    function buscar() {
        var searchTerm = inputBusqueda.value.toLowerCase().trim();

        // Filtrar libros por título o autor
        for (var i = 0; i < bookCards.length; i++) {
            var titulo = tituloArray[i];
            var autor = autorArray[i];

            // Mostrar la tarjeta si el título o el autor coinciden con el término de búsqueda
            if (titulo.includes(searchTerm) || autor.includes(searchTerm)) {
                bookCards[i].style.display = 'block';
            } else {
                bookCards[i].style.display = 'none';
            }
        }
        updateNumLibros();
    }

    // Escuchar el evento click en el botón de buscar
    btnBuscar.addEventListener('click', buscar);

    // Escuchar el evento keypress en el campo de búsqueda
    inputBusqueda.addEventListener('keypress', function(event) {
        // Verificar si la tecla presionada es "Enter" (código 13)
        if (event.keyCode === 13) {
            buscar(); // Realizar la búsqueda
        }
    });

    // Escuchar el evento input en el campo de búsqueda
    inputBusqueda.addEventListener('input', function() {
        // Si el campo de búsqueda está vacío, mostrar todos los libros
        if (inputBusqueda.value.trim() === '') {
            bookCards.forEach(function(card) {
                card.style.display = 'block';
            });
        }
        updateNumLibros();
    });

    // Actualizar el número de libros al cargar la página
    updateNumLibros();
});

// Obtener el año actual
var currentYear = new Date().getFullYear();

// Seleccionar el elemento del footer por su ID
var footerYearElement = document.getElementById('footer-year');

// Actualizar el contenido del elemento con el año actual
footerYearElement.innerHTML = `© ${currentYear} - La Archivoteca-Demo`;

// Si deseas agregar "Todos los derechos reservados." solo para desktop
var rightsElement = document.querySelector('.solo-desktop');
if (rightsElement) {
    rightsElement.innerHTML = " - Todos los derechos reservados.";
}

function agregarParametro() {
    // Obtener el valor del campo de texto
    var valorParametro = document.getElementById("codigo").value;
    
    // Obtener el enlace
    var enlace = document.getElementById("borrarEnlace");
    
    // Obtener la URL actual del enlace
    var url = enlace.getAttribute("href");
    
    // Agregar el parámetro al final de la URL
    var nuevaUrl = url + "&codigo=" + encodeURIComponent(valorParametro);
    
    // Establecer la nueva URL en el enlace
    enlace.setAttribute("href", nuevaUrl);
}

// Transición suavecita de ir arriba
function scrollToTop(event) {
    event.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Cerrar notifiacion 
document.addEventListener('DOMContentLoaded', function() {
    var cerrarNotificaciones = document.querySelectorAll('.cerrar-notificacion, .cerrar-notificacion-eliminado');

    cerrarNotificaciones.forEach(function(cerrar) {
        cerrar.addEventListener('click', function() {
            var notificacion = this.parentElement;
            notificacion.classList.remove('mostrar'); // Quitar clase para ocultar
            setTimeout(function() {
                notificacion.style.display = 'none'; // Ocultar completamente después de la animación
            }, 300); // Esperar 300ms (tiempo de la transición) antes de ocultar
        });
    });

    // Mostrar las notificaciones con transición después de un pequeño retraso
    setTimeout(function() {
        var notificaciones = document.querySelectorAll('.mensaje-notificacion, .mensaje-notificacion-eliminado');
        notificaciones.forEach(function(notificacion) {
            notificacion.classList.add('mostrar');
        });
    }, 100); // Iniciar la animación después de 100ms (ajustable según necesidad)
});





