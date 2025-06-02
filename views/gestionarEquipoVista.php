<?php require 'views/partials/header.php'; ?>
<style>
    html, body {
    height: 100%;
    overflow: auto;
}
    </style>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📋 Listado de Equipos</h1>

    <div class="mb-4">
    <button id="openAgregarEquipoModal" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
        ➕ Agregar nuevo equipo
    </button>
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
                            
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre_tipo']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['codigo_patrimonial']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['codigo_barras']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre_estado']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['fecha_ingreso']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['descripcion']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($equipo['nombre_ubicacion']) ?></td>
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

<br>
<br>
<br>
<div id="modalAgregarEquipo" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-[999]">
   <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-3xl relative mt-16">

        <button id="cerrarAgregarModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 font-bold text-2xl">&times;</button>
        <h2 class="text-3xl font-extrabold mb-6 text-indigo-700 text-center">Agregar nuevo equipo</h2>
        
        <form action="index.php?c=Equipo&a=crear" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_tipo_equipo" class="block font-semibold mb-1">Tipo de equipo</label>
                <select id="id_tipo_equipo" name="id_tipo_equipo" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <option value="" disabled selected>Seleccione un tipo</option>
                <?php foreach ($tiposEquipo as $tipo): ?>
                <option value="<?= htmlspecialchars($tipo['id_tipo']) ?>">
                <?= htmlspecialchars($tipo['nombre_tipo']) ?>
                 </option>
                <?php endforeach; ?>
                </select>
            </div>

            <div>
    <label for="codigo_patrimonial" class="block font-semibold mb-1">Código Patrimonial</label>
    <input type="text" id="codigo_patrimonial" name="codigo_patrimonial" 
           value="<?= htmlspecialchars($nuevoCodigoPatrimonial ?? '') ?>" 
           readonly 
           class="bg-gray-100 w-full border border-gray-300 rounded px-3 py-2" />
</div>

            <div>
                <label for="codigo_barras" class="block font-semibold mb-1">Código de Barras</label>
                <input type="text" id="codigo_barras" name="codigo_barras" class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>

            <div>
                <label for="estado" class="block font-semibold mb-1">Estado</label>
                <select id="estado" name="estado" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado['id_estado'] ?>"><?= htmlspecialchars($estado['nombre_estado']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="fecha_ingreso" class="block font-semibold mb-1">Fecha de Ingreso</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" required class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>

            <div>
                <label for="grupo" class="block font-semibold mb-1">Grupo</label>
                <select id="grupo" name="grupo" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <?php foreach ($grupos as $grupo): ?>
                        <option value="<?= $grupo['id_grupo'] ?>"><?= htmlspecialchars($grupo['nombre_grupo']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="descripcion" class="block font-semibold mb-1">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            </div>

            <div class="md:col-span-2 text-right">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded shadow transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalDetalleEquipo');
    const contenido = document.getElementById('contenidoDetalle');
    const cerrarModalBtn = document.getElementById('cerrarModal');

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


    cerrarModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalDetalle = document.getElementById('modalDetalleEquipo');
    const contenidoDetalle = document.getElementById('contenidoDetalle');
    const cerrarModalDetalle = document.getElementById('cerrarModal');

    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const idEquipo = this.getAttribute('data-id');
            modalDetalle.classList.remove('hidden');
            contenidoDetalle.innerHTML = '<p>Cargando...</p>';

            fetch(`index.php?c=Equipo&a=detalle&id=${idEquipo}`)
                .then(response => response.text())
                .then(data => {
                    contenidoDetalle.innerHTML = data;
                })
                .catch(() => {
                    contenidoDetalle.innerHTML = '<p>Error al cargar el detalle.</p>';
                });
        });
    });

    cerrarModalDetalle.addEventListener('click', () => {
        modalDetalle.classList.add('hidden');
    });

    modalDetalle.addEventListener('click', (e) => {
        if (e.target === modalDetalle) {
            modalDetalle.classList.add('hidden');
        }
    });

    const modalAgregar = document.getElementById('modalAgregarEquipo');
    const abrirAgregarBtn = document.getElementById('openAgregarEquipoModal');
    const cerrarAgregarBtn = document.getElementById('cerrarAgregarModal');

    abrirAgregarBtn.addEventListener('click', () => {
    modalAgregar.classList.remove('hidden');
    modalAgregar.scrollIntoView({ behavior: "smooth", block: "center" });
});

    cerrarAgregarBtn.addEventListener('click', () => {
        modalAgregar.classList.add('hidden');
    });

    modalAgregar.addEventListener('click', (e) => {
        if (e.target === modalAgregar) {
            modalAgregar.classList.add('hidden');
        }
    });
});
</script>

<?php require 'views/partials/footer.php'; ?>
