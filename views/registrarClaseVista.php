<?php
$baseUrl = "/";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreDocente = isset($_SESSION['nombre_docente']) ? htmlspecialchars($_SESSION['nombre_docente']) : '';
$apellidoDocente = isset($_SESSION['apellido_docente']) ? htmlspecialchars($_SESSION['apellido_docente']) : '';

$nombre = isset($_SESSION['nombre_docente']) ? $_SESSION['nombre_docente'] : '';
$apellido = isset($_SESSION['apellido_docente']) ? $_SESSION['apellido_docente'] : '';
$nombreCompleto = htmlspecialchars(trim($nombre . ' ' . $apellido));
$formData = [
    'nombre_docente' => $nombreCompleto,
    'hora_inicio' => '',
    'hora_fin' => '',
    'fecha_clase' => '',
    
];
$formErrors = []; 


if (!isset($materiales)) {
    $materiales = [];
}
if (!isset($reactivos)) {
    $reactivos = [];
}

$errors = [];
// echo "<pre>"; 
// var_dump($_SESSION);

// echo "</pre>";
?>

<?php
    
    include 'partials/header2.php'; 
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Agregar clase:</h1>
<?php if (isset($_SESSION['status_message']) && $_SESSION['status_message'] !== ''): ?>
    <div 
        id="status-message" 
        class="bg-blue-100 border border-blue-400 text-blue-800 px-6 py-4 rounded-md mb-6 shadow-md max-w-xl ml-0
           transition-opacity duration-700 ease-in-out opacity-100"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <strong class="font-semibold">¡Éxito!</strong>
        <p><?php echo $_SESSION['status_message']; ?></p>
    </div>
    <?php unset($_SESSION['status_message']); ?>
<?php endif; ?>
<form action="<?php echo $baseUrl; ?>index.php?c=Clase&a=guardarClase" method="post" class="space-y-6">
    
