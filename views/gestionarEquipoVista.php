<?php require 'views/partials/header.php'; ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📋 Listado de Equipos</h1>

    <div class="mb-4">
        <a href="index.php?c=Equipo&a=crear" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
            ➕ Agregar nuevo equipo
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                   
                    <th class="px-4 py-3 text-left">Tipo</th>
                    <th class="px-4 py-3 text-left">Código Patrimonial</th>
                    <th class="px-4 py-3 text-left">Código Barras</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Fecha Ingreso</th>
                    <th class="px-4 py-3 text-left">Descripción</th>
                    <th class="px-4 py-3 text-left">Ubicación</th>
                    <th class="px-4 py-3 text-left">Grupo Asignado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($equipos)) : ?>
                    <?php foreach ($equipos as $equipo) : ?>
                        <tr class="hover:bg-gray-50">
                            
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['tipo_equipo']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['codigo_patrimonial']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['codigo_barras']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre_estado']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['fecha_ingreso']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['descripcion']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre_grupo']) ?></td>
                            <td class="px-4 py-2 flex justify-center gap-2">
                                <a href="#" 
   data-id="<?= $equipo['id_equipo'] ?>" 
   class="btn-ver bg-blue-500 hover:bg-blue-600 text-white font-semibold px-3 py-1 rounded mr-1">
   👁️
</a>
                                <a href="index.php?c=Equipo&a=editar&id=<?= $equipo['id_equipo'] ?>" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-3 py-1 rounded">
                                    ✏️
                                </a>
                                <a href="index.php?c=Equipo&a=eliminar&id=<?= $equipo['id_equipo'] ?>" onclick="return confirm('¿Estás seguro de eliminar este equipo?')" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-1 rounded">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10" class="px-4 py-4 text-center text-gray-500">No se encontraron equipos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<div id="modalDetalleEquipo" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-xl w-full relative">
    <button id="cerrarModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 font-bold text-2xl">&times;</button>
    <h2 class="text-2xl font-extrabold mb-6 text-indigo-700">Detalle del Equipo</h2>
    <div id="contenidoDetalle">
        <!-- Aquí se cargará el detalle via AJAX -->
    </div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalDetalleEquipo');
    const contenido = document.getElementById('contenidoDetalle');
    const cerrarModalBtn = document.getElementById('cerrarModal');

    // Abrir modal y cargar detalle
    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const idEquipo = this.getAttribute('data-id');
            modal.classList.remove('hidden');
            contenido.innerHTML = '<p>Cargando...</p>';

            // Petición AJAX
            fetch(`index.php?c=Equipo&a=detalle&id=${idEquipo}`)
                .then(response => response.text())
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(err => {
                    contenido.innerHTML = '<p>Error al cargar el detalle.</p>';
                });
        });
    });

    // Cerrar modal
    cerrarModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Cerrar modal si se hace clic fuera del contenido
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
<?php require 'views/partials/footer.php'; ?>
