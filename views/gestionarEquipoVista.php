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

<?php require 'views/partials/footer.php'; ?>
