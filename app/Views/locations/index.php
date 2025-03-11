<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Encabezado con selector y botón de reporte -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Dashboard de Sedes</h1>
            <p class="text-gray-500">Análisis y métricas detalladas por sede</p>
        </div>
        <div class="flex flex-col md:flex-row gap-3">
            <select id="sede-selector" class="w-full md:w-64 p-2 border border-gray-300 rounded-lg bg-white" onchange="cambiarSede(this.value)">
                <?php if(empty($sedes)): ?>
                    <option>No hay sedes disponibles</option>
                <?php else: ?>
                    <option value="">Seleccione una sede</option>
                    <?php foreach($sedes as $sede): ?>
                        <option value="<?= $sede['id'] ?>" <?= ($sedeSeleccionada == $sede['id']) ? 'selected' : '' ?>><?= esc($sede['nombre']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <button onclick="descargarPDF()" class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
        <polyline points="7 10 12 15 17 10"/>
        <line x1="12" y1="15" x2="12" y2="3"/>
    </svg>
    Descargar Reporte (PDF)
</button>


        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold">Total de Trampas en la Sede</h3>
    <p class="text-sm text-gray-500">Número total: <span class="text-xl font-bold"><?= $totalTrampasSede; ?></span></p>

    <table class="min-w-full bg-white border border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Nombre</th>
                <th class="py-2 px-4 border">Tipo de Trampa</th>
                <th class="py-2 px-4 border">Ubicación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trampasDetalle as $trampa): ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border"><?= $trampa['id']; ?></td>
                    <td class="py-2 px-4 border"><?= $trampa['nombre']; ?></td>
                    <td class="py-2 px-4 border"><?= $trampa['tipo']; ?></td>
                    <td class="py-2 px-4 border"><?= $trampa['ubicacion']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

       

        <!-- Efectividad -->
  

        <!-- Incidencias -->
        <div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold">Total de Incidencias en la Sede</h3>
    <p class="text-sm text-gray-500">Número total de incidencias registradas</p>

    <!-- Mostrar el total de incidencias en grande -->
    <p class="text-4xl font-bold mt-2 text-blue-600">
        <?php 
            $sumaTotal = array_sum(array_column($totalIncidenciasPorTipo, 'total'));
            echo $sumaTotal;
        ?>
    </p>
</div>

