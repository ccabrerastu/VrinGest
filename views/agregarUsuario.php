<?php
$baseUrl = "/";

if (!isset($formData)) {
    $formData = [
        'nombre' => '',
        'apellidos' => '',
        'codigo_institucional' => '',
        'email' => '',
        'rol' => ''
    ];
}
if (!isset($formErrors)) {
    $formErrors = [];
}
?>

<?php
    include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Agregar Usuario:</h1>

<form action="<?php echo $baseUrl; ?>index.php?c=Usuario&a=agregarUsuario" method="post" class="space-y-4 max-w-2xl">

    <div>
        <label for="nombre" class="block mb-1 font-semibold text-gray-700">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($formData['nombre']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['nombre']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['nombre'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['nombre']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="apellidos" class="block mb-1 font-semibold text-gray-700">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($formData['apellidos']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['apellidos']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['apellidos'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['apellidos']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="codigo_institucional" class="block mb-1 font-semibold text-gray-700">Código Institucional:</label>
        <input type="text" name="codigo_institucional" id="codigo_institucional" value="<?php echo htmlspecialchars($formData['codigo_institucional']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['codigo_institucional']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['codigo_institucional'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['codigo_institucional']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="email" class="block mb-1 font-semibold text-gray-700">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($formData['email']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['email']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['email'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['email']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="contrasena" class="block mb-1 font-semibold text-gray-700">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['contrasena']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['contrasena'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['contrasena']; ?></p><?php endif; ?>
    </div>

    <div>
    <label for="rol" class="block mb-1 font-semibold text-gray-700">Rol:</label>
    <select name="rol" id="rol" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['rol']) ? 'border-red-500' : ''; ?>" required>
        <option value="" disabled <?php echo empty($formData['rol']) ? 'selected' : ''; ?>>Seleccione un rol...</option>
        <option value="2" <?php echo ($formData['rol'] == '2') ? 'selected' : ''; ?>>Administrador</option>
        <option value="1" <?php echo ($formData['rol'] == '1') ? 'selected' : ''; ?>>Docente</option>
    </select>
    <?php if (isset($formErrors['rol'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['rol']; ?></p>
    <?php endif; ?>
</div>

    <div class="pt-4">
        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 transition">
            Agregar Usuario
        </button>
    </div>

</form>

<?php
    include 'partials/footer.php';
?>
