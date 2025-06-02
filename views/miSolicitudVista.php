<?php
$baseUrl = "/";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreUsuario = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Admin';
$agrupadas = [];

foreach ($solicitudes as $s) {
    $id = $s['idclase'];
    if (!isset($agrupadas[$id])) {
        $agrupadas[$id] = $s;
        $agrupadas[$id]['reactivos'] = [$s['nombre']];
    } else {
        $agrupadas[$id]['reactivos'][] = $s['nombre'];
    }
}
include 'partials/header2.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Estado de Mis Solicitudes</h1>
<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th class="px-6 py-3">Fecha</th>
                <th class="px-6 py-3">Hora Inicio</th>
                <th class="px-6 py-3">Hora Fin</th>
                <th class="px-6 py-3">Laboratorio</th>
                <th class="px-6 py-3">Curso</th>
                <th class="px-6 py-3">Reactivos</th>
                <th class="px-6 py-3">Justificación</th>
                <th class="px-6 py-3">Estado</th>
            </tr>
        </thead>
        <tbody>
           <?php if (!empty($agrupadas)): ?>
    <?php foreach (array_values($agrupadas) as $index => $solicitud): ?>
        <tr class="border-b hover:bg-gray-100 <?= $index % 2 === 0 ? 'bg-white' : 'bg-pink-50' ?>">
            <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($solicitud['fecha_clase']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($solicitud['hora_inicio']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($solicitud['hora_fin']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($solicitud['numero']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($solicitud['nombre_curso']) ?></td>
            <td class="px-6 py-4">
                <?php foreach ($solicitud['reactivos'] as $reactivo): ?>
                    <span class="inline-block bg-gray-100  px-2 py-1 text-xs text-gray-800 mb-1"><?= htmlspecialchars($reactivo) ?></span><br>
                <?php endforeach; ?>
            </td>
            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="<?= htmlspecialchars($solicitud['justificacion']) ?>">
                <?= htmlspecialchars($solicitud['justificacion']) ?>
            </td>
            <td class="px-6 py-4 font-semibold">
                <?php
                switch (strtolower($solicitud['estado'])) {
                    case 'aceptado':
                    case 'aprobado':
                        echo '<span class="text-green-600 font-bold">' . htmlspecialchars($solicitud['estado']) . '</span>';
                        break;
                    case 'rechazado':
                        echo '<span class="text-red-600 font-bold">' . htmlspecialchars($solicitud['estado']) . '</span>';
                        break;
                    default:
                        echo '<span class="text-gray-600">' . htmlspecialchars($solicitud['estado']) . '</span>';
                        break;
                }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
            No hay solicitudes registradas.
        </td>
    </tr>
<?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'partials/footer.php'; ?>