<input type="hidden" name="id_usuario" value="<?= $_SESSION['idusuario'] ?>">
    <div class="p-4 bg-white rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="nombre_docente" class="block mb-1 font-semibold text-sm text-gray-700">Nombre Docente:</label>
            <input type="text" name="nombre_docente" id="nombre_docente" value="<?php echo htmlspecialchars($formData['nombre_docente']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm" readonly>
            
        </div>
       <div class="flex flex-col md:flex-row md:items-end gap-6">
    <?php $hoy = date('Y-m-d'); ?>
    <div class="flex-1">
        <label for="fecha_clase" class="block mb-1 font-semibold text-sm text-gray-700">Fecha de la Clase:</label>
        <input 
            type="date" 
            name="fecha_clase" 
            id="fecha_clase" 
            value="<?php echo htmlspecialchars($formData['fecha_clase']); ?>" 
            min="<?php echo $hoy; ?>"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['fecha_clase']) ? 'border-red-500' : ''; ?>" 
            required
        >
        <?php if (isset($formErrors['fecha_clase'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['fecha_clase']; ?></p>
        <?php endif; ?>
    </div>

    

    <!-- Laboratorio -->
    <div class="flex-1">
        <label for="laboratorio" class="block mb-1 font-semibold text-sm text-gray-700">Laboratorio:</label>
        <select 
            name="laboratorio" 
            id="laboratorio" 
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['laboratorio']) ? 'border-red-500' : ''; ?>"
            required
        >
            <option value="">Selecciona un laboratorio</option>
            <option value="2" <?php if (isset($formData['laboratorio']) && $formData['laboratorio'] === 'Q-106') echo 'selected'; ?>>Q-106</option>
            <option value="1" <?php if (isset($formData['laboratorio']) && $formData['laboratorio'] === 'R-202') echo 'selected'; ?>>R-202</option>
        </select>
        <?php if (isset($formErrors['laboratorio'])): ?>
            <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['laboratorio']; ?></p>
        <?php endif; ?>
    </div>
</div>
        <div>
            
            <label for="bloque_horario" class="block mb-1 font-semibold text-sm text-gray-700">Horario de la Clase:</label>
            <select name="bloque_horario" id="bloque_horario" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['bloque_horario']) ? 'border-red-500' : ''; ?>">
                <option value="">Seleccione un bloque horario</option>
                <option value="08:00-10:00" <?php echo (isset($formData['bloque_horario']) && $formData['bloque_horario'] === '08:00-10:00') ? 'selected' : ''; ?>>08:00 - 10:00</option>
                <option value="10:00-12:00" <?php echo (isset($formData['bloque_horario']) && $formData['bloque_horario'] === '10:00-12:00') ? 'selected' : ''; ?>>10:00 - 12:00</option>
                <option value="12:00-14:00" <?php echo (isset($formData['bloque_horario']) && $formData['bloque_horario'] === '12:00-14:00') ? 'selected' : ''; ?>>12:00 - 14:00</option>
                <option value="14:00-16:00" <?php echo (isset($formData['bloque_horario']) && $formData['bloque_horario'] === '14:00-16:00') ? 'selected' : ''; ?>>14:00 - 16:00</option>
                <option value="16:00-18:00" <?php echo (isset($formData['bloque_horario']) && $formData['bloque_horario'] === '16:00-18:00') ? 'selected' : ''; ?>>16:00 - 18:00</option>

            </select>
            <?php if (isset($formErrors['bloque_horario'])): ?>
                <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['bloque_horario']; ?></p>
            <?php endif; ?>
        </div>


        <div>
            <label for="curso" class="block mb-1 font-semibold text-sm text-gray-700">Curso:</label>
            <select name="curso" id="curso" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['curso']) ? 'border-red-500' : ''; ?>" required>
              <option value="">Seleccione un curso</option>
              <option value="1" <?php echo ($formData['curso'] ?? '') === 'Química Ambiental' ? 'selected' : ''; ?>>Química Ambiental</option>
              <option value="2" <?php echo ($formData['curso'] ?? '') === 'Química Orgánica' ? 'selected' : ''; ?>>Química Orgánica</option>
              <option value="3" <?php echo ($formData['curso'] ?? '') === 'Química Básica' ? 'selected' : ''; ?>>Química Básica</option>
              <option value="4" <?php echo ($formData['curso'] ?? '') === 'Fisicoquímica' ? 'selected' : ''; ?>>Fisicoquímica</option>
              <option value="5" <?php echo ($formData['curso'] ?? '') === 'Bioquímica' ? 'selected' : ''; ?>>Bioquímica</option>
              <option value="6" <?php echo ($formData['curso'] ?? '') === 'Química General' ? 'selected' : ''; ?>>Química General</option>
            </select>
    <?php if (isset($formErrors['curso'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['curso']; ?></p>
    <?php endif; ?>
</div>
<div>
    <label for="justificacion" class="block mb-1 font-semibold text-sm text-gray-700">Justificación de retiro:</label>
    <textarea name="justificacion" id="justificacion" rows="3" placeholder="Explique brevemente la razón del retiro" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['justificacion']) ? 'border-red-500' : ''; ?>"><?php echo htmlspecialchars($formData['justificacion'] ?? ''); ?></textarea>
    <?php if (isset($formErrors['justificacion'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['justificacion']; ?></p>
    <?php endif; ?>
</div>


    </div>

    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Elegir Reactivos:</h2>
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-2">Nombre</th>
                        <th scope="col" class="px-4 py-2">Cant. Disponible</th>
                        <th scope="col" class="px-4 py-2">Fiscalizado</th>
                        <th scope="col" class="px-4 py-2">Ingresar Cant. a Usar</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($reactivos) && is_array($reactivos) && count($reactivos) > 0): ?>
                        <?php foreach ($reactivos as $index => $reactivo): ?>
                            <?php
                                $idReactivo = $reactivo['id_reactivo'] ?? null;
                                $nombre = $reactivo['nombre'] ?? 'N/A';
                                $cantidad = is_numeric($reactivo['cantidad']) ? intval($reactivo['cantidad']) . ' ' . ($reactivo['nombre_unidad'] ?? '') : 'N/A';
                                $esFiscalizadoTexto = ($reactivo['es_fiscalizado'] ?? 0) ? 'Sí' : 'No';
                                $esFiscalizadoClase = ($reactivo['es_fiscalizado'] ?? 0) ? 'text-red-600 font-semibold' : '';
                            ?>
                            <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><?php echo htmlspecialchars($nombre); ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($cantidad); ?></td>
                                <td class="px-6 py-4"><span class="<?php echo $esFiscalizadoClase; ?>"><?php echo $esFiscalizadoTexto; ?></span></td>
                                <td class="px-6 py-4">
                                    <input type="number" name="reactivo_cantidad[<?php echo $idReactivo; ?>]" min="0" step="0.01" placeholder="0" class="w-20 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay reactivos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Elegir Materiales:</h2>
         <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-2">Nombre</th>
                        <th scope="col" class="px-4 py-2">Tipo</th>
                        <th scope="col" class="px-4 py-2">Cant. Disponible</th>
                        <th scope="col" class="px-4 py-2">Ingresar Cant. a Usar</th>
                       
                    </tr>
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
                            <input type="number" name="material_cantidad[<?php echo $material['id_material']; ?>]" min="0" step="0.01" placeholder="0" class="w-20 border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
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
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-green-600 text-white font-semibold py-2 px-6 rounded hover:bg-green-700 transition">
            Registrar Clase
        </button>
    </div>

</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInput = document.getElementById('fecha_clase');

        // Establece la fecha mínima como hoy (si no lo haces en PHP)
        const hoy = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('min', hoy);

        // Validar que no sea domingo
        fechaInput.addEventListener('change', function () {
            const seleccionada = new Date(this.value);
            const dia = seleccionada.getUTCDay(); // 0 = domingo

            if (dia === 0) {
                alert("No se pueden seleccionar domingos.");
                this.value = ""; // Limpia el campo
            }
        });
    });
</script>

<?php
    include 'partials/footer.php';
?>
