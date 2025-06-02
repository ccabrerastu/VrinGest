<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Obtener valores desde la sesión
$nombre = $_SESSION['nombre'] ?? 'Usuario';
$correo = $_SESSION['correo'] ?? 'correo@institucional.com';
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LABSAFE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="bg-gray-100 p-8 rounded-lg shadow-lg flex gap-8 w-full max-w-4xl">
        
        <!-- Izquierda: Logo y dibujo -->
        <div class="flex flex-col items-center w-1/2">
            <img src="/assets/imagenes/logo.png" alt="Logo Universidad" class="w-40 mb-6">
            <img src="/assets/imagenes/laboratorio.png" alt="Imagen laboratorio" class="w-full max-w-xs">
        </div>

        <!-- Derecha: Formulario -->
        <form action="/index.php?c=Login&a=validarCodigo" method="post" class="w-1/2 space-y-4">
            <h1 class="text-3xl font-bold text-center mb-6 drop-shadow">LABSAFE</h1>

            <!-- Mensaje de bienvenida con nombre y correo -->
            <div class="text-center mb-6">
                <p class="font-semibold text-lg">Hola, <?= htmlspecialchars($nombre) ?>.</p>
                <p class="font-semibold text-md">Se envió un código de verificación a tu correo: <?= htmlspecialchars($correo) ?>.</p>
            </div>

            <!-- Caja de texto para ingresar el código de verificación -->
            <div>
                <label for="codigo_verificacion" class="block mb-1 font-semibold">Código de verificación:</label>
                <input type="text" name="codigo_verificacion" id="codigo_verificacion" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (!empty($error)): ?>
                <div class="text-red-600 font-semibold"><?= $error ?></div>
            <?php endif; ?>

            <!-- Botón para enviar el código -->
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition flex items-center justify-center gap-2">
                Validar Código
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </button>
        </form>
    </div>

</body>
</html>