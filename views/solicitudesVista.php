<?php
$baseUrl = "/";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreUsuario = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Admin';

$id_usuario_decision = $_SESSION['idusuario'];
//var_dump($id_usuario_decision);
$errors = [];
?>

<?php include 'partials/header.php'; ?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Solicitudes Pendientes de Retiro de Reactivos</h1>
<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th class="px-6 py-3">Solicitante(s)</th>
                <th class="px-6 py-3">F. Solicitud</th>
                <th class="px-6 py-3">F. Uso Previsto</th>
                <th class="px-6 py-3">Curso</th>
                <th class="px-6 py-3">Reactivos Solicitados</th>
                <th class="px-6 py-3">Justificación</th>
                <th class="px-6 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
<?php if (!empty($solicitudesPendientesAgrupadas)): ?>
    <?php $useWhite = true; ?>
    <?php foreach ($solicitudesPendientesAgrupadas as $solicitud): ?>
        <?php 
            $rowClass = $useWhite ? 'bg-white' : 'bg-pink-50'; 
            $useWhite = !$useWhite;
            $idSolicitud = $solicitud['reactivos'][0]['id_solicitud'] ?? '';
            $estado = $solicitud['estado'] ?? null;  // Aquí el estado actual de la solicitud
        ?>
        <tr class="border-b hover:bg-gray-100 <?= $rowClass ?>">
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <?php foreach ($solicitud['solicitantes'] as $nombre): ?>
                    <div><?= htmlspecialchars($nombre) ?></div>
                <?php endforeach; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($solicitud['fecha_solicitud']) ?></td>
            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($solicitud['fecha_uso']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($solicitud['curso']) ?></td>
            <td class="px-6 py-4">
                <ul class="list-disc list-inside text-xs">
                    <?php foreach ($solicitud['reactivos'] as $reactivo): ?>
                        <li>
                            <?= htmlspecialchars($reactivo['nombre']) ?> (<?= htmlspecialchars($reactivo['cantidad']) ?>)
                            <?php if ($reactivo['fiscalizado']): ?>
                                <span class="ml-1 text-red-600 font-bold" title="Reactivo Fiscalizado">*</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </td>
            <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate" title="<?= htmlspecialchars($solicitud['justificacion']) ?>">
                <?= htmlspecialchars($solicitud['justificacion']) ?>
            </td>
            <td class="px-6 py-4 text-center whitespace-nowrap space-x-2">
                <?php if ($estado === null || $estado === ''): ?>
                    <!-- Sin estado, muestro botones -->
                    <a href="#" 
                       class="bg-green-500 text-white font-semibold text-xs py-1 px-3 rounded hover:bg-green-600 transition cursor-pointer" 
                       title="Aceptar Solicitud"
                       onclick="openModal('aceptar', <?= htmlspecialchars($idSolicitud, ENT_QUOTES, 'UTF-8') ?>, this)">
                       <i class="fas fa-check"></i> Aceptar
                    </a>

                    <a href="#" 
                       class="bg-red-500 text-white font-semibold text-xs py-1 px-3 rounded hover:bg-red-600 transition cursor-pointer" 
                       title="Rechazar Solicitud"
                       onclick="openModal('rechazar', <?= htmlspecialchars($idSolicitud, ENT_QUOTES, 'UTF-8') ?>, this)">
                       <i class="fas fa-times"></i> Rechazar
                    </a>
                <?php elseif ($estado === 'aceptar'): ?>
                    <!-- Estado aceptado -->
                    <span class="text-green-600 font-semibold">Solicitud aceptada</span>
                <?php elseif ($estado === 'rechazar'): ?>
                    <!-- Estado rechazado -->
                    <span class="text-red-600 font-semibold">Solicitud rechazada</span>
                <?php else: ?>
                    <!-- Otro estado si fuera -->
                    <span><?= htmlspecialchars($estado) ?></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr class="bg-white">
        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
            No hay solicitudes pendientes.
        </td>
    </tr>
<?php endif; ?>
        </tbody>
    </table>
</div>
<div id="decisionModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-lg font-bold mb-4" id="modalTitle">Decisión</h2>
    
    <!-- Formulario dentro del modal -->
    <form id="decisionForm" action="index.php?c=Solicitud&a=actualizarEstadoSolicitud" method="POST">
      <input type="hidden" name="id_solicitud" id="modalSolicitudId">
      <input type="hidden" name="estado" id="modalEstado">
      
      <div class="mb-4">
        <label for="nota" class="block text-sm font-medium">Observación</label>
        <textarea id="nota" name="nota" rows="3" class="w-full p-2 border rounded" required></textarea>
      </div>
      
      <!-- Contenedor para mostrar mensajes dinámicos -->
      <div id="resultadoMensaje" class="hidden p-2 mb-4 border rounded text-sm"></div>
      
      <div class="flex justify-end gap-2">
        <button type="button" onclick="closeModal()" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
        <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
      </div>
    </form>
  </div>
</div>
  
</div> 
<?php include 'partials/footer.php';
var_dump($_POST['id_solicitud'] ?? 'No llegó id_solicitud');
var_dump($_POST['estado'] ?? 'No llegó estado');

?>

<script>
   document.addEventListener('DOMContentLoaded', () => {
  let lastClickedElement = null; // Guardamos el botón que abrió el modal

  function openModal(accion, idSolicitud, element) {
    lastClickedElement = element; // Guardamos el elemento para actualizar luego

    const modal = document.getElementById('decisionModal');
    const titulo = document.getElementById('modalTitle');
    const inputId = document.getElementById('modalSolicitudId');
    const inputEstado = document.getElementById('modalEstado');
    const resultadoBox = document.getElementById('resultadoMensaje');
    const textareaNota = document.getElementById('nota');

    modal.classList.remove('hidden');
    resultadoBox.classList.add('hidden');
    resultadoBox.innerText = '';
    textareaNota.value = '';

    if (accion === 'aceptar') {
      titulo.textContent = 'Aceptar Solicitud';
      inputEstado.value = 'aceptar';
    } else if (accion === 'rechazar') {
      titulo.textContent = 'Rechazar Solicitud';
      inputEstado.value = 'rechazar';
    }

    inputId.value = idSolicitud;

    console.log('openModal - id_solicitud:', inputId.value);
    console.log('openModal - estado:', inputEstado.value);
  }

  function closeModal() {
    const modal = document.getElementById('decisionModal');
    modal.classList.add('hidden');
  }
document.getElementById('decisionForm').addEventListener('submit', async function(event) {
  event.preventDefault();
  const formData = new FormData(this);
  const resultadoBox = document.getElementById('resultadoMensaje');

  try {
    const response = await fetch('index.php?c=Solicitud&a=actualizarEstadoSolicitud', {
      method: 'POST',
      body: formData
    });

    const responseText = await response.text();
    console.log('Respuesta del servidor:', responseText);

    if (response.ok) {
      closeModal();
      location.reload();  // <--- recarga la página para actualizar estado
    } else {
      resultadoBox.innerText = responseText;
      resultadoBox.classList.remove('hidden');
      // Mantener modal abierto para mostrar error
    }
  } catch (error) {
    console.error('Error en la petición:', error);
    alert('Error de comunicación con el servidor.');
  }
});

  // Opcional: cerrar modal con clic fuera o ESC
  document.getElementById('decisionModal').addEventListener('click', e => {
    if (e.target.id === 'decisionModal') closeModal();
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
  });

  // Exportar las funciones al global para que los onclick inline las puedan usar
  window.openModal = function(accion, idSolicitud) {
    // Pasamos el elemento clickeado a openModal para guardarlo
    // Esto requiere cambiar el onclick inline para pasar `this`
    openModal(accion, idSolicitud, event.currentTarget);
  }
  window.closeModal = closeModal;
});

</script>
