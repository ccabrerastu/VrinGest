<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$baseUrl = "/";

if (!isset($materiales)) {
    $materiales = [];
}
if (!isset($baseUrl)) {
    $baseUrl = "/";
}
$errors = [];
?>
<?php
    include 'partials/header2.php';
?>
<?php if ($statusMessage): ?>
    <div class="max-w-4xl my-4 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 rounded-md shadow-md">
        <div class="flex justify-start">  
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2c-5.523 0-10 4.477-10 10s4.477 10 10 10 10-4.477 10-10-4.477-10-10-10zm0 18a8 8 0 100-16 8 8 0 000 16z"></path>
            </svg>
            <span class="text-left"><?php echo htmlspecialchars($statusMessage); ?></span> 
        </div>
    </div>
<?php endif; ?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Materiales:</h1>

    <?php if (isset($_SESSION['mensaje']) && $_SESSION['mensaje'] !== ''): ?>
    <div class="bg-blue-100 text-blue-800 p-4 rounded-md mb-6">
        <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
    </div>
    <?php unset($_SESSION['mensaje']); ?> 
<?php endif; ?>
<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Tipo</th>
                <th scope="col" class="px-6 py-3">Cantidad</th>
                <th scope="col" class="px-6 py-3">Descripcion</th>
        </thead>
        <tbody>
        <?php if (!empty($materiales)): ?>
                <?php foreach ($materiales as $index => $material): ?>
                    <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <?php echo isset($material['nombre']) ? htmlspecialchars($material['nombre']) : 'N/A'; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo isset($material['tipo']) ? htmlspecialchars($material['tipo']) : 'N/A'; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo isset($material['cantidad_stock']) ? number_format($material['cantidad_stock'], 0) . ' unidades' : 'N/A'; ?>
                        </td>
                       <td class="px-6 py-4">
                        <?php echo isset($material['descripcion']) ? htmlspecialchars($material['descripcion']) : 'N/A'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No hay materiales registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<?php
    include 'partials/footer.php';
?>