<!-- Tabla de incidencias por tipo y plaga -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mt-6">Total de Incidencias por Tipo</h3>
    <p class="text-sm text-gray-500">Incidencias agrupadas por tipo y plaga</p>

    <table class="min-w-full bg-white border border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-2 px-4 border">Tipo de Incidencia</th>
                <th class="py-2 px-4 border">Tipo de Plaga</th>
                <th class="py-2 px-4 border">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totalIncidenciasPorTipo as $incidencia): ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border"><?= htmlspecialchars($incidencia['tipo_incidencia']); ?></td>
                    <td class="py-2 px-4 border"><?= htmlspecialchars($incidencia['tipo_plaga']); ?></td>
                    <td class="py-2 px-4 border font-bold"><?= htmlspecialchars($incidencia['total']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4">Incidencias por Tipo y Mes</h3>
    <div style="width: 100%; height: 400px;">
        <canvas id="incidenciasTipoChart"></canvas>
    </div>
</div>

<!-- Cargar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener datos de PHP
        const incidenciasPorTipoIncidencia = <?= json_encode($incidenciasPorTipoIncidencia ?? []); ?>;

        let incidenciasMap = {};
        let mesesSet = new Set();

        // Procesar los datos para agrupar por tipo de incidencia y mes
        incidenciasPorTipoIncidencia.forEach(item => {
            let mes = item.mes;
            let tipo = item.tipo_incidencia || "Desconocido";
            let total = parseInt(item.total, 10) || 0;

            if (!incidenciasMap[tipo]) {
                incidenciasMap[tipo] = {};
            }
            incidenciasMap[tipo][mes] = total;
            mesesSet.add(mes);
        });

        // Convertir meses en array ordenado
        let mesesOrdenados = Array.from(mesesSet).sort();

        // Crear datasets por tipo de incidencia
        let datasets = Object.keys(incidenciasMap).map(tipo => {
            return {
                label: tipo,
                data: mesesOrdenados.map(mes => incidenciasMap[tipo][mes] || 0),
                borderWidth: 1,
                backgroundColor: getRandomColor()
            };
        });

        // Verificar si el canvas existe antes de crear el gráfico
        const canvas = document.getElementById('incidenciasTipoChart');
        if (!canvas) {
            console.error("Error: No se encontró el canvas 'incidenciasTipoChart'");
            return;
        }

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: mesesOrdenados,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { title: { display: true, text: 'Mes' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Número de Incidencias' } }
                }
            }
        });

        // Función para generar colores aleatorios
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`;
        }
    });
</script>


        <!-- Distribución de Trampas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Distribución de Trampas por Ubicación</h3>
            <div style="width: 100%; height: 400px;">
                <canvas id="trampasPorUbicacionChart"></canvas>
            </div>
        </div>
    </div>

<script>
function cambiarSede(sedeId) {
    if (sedeId) {
        window.location.href = '<?= base_url('locations') ?>?sede_id=' + sedeId;
    }
}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener datos de PHP para trampas por ubicación
        const trampasPorUbicacion = <?= json_encode($trampasPorUbicacion ?? []); ?>;

        // Preparar datos para el gráfico
        const ubicaciones = trampasPorUbicacion.map(item => item.ubicacion);
        const totales = trampasPorUbicacion.map(item => parseInt(item.total));

        // Verificar si el canvas existe antes de crear el gráfico
        const canvas = document.getElementById('trampasPorUbicacionChart');
        if (!canvas) {
            console.error("Error: No se encontró el canvas 'trampasPorUbicacionChart'");
            return;
        }

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ubicaciones,
                datasets: [{
                    label: 'Número de Trampas',
                    data: totales,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Distribución de Trampas por Ubicación'
                    }
                },
                scales: {
                    x: { 
                        title: { 
                            display: true, 
                            text: 'Ubicación' 
                        }
                    },
                    y: { 
                        beginAtZero: true, 
                        title: { 
                            display: true, 
                            text: 'Número de Trampas' 
                        }
                    }
                }
            }
        });
    });
</script>

<div class="grid gap-6 md:grid-cols-2">
    <!-- Gráfico de Incidencias por Tipo de Plaga y Mes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Incidencias por Tipo de Plaga y Mes</h3>
        <div style="width: 100%; height: 400px;">
            <canvas id="incidenciasPlagaChart"></canvas>
        </div>
    </div>
</div>

<!-- Cargar Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener datos de PHP
        const incidenciasPorTipoPlaga = <?= json_encode($incidenciasPorTipoPlaga ?? []); ?>;

        let incidenciasMap = {};
        let mesesSet = new Set();

        // Procesar los datos para agrupar por tipo de plaga y mes
        incidenciasPorTipoPlaga.forEach(item => {
            let mes = item.mes;
            let plaga = item.tipo_plaga || "Desconocida";
            let total = parseInt(item.total, 10) || 0;

            if (!incidenciasMap[plaga]) {
                incidenciasMap[plaga] = {};
            }
            incidenciasMap[plaga][mes] = total;
            mesesSet.add(mes);
        });

        // Convertir meses en array ordenado
        let mesesOrdenados = Array.from(mesesSet).sort();

        // Crear datasets por tipo de plaga
        let datasets = Object.keys(incidenciasMap).map(plaga => {
            return {
                label: plaga,
                data: mesesOrdenados.map(mes => incidenciasMap[plaga][mes] || 0),
                borderWidth: 1,
                backgroundColor: getRandomColor()
            };
        });

        // Verificar si el canvas existe antes de crear el gráfico
        const canvas = document.getElementById('incidenciasPlagaChart');
        if (!canvas) {
            console.error("Error: No se encontró el canvas 'incidenciasPlagaChart'");
            return;
        }

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: mesesOrdenados,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    x: { title: { display: true, text: 'Mes' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Número de Incidencias' } }
                }
            }
        });

        // Función para generar colores aleatorios
        function getRandomColor() {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`;
        }
    });
</script>
<!-- Cargar bibliotecas necesarias -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
async function descargarPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4'); // PDF en formato A4 vertical

    // Obtener el nombre de la sede desde PHP
    const nombreSede = "<?= esc($sedeSeleccionadaNombre ?? 'Sede Desconocida'); ?>";

    // Agregar título en la primera página
    pdf.setFontSize(18);
    pdf.text(`Reporte General de Sede: ${nombreSede}`, 10, 15);

    let yOffset = 30; // Posición inicial en la primera hoja

    // Función para agregar nueva página cuando se necesite
    function agregarNuevaPagina() {
        pdf.addPage();
        yOffset = 20; // Reiniciar el margen en la nueva página
    }

    // Capturar y agregar todas las tablas al PDF
    const tablas = document.querySelectorAll("table");
    for (let tabla of tablas) {
        const canvas = await html2canvas(tabla, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");
        const imgWidth = 180;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        // Agregar una nueva página si la tabla no cabe en la actual
        if (yOffset + imgHeight > 270) {
            agregarNuevaPagina();
        }

        pdf.addImage(imgData, 'PNG', 10, yOffset, imgWidth, imgHeight);
        yOffset += imgHeight + 10;
    }

    // Capturar y agregar todas las gráficas al PDF
    const graficos = document.querySelectorAll("canvas");
    for (let grafico of graficos) {
        const canvas = await html2canvas(grafico, { scale: 2 });
        const imgData = canvas.toDataURL("image/png");
        const imgWidth = 180;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        // Agregar una nueva página si la gráfica no cabe en la actual
        if (yOffset + imgHeight > 270) {
            agregarNuevaPagina();
        }

        pdf.addImage(imgData, 'PNG', 10, yOffset, imgWidth, imgHeight);
        yOffset += imgHeight + 10;
    }

    // Guardar el PDF con un nombre basado en la sede
    pdf.save(`Reporte_General_${nombreSede.replace(/ /g, "_")}.pdf`);
}
</script>





</script>




<?= $this->endSection() ?> 