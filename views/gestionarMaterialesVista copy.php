<?php
// Define la URL base si no está definida globalmente
$baseUrl = "/";

$materiales = [
    ["Tubos de ensayo", "Vidrio", 35],
    ["Cinta de pH", "Papel/Plástico", 50], 
    ["Lupa", "Vidrio", 8],
    ["Probeta", "Vidrio", 10],
    ["Pipeta", "Vidrio", 15],
    ["Embudo", "Vidrio", 8],
];

$errors = []; 

?>
<?php
    include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Materiales:</h1>

<div class="mb-4">
    <a href="agregarMaterialVista.php" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Agregar Material
    </a>
    </div>

<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Tipo</th>
                <th scope="col" class="px-6 py-3">Cantidad</th>
                <th scope="col" class="px-6 py-3 text-right">Acciones</th> </tr>
        </thead>
        <tbody>
            <?php foreach ($materiales as $index => $material): ?>
                <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>"> 
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <?php echo htmlspecialchars($material[0]); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($material[1]); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($material[2]); ?>
                    </td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <a href="#" class="font-medium text-blue-600 hover:underline mr-3">Editar</a>
                        <a href="#" class="font-medium text-red-600 hover:underline">Eliminar</a>
                        </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($materiales)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No hay materiales registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div>
    <a href="registrarDevolucionVista.php" class="bg-gray-600 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition">
        Registrar Devolución
    </a>
    </div>


<?php
    include 'partials/footer.php';
?>
