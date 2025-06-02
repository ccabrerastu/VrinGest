
<?php
$baseUrl = "/";

$formData = [
    'nombre_reactivo' => '',
    'formula_quimica' => '',
    'concentracion_pureza' => '',
    'unidad_medida' => '',
    'numero_onu' => '',
    'cantidad' => '',
    'fecha_caducidad' => '',
    'fecha_recepcion' => '',
    'tipo_reactivo' => '',
    'estado_reactivo' => '',
    'ficha_tecnica_ref' => '',
    'ficha_seguridad_ref' => '',
    'norma_nfpa_img' => '',

];
$formErrors = []; 

// Opciones para selects
$unidadesMedida = [
    1 => 'Mililitros (ml)',
    2 => 'Litros (lt)',
    3 => 'Kilogramos (kg)',
    4 => 'Gramos (g)',
    5 => 'Otro'
];

$estadosReactivo = [
    1 => 'Sólido',
    2 => 'Líquido'
];
?>
<?php
    include 'partials/header.php';
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">Agregar Reactivo:</h1>

<form action="<?php echo $baseUrl; ?>index.php?c=Reactivo&a=crearReactivo" method="post" enctype="multipart/form-data" class="space-y-4 max-w-2xl">

    <div>
        <label for="nombre_reactivo" class="block mb-1 font-semibold text-gray-700">Nombre del Reactivo:</label>
        <input type="text" name="nombre_reactivo" id="nombre_reactivo" value="<?php echo htmlspecialchars($formData['nombre_reactivo']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['nombre_reactivo']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['nombre_reactivo'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['nombre_reactivo']; ?></p><?php endif; ?>
        </div>
    
    <div>
        <label for="formula_quimica" class="block mb-1 font-semibold text-gray-700">Formula Química:</label>
        <input type="text" name="formula_quimica" id="formula_quimica" value="<?php echo htmlspecialchars($formData['formula_quimica']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['formula_quimica']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['formula_quimica'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['formula_quimica']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="concentracion_pureza" class="block mb-1 font-semibold text-gray-700">Concentración:</label>
        <input type="text" name="concentracion_pureza" id="concentracion_pureza" value="<?php echo htmlspecialchars($formData['concentracion_pureza']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['concentracion_pureza']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['concentracion_pureza'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['concentracion_pureza']; ?></p><?php endif; ?>
    </div>
    <div>
        <label for="unidad_medida" class="block mb-1 font-semibold text-gray-700">Unidad de Medida:</label>
        <select name="unidad_medida" id="unidad_medida" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white <?php echo isset($formErrors['unidad_medida']) ? 'border-red-500' : ''; ?>" required>
            <option value="" disabled <?php echo empty($formData['unidad_medida']) ? 'selected' : ''; ?>>Seleccione una unidad...</option>
            <?php foreach ($unidadesMedida as $key => $label): ?>
                <option value="<?php echo $key; ?>" <?php echo ($formData['unidad_medida'] == $key) ? 'selected' : ''; ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($formErrors['unidad_medida'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['unidad_medida']; ?></p><?php endif; ?>
    </div>
    <div>
        <label for="numero_onu" class="block mb-1 font-semibold text-gray-700">Número ONU:</label>
        <input type="text" name="numero_onu" id="numero_onu" value="<?php echo htmlspecialchars($formData['numero_onu']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['numero_onu']) ? 'border-red-500' : ''; ?>">
        <?php if (isset($formErrors['numero_onu'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['numero_onu']; ?></p><?php endif; ?>
    </div>
        <div>
        <label for="cantidad" class="block mb-1 font-semibold text-gray-700">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($formData['cantidad']); ?>" step="any" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['cantidad']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['cantidad'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['cantidad']; ?></p><?php endif; ?>
    </div>
    <div>
        <label for="fecha_caducidad" class="block mb-1 font-semibold text-gray-700">Fecha de Caducidad:</label>
        <input type="date" name="fecha_caducidad" id="fecha_caducidad" value="<?php echo htmlspecialchars($formData['fecha_caducidad']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['fecha_caducidad']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['fecha_caducidad'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['fecha_caducidad']; ?></p><?php endif; ?>
    </div>
    <div>
        <label for="fecha_recepcion" class="block mb-1 font-semibold text-gray-700">Fecha de Recepcion:</label>
        <input type="date" name="fecha_recepcion" id="fecha_recepcion" value="<?php echo htmlspecialchars($formData['fecha_recepcion']); ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['fecha_recepcion']) ? 'border-red-500' : ''; ?>" required>
        <?php if (isset($formErrors['fecha_recepcion'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['fecha_recepcion']; ?></p><?php endif; ?>
    </div>
    <div>
        <label for="tipo_reactivo" class="block mb-1 font-semibold text-gray-700">Tipo de Reactivo:</label>
        <select name="tipo_reactivo" id="tipo_reactivo" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white <?php echo isset($formErrors['tipo_reactivo']) ? 'border-red-500' : ''; ?>" required>
            <option value="" disabled <?php echo empty($formData['tipo_reactivo']) ? 'selected' : ''; ?>>Seleccione un tipo...</option>
            <option value="1" <?php echo ($formData['tipo_reactivo'] === '1') ? 'selected' : ''; ?>>Fiscalizado</option>
            <option value="0" <?php echo ($formData['tipo_reactivo'] === '0') ? 'selected' : ''; ?>>No Fiscalizado</option>
        </select>
        <?php if (isset($formErrors['tipo_reactivo'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['tipo_reactivo']; ?></p><?php endif; ?>
    </div>
    <div>
    <label for="estado_reactivo" class="block mb-1 font-semibold text-gray-700">Estado del Reactivo:</label>
    <select name="estado_reactivo" id="estado_reactivo" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white <?php echo isset($formErrors['estado_reactivo']) ? 'border-red-500' : ''; ?>" required>
        <option value="" disabled <?php echo empty($formData['estado_reactivo']) ? 'selected' : ''; ?>>Seleccione estado...</option>
        <?php foreach ($estadosReactivo as $id => $label): ?>
            <option value="<?php echo $id; ?>" <?php echo ($formData['estado_reactivo'] == $id) ? 'selected' : ''; ?>><?php echo $label; ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($formErrors['estado_reactivo'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['estado_reactivo']; ?></p><?php endif; ?>
</div>
<div>
        <label for="ficha_tecnica_ref" class="block mb-1 font-semibold text-gray-700">Ficha Técnica:</label>
        <div class="flex items-center space-x-2">
            <input type="text" name="ficha_tecnica_ref" id="ficha_tecnica_ref" value="<?php echo htmlspecialchars($formData['ficha_tecnica_ref']); ?>" placeholder="URL o identificador" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['ficha_tecnica_ref']) ? 'border-red-500' : ''; ?>">
            <button type="button" id="btnBuscarFicha" class="bg-blue-600 text-white font-semibold py-1 px-4 rounded hover:bg-blue-700 transition">
                Cargar
            </button>
        </div>
        <?php if (isset($formErrors['ficha_tecnica_ref'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['ficha_tecnica_ref']; ?></p><?php endif; ?>
    </div>

    <div>
        <label for="ficha_seguridad_ref" class="block mb-1 font-semibold text-gray-700">Ficha de Seguridad:</label>
        <div class="flex items-center space-x-2">
            <input type="text" name="ficha_seguridad_ref" id="ficha_seguridad_ref" value="<?php echo htmlspecialchars($formData['ficha_seguridad_ref']); ?>" placeholder="URL o identificador" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['ficha_seguridad_ref']) ? 'border-red-500' : ''; ?>">
            <button type="button" id="btnBuscarFichaSeguridad" class="bg-blue-600 text-white font-semibold py-1 px-4 rounded hover:bg-blue-700 transition">
                Cargar
            </button>
        </div>
        <?php if (isset($formErrors['ficha_seguridad_ref'])): ?><p class="text-red-500 text-xs mt-1"><?php echo $formErrors['ficha_seguridad_ref']; ?></p><?php endif; ?>
    </div>


<div>
    <label for="norma_nfpa_img" class="block mb-1 font-semibold text-gray-700">Imagen Norma NFPA:</label>
    
    <input type="file" name="norma_nfpa_img" id="norma_nfpa_img" accept="image/*" 
           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 <?php echo isset($formErrors['norma_nfpa_img']) ? 'border-red-500' : ''; ?>" required>
    
    <input type="hidden" name="norma_nfpa" id="norma_nfpa" value="">
    
    <?php if (isset($formErrors['norma_nfpa_img'])): ?>
        <p class="text-red-500 text-xs mt-1"><?php echo $formErrors['norma_nfpa_img']; ?></p>
    <?php endif; ?>
    
    <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB</p>
</div>

    <div class="pt-4">
        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded hover:bg-blue-700 transition">
            Agregar Reactivo
        </button>
    </div>

</form>
<div id="modalCarrusel" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-11/12 md:w-2/3 p-4 rounded-lg shadow-lg relative">
        <button id="cerrarModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✖</button>
        <div id="contenedorCarrusel" class="flex flex-col items-center gap-4">
        </div>
        <div class="flex justify-center items-center gap-4 mt-4">
            <button id="prevFicha" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Anterior</button>
            <button id="seleccionarFicha" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Seleccionar esta Ficha</button>
            <button id="nextFicha" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Siguiente</button>
        </div>
    </div>
</div>
<div id="modalCarrusel2" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-11/12 md:w-2/3 p-4 rounded-lg shadow-lg relative">
        <button id="cerrarModalSeguridad" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">✖</button>
        <div id="contenedorCarrusel2" class="flex flex-col items-center gap-4">
        </div>
        <div class="flex justify-center items-center gap-4 mt-4">
            <button id="prevFichaSeguridad" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Anterior</button>
            <button id="seleccionarFichaSeguridad" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Seleccionar</button>
            <button id="nextFichaSeguridad" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Siguiente</button>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
<script>


document.getElementById('btnBuscarFicha').addEventListener('click', async () => {
    const nombre = document.getElementById('nombre_reactivo').value;
    if (!nombre.trim()) {
        alert("Por favor, ingrese el nombre del reactivo.");
        return;
    }

    const modal = document.getElementById('modalCarrusel');
    const contenedorPDF = document.getElementById('contenedorCarrusel');
    const urlInput = document.getElementById('ficha_tecnica_ref');

    modal.classList.remove('hidden');
    contenedorPDF.innerHTML = '<div class="text-center py-10 text-gray-700">Buscando fichas técnicas...</div>';

    try {
        const apiUrl = `http://161.132.39.165:5000/buscar_ficha?nombre=${encodeURIComponent(nombre)}`;
        let response = await fetchWithFallbacks(apiUrl);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();

        if (!data.resultados || data.resultados.length === 0) {
            contenedorPDF.innerHTML = '<div class="text-center text-gray-600 py-10">No se encontraron fichas técnicas.</div>';
            return;
        }

        await mostrarResultadosPDF(data.resultados, contenedorPDF, urlInput, modal);

    } catch (error) {
        console.error('Error completo:', error);
        mostrarError(contenedorPDF, error);
    }
});

async function fetchWithFallbacks(url) {
    try {
        const response = await fetch(url, {
            method: 'GET',
            mode: 'cors',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }
        });
        if (response.ok) return response;
    } catch (e) { console.log("Estrategia 1 falló:", e); }

    try {
        const proxyUrl = `https://api.allorigins.win/get?url=${encodeURIComponent(url)}`;
        const response = await fetch(proxyUrl);
        if (response.ok) {
            const data = await response.json();
            return new Response(data.contents, {
                status: 200,
                headers: { 'Content-Type': 'application/json' }
            });
        }
    } catch (e) { console.log("Estrategia 2 falló:", e); }

    throw new Error("Todas las estrategias de conexión fallaron");
}

async function mostrarResultadosPDF(pdfUrls, contenedor, urlInput, modal) {
    let currentIndex = 0;

    const mostrarPDF = async () => {
        const pdfUrl = pdfUrls[currentIndex];
        try {
            contenedor.innerHTML = `
                <canvas id="pdf-canvas" class="mx-auto my-4 border rounded"></canvas>
                <div class="text-center text-sm text-gray-600">Documento ${currentIndex + 1} de ${pdfUrls.length}</div>
            `;
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            const pdf = await loadingTask.promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 1.0 });
            const canvas = document.getElementById('pdf-canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            await page.render({ canvasContext: context, viewport: viewport }).promise;
        } catch (e) {
            console.log("PDF.js falló, usando Google Viewer:", e);
            contenedor.innerHTML = `
                <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(pdfUrl)}&embedded=true"
                        class="w-full h-[400px] border rounded"
                        frameborder="0"></iframe>
                <div class="text-center text-sm text-gray-600 mt-2">Documento ${currentIndex + 1} de ${pdfUrls.length}</div>
            `;
        }
    };

    await mostrarPDF();

    document.getElementById('prevFicha').onclick = async () => {
        currentIndex = (currentIndex - 1 + pdfUrls.length) % pdfUrls.length;
        await mostrarPDF();
    };

    document.getElementById('nextFicha').onclick = async () => {
        currentIndex = (currentIndex + 1) % pdfUrls.length;
        await mostrarPDF();
    };

    document.getElementById('seleccionarFicha').onclick = () => {
        urlInput.value = pdfUrls[currentIndex];
        modal.classList.add('hidden');
    };
}

function mostrarError(contenedor, error) {
    contenedor.innerHTML = `
        <div class="flex flex-col items-center justify-center p-4 text-center text-red-600">
            <div class="font-semibold">Error al cargar las fichas técnicas</div>
            <div class="text-sm mt-1">${error.message}</div>
            <div class="mt-3 text-gray-600 text-sm">
                <p>Detalles:</p>
                <ul class="list-disc pl-5 text-left mt-2">
                    <li>URL de API: http://161.132.39.165:5000/</li>
                    <li>Tipo de error: ${error.name}</li>
                </ul>
            </div>
            <div class="mt-4 flex gap-2">
                <button onclick="location.reload()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Recargar</button>
                <button onclick="testAPI()" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Probar API</button>
            </div>
        </div>
    `;
}

window.testAPI = async function () {
    try {
        const testUrl = 'http://161.132.39.165:5000/buscar_ficha?nombre=test';
        const response = await fetch(testUrl, { mode: 'no-cors' });
        alert(`Estado de la API: ${response.ok ? 'OK' : 'Error'}\nVer consola para más info.`);
        console.log("Prueba de API:", response);
    } catch (error) {
        alert(`Error probando la API: ${error.message}`);
        console.error("Error en prueba de API:", error);
    }
};

document.getElementById('cerrarModal').addEventListener('click', () => {
    document.getElementById('modalCarrusel').classList.add('hidden');
});
</script>




<script>
document.getElementById('btnBuscarFichaSeguridad').addEventListener('click', async () => {
    const nombre = document.getElementById('nombre_reactivo').value;
    if (!nombre.trim()) {
        alert("Por favor, ingrese el nombre del reactivo.");
        return;
    }

    const modal2 = document.getElementById('modalCarrusel2');
    const contenedor2 = document.getElementById('contenedorCarrusel2');
    const urlInput2 = document.getElementById('ficha_seguridad_ref');

    modal2.classList.remove('hidden');
    contenedor2.innerHTML = '<div class="text-center py-10 text-gray-700">Buscando fichas de seguridad...</div>';

    try {
        const apiUrl = `http://161.132.39.165:5050/buscar_ficha_seguridad?nombre=${encodeURIComponent(nombre)}`;
        let response = await fetchWithFallbacks(apiUrl);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();

        if (!data.resultados || data.resultados.length === 0) {
            contenedor2.innerHTML = '<div class="text-center text-gray-600 py-10">No se encontraron fichas de seguridad.</div>';
            return;
        }

        await mostrarResultadosSeguridadPDF(data.resultados, contenedor2, urlInput2, modal2);

    } catch (error) {
        console.error('Error completo:', error);
        mostrarError(contenedor2, error);
    }
});

async function mostrarResultadosSeguridadPDF(pdfUrls, contenedor, urlInput, modal) {
    let currentIndex = 0;

    const mostrarPDF = async () => {
        const pdfUrl = pdfUrls[currentIndex];
        try {
            contenedor.innerHTML = `
                <canvas id="pdf-canvas2" class="mx-auto my-4 border rounded"></canvas>
                <div class="text-center text-sm text-gray-600">Documento ${currentIndex + 1} de ${pdfUrls.length}</div>
            `;
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            const pdf = await loadingTask.promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 1.0 });
            const canvas = document.getElementById('pdf-canvas2');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            await page.render({ canvasContext: context, viewport: viewport }).promise;
        } catch (e) {
            console.log("PDF.js falló, usando Google Viewer:", e);
            contenedor.innerHTML = `
                <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(pdfUrl)}&embedded=true"
                        class="w-full h-[400px] border rounded"
                        frameborder="0"></iframe>
                <div class="text-center text-sm text-gray-600 mt-2">Documento ${currentIndex + 1} de ${pdfUrls.length}</div>
            `;
        }
    };

    await mostrarPDF();

    document.getElementById('prevFichaSeguridad').onclick = async () => {
        currentIndex = (currentIndex - 1 + pdfUrls.length) % pdfUrls.length;
        await mostrarPDF();
    };

    document.getElementById('nextFichaSeguridad').onclick = async () => {
        currentIndex = (currentIndex + 1) % pdfUrls.length;
        await mostrarPDF();
    };

    document.getElementById('seleccionarFichaSeguridad').onclick = () => {
        urlInput.value = pdfUrls[currentIndex];
        modal.classList.add('hidden');
    };
}

document.getElementById('cerrarModalSeguridad').addEventListener('click', () => {
    document.getElementById('modalCarrusel2').classList.add('hidden');
});
</script>
<?php
    include 'partials/footer.php';
?>