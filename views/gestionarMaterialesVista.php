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
    include 'partials/header.php';
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

<div class="mb-4">
    <a href="views/agregarMaterialVista.php" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Agregar Material
    </a>
    </div>
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
                <th scope="col" class="px-6 py-3 text-right">Acciones</th> </tr>
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
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <?php
                                $idMaterial = isset($material['id_material']) ? htmlspecialchars($material['id_material']) : '';
                                $urlEditar = $idMaterial ? $baseUrl . "index.php?c=Material&a=edit&id=" . $idMaterial : '#';
                                $urlEliminar = $idMaterial ? $baseUrl . "index.php?c=Material&a=delete&id=" . $idMaterial : '#';
                                $disabledClass = $idMaterial ? '' : 'opacity-50 cursor-not-allowed';
                            ?>
                           <button 
                            class="font-medium text-blue-600 hover:underline mr-3 open-edit-modal"
                            data-id="<?php echo $material['id_material'] ?? ''; ?>"
                            data-nombre="<?php echo htmlspecialchars($material['nombre'] ?? ''); ?>"
                            data-tipo="<?php echo htmlspecialchars($material['tipo'] ?? ''); ?>"
                            data-cantidad="<?php echo htmlspecialchars($material['cantidad_stock'] ?? ''); ?>"
                            data-id-tipo-material="<?php echo htmlspecialchars($material['id_tipo_material'] ?? ''); ?>">
                            Editar
                            </button>
                            <a href="<?php echo $urlEliminar; ?>" class="font-medium text-red-600 hover:underline <?php echo $disabledClass; ?>" onclick="<?php echo $idMaterial ? "return confirm('¿Estás seguro de eliminar este material?');" : "return false;"; ?>">Eliminar</a>
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

<div>
    <a href="registrarDevolucionVista.php" class="bg-gray-600 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition">
        Registrar Devolución
    </a>
    </div>
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-100 opacity-90"></div>
    </div>
    
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
      <div class="bg-white px-4 py-3 sm:px-6 rounded-t-lg border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Editar Material</h2>
      </div>
      
      <form id="editMaterialForm" method="POST" action="index.php?c=Material&a=actualizarMaterial" class="bg-white px-6 py-4">
        <input type="hidden" name="id_material" id="edit-id">
        
        <div class="mb-4">
          <label for="edit-nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
          <input type="text" name="nombre" id="edit-nombre" 
                 class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300 transition duration-150" 
                 required>
        </div>
        
        <div class="mb-4">
          <label for="edit-id_tipo_material" class="block text-sm font-medium text-gray-700 mb-1">Tipo:</label>
          <select name="id_tipo_material" id="edit-id_tipo_material" 
                  class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300 transition duration-150" 
                  required>
            <option value="1">Vidrio</option>
            <option value="2">Plástico</option>
            <option value="3">Metal</option>
            <option value="4">Porcelana</option>
            <option value="5">Papel</option>
            <option value="6">Otro</option>
          </select>
        </div>
        
        <div class="mb-6">
          <label for="edit-cantidad" class="block text-sm font-medium text-gray-700 mb-1">Cantidad:</label>
          <input type="number" name="cantidad_stock" id="edit-cantidad" 
                 class="w-full px-3 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300 transition duration-150" 
                 required>
        </div>
        
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg border-t border-gray-200">
          <button type="submit" 
                  class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-gray-700 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Guardar Cambios
          </button>
          <button type="button" 
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const openModalButtons = document.querySelectorAll(".open-edit-modal");
    const modal = document.getElementById("editModal");
    const closeModalButtons = document.querySelectorAll(".close-modal");

    openModalButtons.forEach(button => {
        button.addEventListener("click", () => {
            document.getElementById("edit-id").value = button.getAttribute("data-id");
            document.getElementById("edit-nombre").value = button.getAttribute("data-nombre");
            document.getElementById("edit-cantidad").value = button.getAttribute("data-cantidad");
            document.getElementById("edit-id_tipo_material").value = button.getAttribute("data-id-tipo-material");

            modal.classList.remove("hidden");
        });
    });

    closeModalButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
});
</script>

<?php
    include 'partials/footer.php';
?>
