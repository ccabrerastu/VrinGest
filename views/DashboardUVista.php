<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>LABSAFE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white  flex flex-col">

    <!-- Header -->
     <?php include "../views/partials/header2.php"; ?>
    <!-- Contenido principal -->
    <main class="flex-grow p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Bienvenido a LABSAFE</h1>
        <p class="text-gray-700 mb-6">Hola, estas son tus clases que haz sido registradas para la semana:</p>

        <!-- Tabla de clases -->
        <div class="overflow-x-auto mb-8">
            <table class="table-auto border-collapse border border-gray-300 w-full text-sm text-gray-800">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Hora</th>
                        <th class="border border-gray-300 p-2">Lunes</th>
                        <th class="border border-gray-300 p-2">Martes</th>
                        <th class="border border-gray-300 p-2">Miércoles</th>
                        <th class="border border-gray-300 p-2">Jueves</th>
                        <th class="border border-gray-300 p-2">Viernes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <tr>
                            <td class="border border-gray-300 p-2"></td>
                            <td class="border border-gray-300 p-2"></td>
                            <td class="border border-gray-300 p-2"></td>
                            <td class="border border-gray-300 p-2"></td>
                            <td class="border border-gray-300 p-2"></td>
                            <td class="border border-gray-300 p-2"></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>


    </main>

    <!-- Footer -->
    <?php include "../views/partials/footer.php"; ?>

</body>
</html>
<script>
    const sidebar = document.getElementById('sidebar');
    const btn = document.getElementById('hamburger-btn');

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>