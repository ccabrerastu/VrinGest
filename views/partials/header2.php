<?php
// Define la URL base de tu aplicación. Ajusta si es necesario.
$baseUrl = "/";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>LABSAFE</title> <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        /* Transición base para los elementos que se van a transformar */
        #logo-link-header,
        #logout-link-header {
            transition: transform 0.3s ease-in-out;
        }
        /* Cuando el header tiene la clase 'header-shifted' (añadida por JS) */
        /* Y la pantalla es >= 768px (breakpoint 'md') */
        @media (min-width: 768px) {
            #header.header-shifted #logo-link-header,
            #header.header-shifted #logout-link-header {
                /* Aplicamos la transformación inversa (asumiendo sidebar w-64 = 16rem) */
                transform: translateX(-16rem);
            }
        }
    </style>
</head>
<body class="bg-gray-50">

    <aside id="sidebar" class="w-64 bg-gray-800 text-white min-h-screen p-4 space-y-4 transition-transform duration-300 fixed left-0 top-0 transform -translate-x-full z-30">
        <h4 class="text-xl font-bold mb-4">Menú</h4>
        <a href="<?php echo $baseUrl; ?>index.php?c=Reactivo&a=index" class="block py-2 px-4 rounded hover:bg-gray-700">Visualizar Reactivos</a>
        <a href="<?php echo $baseUrl; ?>index.php?c=Material&a=index" class="block py-2 px-4 rounded hover:bg-gray-700">Visualizar Materiales</a>
        <a href="<?php echo $baseUrl; ?>index.php?c=Clase&a=registrarClase" class="block py-2 px-4 rounded hover:bg-gray-700">Registrar Clase</a>
         <a href="<?php echo $baseUrl; ?>index.php?c=Solicitud&a=index" class="block py-2 px-4 rounded hover:bg-gray-700">Mis Solicitudes</a>
        <a href="/views/generarFichaVista.php" class="block py-2 px-4 rounded hover:bg-gray-700">Generar Fichas Practicas</a>

        </aside>

    <header id="header" class="bg-gray-100 p-4 shadow flex items-center justify-between fixed top-0 left-0 w-full z-20 transition-all duration-300">
        <div class="flex items-center space-x-2">
            <button id="hamburger-btn" class="bg-gray-100 text-black focus:outline-none p-2 rounded-md hover:bg-gray-200" title="Abrir menú">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="6" r="1.5" stroke-width="2"></circle>
                    <circle cx="12" cy="12" r="1.5" stroke-width="2"></circle>
                    <circle cx="12" cy="18" r="1.5" stroke-width="2"></circle>
                </svg>
            </button>
            <a href="#" onclick="history.back(); return false;" title="Atrás" class="p-2 rounded-md hover:bg-gray-200">
                 <img src="<?php echo $baseUrl; ?>assets/imagenes/atras.png" alt="Atrás" class="h-8 w-8" />
            </a>
        </div>

        <a href="/views/DashboardUVista.php" id="logo-link-header" class="flex justify-center">
             <img src="<?php echo $baseUrl; ?>assets/imagenes/logo.png" alt="Logo LABSAFE" class="h-12" />
        </a>

        <a href="<?php echo $baseUrl; ?>index.php?c=Login&a=logout" id="logout-link-header"
           class="bg-gray-800 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition whitespace-nowrap">
            Cerrar Sesión
        </a>
    </header>

    <div id="content-wrapper" class="pt-20 transition-all duration-300">

        <main class="flex-grow p-4 md:p-8">
            <script>
        const menuBtn = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('sidebar');
        const header = document.getElementById('header'); // Necesitamos el header
        const contentWrapper = document.getElementById('content-wrapper'); // Referencia al contenedor del contenido

        // Verificamos que los elementos existan
        if (menuBtn && sidebar && header && contentWrapper) {
            menuBtn.addEventListener('click', () => {
                // 1. Muestra/oculta sidebar
                sidebar.classList.toggle('-translate-x-full');
                // 2. Aplica/quita margen al header
                header.classList.toggle('md:ml-64');
                // 3. Aplica/quita margen al wrapper del contenido
                contentWrapper.classList.toggle('md:ml-64');
                // 4. Añade/quita clase para la compensación CSS
                header.classList.toggle('header-shifted');
            });

            // Lógica inicial
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                header.classList.remove('md:ml-64', 'header-shifted'); // Sin margen ni clase extra en móvil
                contentWrapper.classList.remove('md:ml-64');
            } else {
                // Estado inicial en desktop
                if (sidebar.classList.contains('-translate-x-full')) {
                     header.classList.remove('md:ml-64', 'header-shifted');
                     contentWrapper.classList.remove('md:ml-64');
                } else {
                     header.classList.add('md:ml-64', 'header-shifted');
                     contentWrapper.classList.add('md:ml-64');
                }
            }
        } else {
            console.error("Error JS: Faltan elementos (hamburger-btn, sidebar, header, content-wrapper). Verifica IDs.");
        }
    </script>
    