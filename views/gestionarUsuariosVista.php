<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$statusMessage = $statusMessage ?? ($_SESSION['status_message'] ?? null);
unset($_SESSION['status_message']);

if (!isset($usuarios)) {
    $usuarios = []; 
}
if (!isset($baseUrl)) {
    $baseUrl = "/";
}


$loggedInUserCodigo = $_SESSION['codigo_institucional'] ?? null;
$loggedInUserRol = $_SESSION['idRol'] ?? null; 
$isSuperAdmin = ($loggedInUserCodigo === '212324'); 

?>
<?php include 'partials/header.php'; ?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Lista de Usuarios</h1>

<?php if ($statusMessage): ?>
    <div class="mb-4 p-4 rounded text-sm <?php echo ($statusMessage['type'] === 'success') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'; ?>" role="alert">
        <?php echo htmlspecialchars($statusMessage['text']); ?>
    </div>
<?php endif; ?>

<div class="mb-4">
    <a href="index.php?c=Usuario&a=agregar" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Agregar Usuario
    </a>
</div>

<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Cargo</th>
                <th scope="col" class="px-6 py-3 text-center">Cambiar Rol</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $index => $usuario): ?>
                    <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <?= isset($usuario['nombre_completo']) ? htmlspecialchars($usuario['nombre_completo']) : 'N/A' ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= isset($usuario['rol']) ? htmlspecialchars($usuario['rol']) : 'N/A' ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php
                                $userId = isset($usuario['idusuario']) ? $usuario['idusuario'] : null;
                                $isUserAdmin = (isset($usuario['rol']) && $usuario['rol'] === 'Administrador');

                                $linkHref = '#';
                                $linkText = '';
                                $linkClass = 'bg-gray-400 text-white opacity-50 cursor-not-allowed';
                                $confirmScript = 'return false;';

                                if ($userId) { 
                                    if ($isUserAdmin) {
                                        if ($isSuperAdmin) {
                                            $linkHref = $baseUrl . 'index.php?c=Usuario&a=quitarRolAdmin&id=' . htmlspecialchars($userId);
                                            $linkText = 'Quitar Admin';
                                            $linkClass = 'bg-red-600 text-white hover:bg-red-700';
                                            $confirmScript = "return confirm('¿Estás seguro de que quieres quitar el rol de Administrador a este usuario?');";
                                        } else {
                                            $linkText = 'Admin';
                                        }
                                    } else {
                                        $linkHref = $baseUrl . 'index.php?c=Usuario&a=asignarRolAdmin&id=' . htmlspecialchars($userId);
                                        $linkText = 'Asignar Admin';
                                        $linkClass = 'bg-gray-600 text-white hover:bg-gray-700';
                                        $confirmScript = "return confirm('¿Estás seguro de que quieres asignar el rol de Administrador a este usuario?');";
                                    }
                                } else {
                                    $linkText = 'Error ID';
                                }
                            ?>
                            <?php if ($linkText && $linkText !== 'Admin (Fijo)' && $linkText !== 'Error ID'):  ?>
                                <a href="<?php echo $linkHref; ?>"
                                onclick="<?php echo $confirmScript; ?>"
                                class="<?php echo $linkClass; ?> font-semibold text-xs py-1 px-3 rounded transition whitespace-nowrap">
                                    <?php echo $linkText; ?>
                                </a>
                            <?php elseif ($linkText):  ?>
                                <span class="text-xs text-gray-500 italic"><?php echo $linkText; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        No hay usuarios registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer.php'; ?>
