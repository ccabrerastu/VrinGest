<?php
$baseUrl = "/";

// --- Lógica para obtener el nombre del usuario (Admin) ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreUsuario = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Admin';


$reporteActual = [
    'titulo' => 'Reactivos Fiscalizados Utilizados ',
    'columnas' => ['Nombre', 'Responsable', 'Fecha', 'Cantidad'],
    'datos' => [
        ["Hidróxido de Calcio", "Mg. Maritza Flores", "10/04/2025", "10mg"],
        ["Etanol Absoluto", "Dra. Ana Paredes", "12/04/2025", "5ml"], 
    ],
];

$tiposDeReporte = [
    'reactivos_fiscalizados_mes' => 'Uso Reactivos Fiscalizados (Mes)',
    'inventario_materiales' => 'Inventario Actual Materiales',
    'reactivos_proximos_vencer' => 'Reactivos Próximos a Vencer',
    
];

$errors = []; 

$tipoSeleccionado = $_POST['tipo_reporte'] ?? 'reactivos_fiscalizados_mes'; 
$fechaInicioSeleccionada = $_POST['fecha_inicio'] ?? date('Y-m-01'); 
$fechaFinSeleccionada = $_POST['fecha_fin'] ?? date('Y-m-t'); 

?>
<?php
    include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Generación de Reportes</h1>

<div class="bg-white p-4 rounded-lg shadow-md mb-6">
    <form action="#" method="post" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

        <div>
            <label for="tipo_reporte" class="block mb-1 font-semibold text-sm text-gray-700">Tipo de Reporte:</label>
            <select name="tipo_reporte" id="tipo_reporte" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white text-sm">
                <option value="" disabled <?php echo empty($tipoSeleccionado) ? 'selected' : ''; ?>>Seleccione un reporte...</option>
                <?php foreach ($tiposDeReporte as $key => $value): ?>
                    <option value="<?php echo $key; ?>" <?php echo ($tipoSeleccionado == $key) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($value); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-2">
             <div>
                <label for="fecha_inicio" class="block mb-1 font-semibold text-sm text-gray-700">Fecha Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fechaInicioSeleccionada; ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
            </div>
             <div>
                <label for="fecha_fin" class="block mb-1 font-semibold text-sm text-gray-700">Fecha Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="<?php echo $fechaFinSeleccionada; ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
            </div>
        </div>


        <div>
            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 transition">
                Filtrar 
            </button>
        </div>

    </form>
</div>

<div id="report-content" class="bg-white p-4 rounded-lg shadow-md">
    <?php if (!empty($reporteActual) && !empty($reporteActual['datos'])): ?>
        <h2 class="text-xl font-semibold text-gray-800 mb-4"><?php echo htmlspecialchars($reporteActual['titulo']); ?></h2>

        <div class="overflow-x-auto shadow-inner sm:rounded-lg mb-6 border border-gray-200">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <?php foreach ($reporteActual['columnas'] as $columna): ?>
                            <th scope="col" class="px-6 py-3"><?php echo htmlspecialchars($columna); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reporteActual['datos'] as $index => $fila): ?>
                         <tr class="border-b hover:bg-gray-50 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>">
                             <?php foreach ($fila as $celda): ?>
                                 <td class="px-6 py-4 whitespace-nowrap">
                                     <?php echo htmlspecialchars($celda); ?>
                                 </td>
                             <?php endforeach; ?>
                         </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <?php
                // Construir URL de descarga con los filtros actuales
                $downloadParams = http_build_query([
                    'tipo' => $tipoSeleccionado,
                    'fecha_inicio' => $fechaInicioSeleccionada,
                    'fecha_fin' => $fechaFinSeleccionada
                 ]);
            ?>
            <a href="<?php echo $baseUrl; ?>index.php?c=Reporte&a=descargar&<?php echo $downloadParams; ?>" class="bg-gray-600 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition">
                <i class="fas fa-download mr-2"></i>Descargar Informe
            </a>
            </div>

    <?php else: ?>
        <p class="text-center text-gray-500 py-10">Seleccione filtros y haga clic en "Filtrar" o no hay datos para este reporte/periodo.</p> {/* Mensaje ajustado */}
    <?php endif; ?>

</div>


<?php
    // Incluir el footer apropiado
    include 'partials/footer.php';
?>
