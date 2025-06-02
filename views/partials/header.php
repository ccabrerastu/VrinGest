<?php
// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//var_dump($_SESSION);
$nombre = $_SESSION['nombre'] ?? 'Nombre';
$apellido = $_SESSION['apellido'] ?? 'Apellido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>LABSAFE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        #logo-link-header,
        #logout-link-header {
            transition: transform 0.1s ease-in-out;
        }
        @media (min-width: 768px) {
            #header.header-shifted #logo-link-header,
            #header.header-shifted #logout-link-header {
                transform: translateX(-10rem);
            }
        }
      
    /* Sidebar */
    #sidebar {
        background-color: #1E40AF; /* Azul más oscuro */
        color: white;
        min-height: 100vh;
        padding: 1rem;
        transition: transform 0.3s ease-in-out;
    }
    #sidebar h4 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        border-bottom: 2px solid #3B82F6; /* Azul más claro */
        padding-bottom: 0.5rem;
    }
    #sidebar a {
        display: block;
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 0.375rem; /* rounded-md */
        text-decoration: none;
        color: white;
        font-weight: 500;
        transition: background-color 0.1s ease;
        box-shadow: inset 0 0 0 0 transparent;
    }
    #sidebar a:hover {
        background-color: #2563EB; /* Azul intermedio */
        box-shadow: inset 3px 0 0 0 #60A5FA; /* barra lateral al pasar mouse */
        padding-left: 1.25rem;
    }

    /* Header */
    #header {
        background-color: #3B82F6; /* Azul claro */
        color: white;
        padding: 1rem 1.5rem;
        box-shadow: 0 4px 6px -1px rgb(59 130 246 / 0.4);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 9999;
        transition: all 0.3s ease;
    }
    #header button#hamburger-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: white;
        padding: 0.5rem;
        border-radius: 0.375rem;
        transition: background-color 0.1s ease;
    }
    #header button#hamburger-btn:hover {
        background-color: #60A5FA; /* Azul hover */
    }
    #header button#hamburger-btn svg circle {
        stroke: white;
    }
    #header a[title="Atrás"] {
        display: flex;
        align-items: center;
        padding: 0.25rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease;
        color: white;
    }
    #header a[title="Atrás"]:hover {
        background-color: #60A5FA;
    }
    #header a[title="Atrás"] img {
        filter: brightness(0) invert(1); /* icono blanco */
        height: 32px;
        width: 32px;
    }

    /* User info box */
    #header .user-info {
        background-color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        display: flex;
        align-items: center;
        color: #1E3A8A; /* Azul oscuro */
        font-weight: 600;
        font-size: 0.9rem;
    }
    #header .user-info i {
        margin-right: 0.5rem;
        font-size: 1.5rem;
        color: #2563EB;
    }

    

    </style>
</head>
<body class="bg-gray-50">

<aside id="sidebar" class="w-64 bg-blue-600 text-white min-h-screen p-4 space-y-4 fixed left-0 top-0 z-30">
    <h4 class="text-xl font-bold mb-4">Menú</h4>
    <a href="/index.php?c=Equipo&a=index">Gestionar Equipos</a>
    <a href="/index.php?c=Prestamo&a=index">Préstamos de Equipos</a>
    <a href="/index.php?c=GrupoInvestigacion&a=index">Grupos de Investigación</a>
    <a href="/index.php?c=CompraAsignacion&a=index">Compra y Asignación</a>
    <a href="/index.php?c=Presupuesto&a=index">Presupuestos y Proyectos</a>
    <a href="/index.php?c=Reporte&a=index">Reportes y Estadísticas</a>
    <a href="/index.php?c=Configuracion&a=index">Configuración</a>
    <a href="/index.php?c=Login&a=logout">Cerrar Sesión</a>
</aside>

    <header id="header" class="bg-blue-100 p-4 shadow flex items-center justify-between fixed top-0 left-0 w-full z-20 transition-all duration-300">
    <div class="flex items-center space-x-2">
        <button id="hamburger-btn" class="bg-blue-100 text-black focus:outline-none p-2 rounded-md hover:bg-blue-200" title="Abrir menú">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="6" r="1.5" stroke-width="2"></circle>
                <circle cx="12" cy="12" r="1.5" stroke-width="2"></circle>
                <circle cx="12" cy="18" r="1.5" stroke-width="2"></circle>
            </svg>
        </button>
        <a href="#" onclick="history.back(); return false;" title="Atrás" class="p-2 rounded-md hover:bg-blue-200">
            <img src="/assets/imagenes/atras.png" alt="Atrás" class="h-8 w-8" />
        </a>
    </div>

    

    <div class="flex items-center space-x-4">
    <div class="flex items-center bg-white px-3 py-2 rounded-lg shadow-md hover:shadow-lg transition user-info">
    <i class="fas fa-user-circle"></i>
    <span>
        <?php echo htmlspecialchars($nombre . ' ' . $apellido); ?>
    </span>
</div>
    
    
</div>
</header>

    <div id="content-wrapper" class="pt-20 transition-all duration-300 ">
        <main class="flex-grow p-4 md:p-8">
<script>
    const menuBtn = document.getElementById('hamburger-btn');
    const sidebar = document.getElementById('sidebar');
    const header = document.getElementById('header'); 
    const contentWrapper = document.getElementById('content-wrapper');

    if (menuBtn && sidebar && header && contentWrapper) {
        menuBtn.addEventListener('click', () => {
          
            sidebar.classList.toggle('-translate-x-full');
           
            header.classList.toggle('md:ml-64');
           
            contentWrapper.classList.toggle('md:ml-64');
            
            header.classList.toggle('header-shifted');
        });

        
        if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
            header.classList.remove('md:ml-64', 'header-shifted'); 
            contentWrapper.classList.remove('md:ml-64');
        } else {
            
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