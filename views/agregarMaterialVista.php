<?php
session_start();

$baseUrl = "/";

$formData = [
    'nombre_material' => '',
    'tipo_material' => '',
    'cantidad_material' => '',
    'numero_onu_material' => ''
];
$formErrors = [];

include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Agregar Material:</h1>

<?php if (isset($_SESSION['mensaje']) && !empty($_SESSION['mensaje'])): ?>
    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
        <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
    </div>
<?php endif; ?>

<form action="<?php echo $baseUrl; ?>index.php?c=Material&a=agregarMateriales" method="post" enctype="multipart/form-data" class="space-y-4 max-w-2xl">
    <div>
        <label for="nombre" class="block mb-1 font-semibold text-gray-700">Nombre del Material:</label>
        <input type="text" name="nombre" id="nombre" required class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div>
        <label for="id_tipo_material" class="block mb-1 font-semibold text-gray-700">Tipo:</label>
        <select name="id_tipo_material" id="id_tipo_material" required class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
            <option value="" disabled selected>Seleccione un tipo...</option>
            <option value="1">Vidrio</option>
            <option value="2">Plástico</option>
            <option value="3">Metal</option>
            <option value="4">Porcelana</option>
            <option value="5">Papel</option>
            <option value="6">Otro</option>
        </select>
    </div>

    <div>
        <label for="cantidad_stock" class="block mb-1 font-semibold text-gray-700">Cantidad:</label>
        <input type="number" name="cantidad_stock" id="cantidad_stock" required min="0" class="w-full border border-gray-300 rounded px-3 py-2">
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 transition">Agregar</button>
    </div>
</form>

<?php include 'partials/footer.php'; ?>
