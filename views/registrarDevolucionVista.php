<?php
$baseUrl = "/";

$clases = [
    ['id' => 1, 'descripcion' => 'Clase 18.03.24 - Mg. Maritza - Quimica General'],
    ['id' => 2, 'descripcion' => 'Clase 19.03.24 - Ing. Junior - Quimica Ambiental'],
];

$formData = [
    'clase_id' => '',
    'materiales_devueltos' => '', 
    'observaciones_devolucion' => ''
];
$formErrors = []; 

?>
<?php
    include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Devolución:</h1>

<form action="<?php echo $baseUrl; ?>index.php?c=Material&a=storeDevolucion" method="post" class="space-y-4 max-w-2xl">

    <div>
        <label for="clase_id" class="block mb-1 font-semibold text-gray-700">Elegir clase:</label>
        <select name="clase_id" id="clase_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white <?php echo isset($formErrors['clase_id']) ? 'border-red-500' : ''; ?>" required>
            <option value="" disabled <?php echo empty($formData['clase_id']) ? 'selected' : ''; ?>>Seleccione una clase...</option>
            <?php foreach ($clases as $clase): ?>
                <option value="<?php echo $clase['id']; ?>" <?php echo ($formData['clase_id'] == $clase['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($clase['descripcion']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($formErrors['clase_id'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['clase_id']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="materiales_devueltos" class="block mb-1 font-semibold text-gray-700">Materiales:</label>
        <textarea name="materiales_devueltos" id="materiales_devueltos" rows="6" placeholder="Listar materiales devueltos y cantidad (ej: Tubos (5), Pipetas (6)...)" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['materiales_devueltos']) ? 'border-red-500' : ''; ?>"><?php echo htmlspecialchars($formData['materiales_devueltos']); ?></textarea>
        <?php if (isset($formErrors['materiales_devueltos'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['materiales_devueltos']; ?></p><?php endif; ?>
        </div>

    <div>
        <label for="observaciones_devolucion" class="block mb-1 font-semibold text-gray-700">Observaciones:</label>
        <textarea name="observaciones_devolucion" id="observaciones_devolucion" rows="4" placeholder="Alguna observación sobre el estado de los materiales, etc." class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['observaciones_devolucion']) ? 'border-red-500' : ''; ?>"><?php echo htmlspecialchars($formData['observaciones_devolucion']); ?></textarea>
        <?php if (isset($formErrors['observaciones_devolucion'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['observaciones_devolucion']; ?></p><?php endif; ?>
    </div>


    <div class="pt-4">
        <button type="submit" class="bg-gray-600 text-white font-semibold py-2 px-6 rounded hover:bg-gray-700 transition">
            Registrar Devolución
        </button>
    </div>

</form>

<?php
    include 'partials/footer.php';
?>
