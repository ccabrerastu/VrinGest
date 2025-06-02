<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header -->
    <?php include "views/partials/header.php"; ?>

    <!-- Contenido principal -->
    <main class="flex-grow px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Bienvenido a VrinGest</h1>
        <p class="text-gray-700 mb-6">Hola, estos son los reportes semanales:</p>

        <!-- Gráficos -->
        <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Gráfico de barras: Préstamos -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Préstamos Semanales</h2>
                <canvas id="prestamosBarChart" height="250"></canvas>
            </div>

            <!-- Gráfico de pastel: Estado del Inventario -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Estado del Inventario</h2>
                <canvas id="inventarioPieChart" height="250"></canvas>
            </div>

            <!-- Gráfico de líneas: Préstamos Acumulados -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Préstamos Acumulados</h2>
                <canvas id="prestamosLineChart" height="250"></canvas>
            </div>

        </section>

    </main>

    <!-- Footer -->
    <?php include "views/partials/footer.php"; ?>

    <script>
        // Datos simulados para el gráfico de barras
        const prestamosData = {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [{
                label: 'Cantidad de préstamos',
                data: [15, 22, 13, 19],
                backgroundColor: 'rgba(59, 130, 246, 0.6)', // azul pastel
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        };

        // Opciones para gráfico de barras
        const prestamosOptions = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    },
                    grid: {
                        color: '#e0e7ff',
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#1e40af', font: { weight: 'bold' } }
                },
                tooltip: {
                    backgroundColor: '#3b82f6',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                }
            }
        };

        // Datos simulados para gráfico de pastel (inventario)
        const inventarioData = {
            labels: ['Disponible', 'En uso', 'En mantenimiento', 'Dañado'],
            datasets: [{
                label: 'Estado Inventario',
                data: [45, 20, 10, 5],
                backgroundColor: [
                    'rgba(147, 197, 253, 0.7)',  // azul pastel
                    'rgba(96, 165, 250, 0.7)',   // azul intermedio pastel
                    'rgba(191, 219, 254, 0.7)',  // azul muy claro pastel
                    'rgba(220, 38, 38, 0.7)'     // rojo pastel para dañado
                ],
                borderColor: 'white',
                borderWidth: 2,
            }]
        };

        // Opciones para gráfico de pastel
        const inventarioOptions = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#1e40af', font: { weight: 'bold' } }
                },
                tooltip: {
                    backgroundColor: '#3b82f6',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                }
            }
        };

        // Datos simulados para gráfico de líneas (préstamos acumulados)
        const prestamosAcumuladosData = {
            labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
            datasets: [{
                label: 'Préstamos Acumulados',
                data: [15, 37, 50, 69], // acumulado progresivo
                fill: false,
                borderColor: 'rgba(16, 185, 129, 0.8)', // verde pastel
                backgroundColor: 'rgba(16, 185, 129, 0.5)',
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        };

        // Opciones para gráfico de líneas
        const prestamosAcumuladosOptions = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#d1fae5',
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#065f46', font: { weight: 'bold' } }
                },
                tooltip: {
                    backgroundColor: '#10b981',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                }
            }
        };

        // Inicializar gráficos con Chart.js
        window.addEventListener('DOMContentLoaded', () => {
            const ctxPrestamos = document.getElementById('prestamosBarChart').getContext('2d');
            new Chart(ctxPrestamos, {
                type: 'bar',
                data: prestamosData,
                options: prestamosOptions,
            });

            const ctxInventario = document.getElementById('inventarioPieChart').getContext('2d');
            new Chart(ctxInventario, {
                type: 'pie',
                data: inventarioData,
                options: inventarioOptions,
            });

            const ctxPrestamosLine = document.getElementById('prestamosLineChart').getContext('2d');
            new Chart(ctxPrestamosLine, {
                type: 'line',
                data: prestamosAcumuladosData,
                options: prestamosAcumuladosOptions,
            });
        });
    </script>

</body>
</html>
