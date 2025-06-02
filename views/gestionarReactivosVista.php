<?php
if (!isset($baseUrl)) {
    $baseUrl = "/";
}
if (!isset($reactivos)) {
    $reactivos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Gestionar Reactivos - LABSAFE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        tbody tr:nth-child(odd) {
            background-color: #FFF1F2;
        }
        tbody tr:nth-child(even) {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body class="bg-white ">

    <?php include "partials/header.php"; ?>

    <div id="content-wrapper" class="flex-1 transition-all duration-300 ">
        <main class="p-4 md:p-8 flex-grow">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Reactivos:</h1>
            <div class="mb-4">
                <a href="<?php echo $baseUrl; ?>index.php?c=Reactivo&a=create" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i>Agregar Reactivo
                </a>
            </div>
            <div class="flex justify-end items-center mb-6">
                <form method="GET" action="<?php echo $baseUrl; ?>index.php" class="flex items-center gap-3 bg-white p-3 rounded-xl shadow-md">
                    <input type="hidden" name="c" value="Reactivo">
                    <input type="hidden" name="a" value="index">

                    <label for="filtro" class="text-sm font-medium text-gray-700">Filtrar por tipo:</label>
                <select name="filtro" id="filtro" onchange="this.form.submit()" class="rounded-lg border border-gray-300 px-4 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Todos</option>
                    <option value="1" <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === '1') ? 'selected' : ''; ?>>Fiscalizados</option>
                    <option value="0" <?php echo (isset($_GET['filtro']) && $_GET['filtro'] === '0') ? 'selected' : ''; ?>>No Fiscalizados</option>
                </select>
                </form>
            </div>

            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                        
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Fórmula</th>
                            <th class="px-6 py-3">Cantidad</th> 
                            <th class="px-6 py-3">F. Vencimiento</th>
                            <th class="px-6 py-3">Fiscalizado</th>
                            <th class="px-6 py-3">NFPA</th> 
                            <th class="px-6 py-3">Ficha Técnica</th> 
                            <th class="px-6 py-3">Ficha Seguridad</th> 
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($reactivos) && is_array($reactivos) && count($reactivos) > 0): ?>
                            <?php foreach ($reactivos as $reactivo): ?>
                                <?php
                                    $idReactivo = $reactivo['id_reactivo'] ?? null;
                                    $nombre = $reactivo['nombre'] ?? 'N/A';
                                    $formula = $reactivo['formula_quimica'] ?? 'N/A';
                                    $unidadId = $reactivo['idunidamedida'] ?? null;
                                    $unidadTexto = $reactivo['nombre_unidad'] ?? 'unidades';
                                    $cantidad = is_numeric($reactivo['cantidad']) ? intval($reactivo['cantidad']) . ' ' . $unidadTexto : 'N/A';
                                    $fechaVenc = !empty($reactivo['fecha_vencimiento']) ? date('d/m/Y', strtotime($reactivo['fecha_vencimiento'])) : 'N/A';
                                    $esFiscalizadoTexto = ($reactivo['es_fiscalizado'] ?? 0) ? 'Sí' : 'No';
                                    $esFiscalizadoClase = ($reactivo['es_fiscalizado'] ?? 0) ? 'text-red-600 font-semibold' : '';

                                    $nfpaDisplay = !empty($reactivo['normanfpa']) ? $baseUrl . $reactivo['normanfpa'] : '';                                   

                                    $urlFichaTecnica = $reactivo['fichatecnica'] ?? '';

                                    $urlFichaSeguridad = $reactivo['fichaseguridad'] ?? '';
                                    $urlEditar = $idReactivo ? $baseUrl . "index.php?c=Reactivo&a=edit&id=" . $idReactivo : '#';
                                    $urlEliminar = $idReactivo ? $baseUrl . "index.php?c=Reactivo&a=delete&id=" . $idReactivo : '#';
                                    $disabledClass = $idReactivo ? '' : 'opacity-50 cursor-not-allowed';
                                ?>
                                <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>">          
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($nombre); ?></td>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($formula); ?></td>
                                    <td class="px-6 py-4"><?php echo htmlspecialchars($cantidad); ?></td> <td class="px-6 py-4 whitespace-nowrap"><?php echo $fechaVenc; ?></td>
                                    <td class="px-6 py-4"><span class="<?php echo $esFiscalizadoClase; ?>"><?php echo $esFiscalizadoTexto; ?></span></td>
                                    <td class="px-6 py-4">
                                <?php if (!empty($nfpaDisplay)): ?>
                                    <img src="<?php echo $nfpaDisplay; ?>" alt="Imagen NFPA" class="w-16 h-16 object-contain border border-gray-300 rounded" />
                                <?php else: ?>
                                    <span class="text-gray-500 text-sm">Sin imagen</span>
                                <?php endif; ?>
                                </td>                                    
                                    <td class="px-6 py-4"><a href="<?php echo $urlFichaTecnica; ?>" target="_blank" class="text-blue-600 hover:underline">Visualizar</a></td>
                                    <td class="px-6 py-4"><a href="<?php echo $urlFichaSeguridad; ?>" target="_blank" class="text-blue-600 hover:underline">Visualizar</a></td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="#" onclick="abrirModalEditar('<?php echo $idReactivo; ?>', '<?php echo htmlspecialchars($nombre); ?>', '<?php echo htmlspecialchars($formula); ?>')" class="font-medium text-blue-600 hover:underline mr-3 <?php echo $disabledClass; ?>">Editar</a>
                                    <a href="<?php echo $urlEliminar; ?>" class="font-medium text-red-600 hover:underline <?php echo $disabledClass; ?>" onclick="<?php echo $idReactivo ? "return confirm('¿Estás seguro de eliminar este reactivo? ID: " . htmlspecialchars($idReactivo) . "');" : "return false;"; ?>">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-center text-gray-500">No hay reactivos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
        </main>
    </div>

    <?php include "partials/footer.php"; ?>
</body>
</html>
<div id="modalEditarReactivo" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl p-6 rounded shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Editar Reactivo</h2>
        <form id="formEditarReactivo" method="POST" action="<?php echo $baseUrl; ?>index.php?c=Reactivo&a=actualizarReactivo">
            <input type="hidden" name="id_reactivo" id="modal_id_reactivo">
            <div class="mb-4">
                <label for="modal_nombre" class="block font-medium">Nombre:</label>
                <input type="text" name="nombre" id="modal_nombre" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="modal_formula" class="block font-medium">Fórmula Química:</label>
                <input type="text" name="formula_quimica" id="modal_formula" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="modal_cantidad" class="block font-medium">Cantidad:</label>
                <input type="number" name="cantidad" id="modal_cantidad" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="modal_fecha_vencimiento" class="block font-medium">Fecha de Vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="modal_fecha_vencimiento" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="cerrarModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="cerrarModal()">×</button>
    </div>
</div>
<script>
function abrirModalEditar(id, nombre,formula ,cantidad, fechaVencimiento) {
 
    document.getElementById('modal_id_reactivo').value = id;
    document.getElementById('modal_nombre').value = nombre;
    document.getElementById('modal_formula').value = formula;
    document.getElementById('modal_cantidad').value = cantidad;
    document.getElementById('modal_fecha_vencimiento').value = fechaVencimiento;
    document.getElementById('modalEditarReactivo').classList.remove('hidden');
    document.getElementById('modalEditarReactivo').classList.add('flex');
}

function cerrarModal() {
    document.getElementById('modalEditarReactivo').classList.remove('flex');
    document.getElementById('modalEditarReactivo').classList.add('hidden');
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />