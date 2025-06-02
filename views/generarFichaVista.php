<?php

$baseUrl = "/";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombreDocente = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Nombre Docente Placeholder';

$fechaActual = date("d/m/Y"); 

$formData = [
    'titulo_clase' => '',
    'objetivo' => '',
    'materiales_usar' => 'Cargados de la clase registrada...', 
    'reactivos_usar' => 'Cargados de la clase registrada...', 
    'cantidad_pasos' => 2, 
    'paso' => ['', ''], 
    'pregunta_reporte' => ['', ''] 
];
$formErrors = []; 

?>
<?php
    
    include 'partials/header2.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Generar Ficha de Practicas:</h1>

<form action="<?php echo $baseUrl; ?>index.php?c=Ficha&a=generarDescarga" method="post" class="space-y-6">

    <div class="p-4 bg-white rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="nombre_docente" class="block mb-1 font-semibold text-sm text-gray-700">Nombre del Docente:</label>
            <input type="text" name="nombre_docente" id="nombre_docente" value="<?php echo $nombreDocente; ?>" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none text-sm" readonly>
            
        </div>
        <div>
            <label for="fecha_actual" class="block mb-1 font-semibold text-sm text-gray-700">Fecha:</label>
            <input type="text" name="fecha_actual" id="fecha_actual" value="<?php echo $fechaActual; ?>" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none text-sm" readonly>
           
       </div>
    </div>

    <div class="p-4 bg-white rounded-lg shadow-md space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Ingrese Datos:</h2>
        <div>
            <label for="titulo_clase" class="block mb-1 font-semibold text-sm text-gray-700">Titulo de la Clase:</label>
            <input type="text" name="titulo_clase" id="titulo_clase" value="<?php echo htmlspecialchars($formData['titulo_clase']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['titulo_clase']) ? 'border-red-500' : ''; ?>" required>
             <?php if (isset($formErrors['titulo_clase'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['titulo_clase']; ?></p><?php endif; ?>
       </div>
        <div>
            <label for="objetivo" class="block mb-1 font-semibold text-sm text-gray-700">Objetivo:</label>
            <textarea name="objetivo" id="objetivo" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['objetivo']) ? 'border-red-500' : ''; ?>" required><?php echo htmlspecialchars($formData['objetivo']); ?></textarea>
            <?php if (isset($formErrors['objetivo'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['objetivo']; ?></p><?php endif; ?>
        </div>
         <div>
            <label for="materiales_usar" class="block mb-1 font-semibold text-sm text-gray-700">Materiales a utilizar:</label>
            <textarea name="materiales_usar" id="materiales_usar" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none text-sm" readonly><?php echo htmlspecialchars($formData['materiales_usar']); ?></textarea>
            
        </div>
         <div>
            <label for="reactivos_usar" class="block mb-1 font-semibold text-sm text-gray-700">Reactivos a utilizar:</label>
            <textarea name="reactivos_usar" id="reactivos_usar" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none text-sm" readonly><?php echo htmlspecialchars($formData['reactivos_usar']); ?></textarea>
            
        </div>
    </div>

    <div class="p-4 bg-white rounded-lg shadow-md space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Procedimiento:</h2>
        <div>
             <label for="cantidad_pasos" class="block mb-1 font-semibold text-sm text-gray-700">Cantidad de Pasos:</label>
             <div class="flex items-center">
                 <input type="number" name="cantidad_pasos" id="cantidad_pasos" value="<?php echo htmlspecialchars($formData['cantidad_pasos']); ?>" min="1" class="w-20 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['cantidad_pasos']) ? 'border-red-500' : ''; ?>">
                 <button type="button" class="ml-2 bg-gray-200 text-gray-700 font-bold py-1 px-3 rounded hover:bg-gray-300">-</button>
                 <button type="button" class="ml-1 bg-gray-200 text-gray-700 font-bold py-1 px-3 rounded hover:bg-gray-300">+</button>
             </div>
             <?php if (isset($formErrors['cantidad_pasos'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['cantidad_pasos']; ?></p><?php endif; ?>
             
        </div>
        <?php for ($i = 0; $i < $formData['cantidad_pasos']; $i++): ?>
        <div class="ml-4">
            <label for="paso_<?php echo $i + 1; ?>" class="block mb-1 font-semibold text-sm text-gray-600">Paso <?php echo $i + 1; ?>:</label>
            <textarea name="paso[]" id="paso_<?php echo $i + 1; ?>" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['paso'][$i]) ? 'border-red-500' : ''; ?>"><?php echo htmlspecialchars($formData['paso'][$i] ?? ''); ?></textarea>
             <?php if (isset($formErrors['paso'][$i])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['paso'][$i]; ?></p><?php endif; ?>
       </div>
        <?php endfor; ?>
    </div>

     <div class="p-4 bg-white rounded-lg shadow-md space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Reporte de la Práctica:</h2>
         <?php for ($i = 0; $i < count($formData['pregunta_reporte']); $i++): ?>
         <div>
            <label for="pregunta_<?php echo $i + 1; ?>" class="block mb-1 font-semibold text-sm text-gray-600">Pregunta <?php echo $i + 1; ?>:</label>
            <input type="text" name="pregunta_reporte[]" id="pregunta_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($formData['pregunta_reporte'][$i] ?? ''); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm <?php echo isset($formErrors['pregunta_reporte'][$i]) ? 'border-red-500' : ''; ?>">
             <?php if (isset($formErrors['pregunta_reporte'][$i])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['pregunta_reporte'][$i]; ?></p><?php endif; ?>
       </div>
         <?php endfor; ?>
         <button type="button" class="text-blue-600 text-sm hover:underline">+ Añadir Pregunta</button>
    </div>


    <div class="pt-4">
        <button type="submit" class="bg-gray-600 text-white font-semibold py-2 px-6 rounded hover:bg-gray-700 transition">
            Descargar Ficha
        </button>
    </div>

</form>

<?php
    
    include 'partials/footer.php';
?>
