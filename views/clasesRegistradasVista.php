<?php
$baseUrl = "/";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nombreUsuario = isset($_SESSION['usuario']) ? htmlspecialchars($_SESSION['usuario']) : 'Usuario';



$clasesRegistradas = [
    
    ["Química General - Práctica 1", "Mg. Maritza Flores", "18/04/2025", "R202", "#"],
    ["Química Ambiental - Práctica 3", "Ing. Junior Soto", "19/04/2025", "Q106", "#"],
    ["Bioquímica - Práctica 2", "Dra. Ana Paredes", "21/04/2025", "R202", "#"],
    ["Orgánica I - Síntesis", "Dr. Carlos Mendoza", "21/04/2025", "Q106", "#"],
    ["Análisis Instrumental", "Mg. Luisa Torres", "22/04/2025", "R202", "#"],
    ["Fisicoquímica - Lab. Termo", "Ing. Pedro Ramos", "23/04/2025", "Q106", "#"],
];


$errors = [];

?>
<?php
    
    include 'partials/header.php'; 
?>

<p class="text-lg text-gray-700 mb-6">
    Hola <span class="font-semibold"><?php echo $nombreUsuario; ?></span>, estas son las clases que han sido registradas para la semana.
</p>

<h2 class="text-xl font-semibold text-gray-800 mb-4">Clases Registradas</h2>

<div class="overflow-x-auto shadow-md sm:rounded-lg mb-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Titulo de Clase</th>
                <th scope="col" class="px-6 py-3">Nombre Docente</th>
                <th scope="col" class="px-6 py-3">F. Clase</th>
                <th scope="col" class="px-6 py-3">Lab</th>
                <th scope="col" class="px-6 py-3">Descargar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clasesRegistradas as $index => $clase): ?>
                <tr class="border-b hover:bg-gray-100 <?php echo ($index % 2 === 0) ? 'bg-white' : 'bg-pink-50'; ?>"> 
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        <?php echo htmlspecialchars($clase[0]); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($clase[1]); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($clase[2]); ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php echo htmlspecialchars($clase[3]); ?>
                    </td>
                    <td class="px-6 py-4">
                         <a href="<?php echo htmlspecialchars($clase[4]); ?>" class="bg-gray-600 text-white font-semibold text-xs py-1 px-3 rounded hover:bg-gray-700 transition whitespace-nowrap">
                            Descargar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (empty($clasesRegistradas)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No hay clases registradas para esta semana.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
    include 'partials/footer.php';
?>
