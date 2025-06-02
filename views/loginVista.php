<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login VrinGest</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="h-full flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-lg max-w-4xl w-full mx-4 flex flex-col md:flex-row overflow-hidden">

        <!-- Lado izquierdo: imagen y texto -->
        <div class="md:w-1/2 bg-gradient-to-tr from-blue-600 to-indigo-700 flex flex-col justify-center items-center p-8 text-white">
            <img src="/assets/imagenes/logo.png" alt="Logo Universidad" class="w-32 mb-6" />
            <h2 class="text-3xl font-extrabold mb-2">Bienvenido a VrinGest</h2>
            <p class="text-lg font-light max-w-xs text-center">Sistema de gestión de inventario. Ingresa con tu cuenta para acceder.</p>
            <img src="/assets/imagenes/logo.jpg" alt="Laboratorio" class="mt-8 max-w-xs w-full object-contain" />
        </div>

        <!-- Lado derecho: formulario -->
        <form action="index.php?c=Login&a=autenticar" method="post" class="md:w-1/2 p-10 space-y-6" novalidate>

            <h1 class="text-4xl font-bold text-gray-800 text-center mb-6">Iniciar Sesión</h1>

            <div>
                <label for="codigo_institucional" class="block text-gray-700 font-semibold mb-1">Usuario</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="codigo_institucional" 
                        id="codigo_institucional" 
                        placeholder="Ingrese su nombre de usuario"
                        required
                        class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                    <i class="bi bi-person absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label for="clave" class="block text-gray-700 font-semibold mb-1">Contraseña</label>
                <div class="relative">
                    <input 
                        type="password" 
                        name="clave" 
                        id="clave" 
                        placeholder="Ingrese su contraseña"
                        required
                        class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    />
                    <i class="bi bi-lock-fill absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>

            <div class="flex justify-center">
                <div class="g-recaptcha" data-sitekey="6LcrZhwrAAAAAEua4kzQ3pQzs_mLmvSTlvsq2qxp"></div>
            </div>

            <?php if (!empty($error)): ?>
                <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded relative" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <button 
                type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-3 rounded-md flex justify-center items-center gap-2"
            >
                Ingresar
                <i class="bi bi-box-arrow-in-right text-lg"></i>
            </button>

            <p class="text-center text-gray-500 text-sm mt-4">
                ¿Olvidaste tu contraseña? 
                <a href="#" class="text-indigo-600 hover:text-indigo-800 font-semibold">Recupérala aquí</a>
            </p>

        </form>

    </div>

</body>
</html>
