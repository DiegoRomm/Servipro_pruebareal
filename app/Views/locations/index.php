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
            <select class="w-full md:w-64 p-2 border border-gray-300 rounded-lg bg-white">
                <option>Sede Central</option>
                <option>Sede Norte</option>
                <option>Sede Sur</option>
            </select>
            <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Descargar Reporte
            </button>
        </div>
    </div>

    <!-- Tarjetas de métricas -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total Trampas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold">Total Trampas</h3>
            <p class="text-sm text-gray-500">Trampas activas</p>
            <p class="text-4xl font-bold mt-2">24</p>
        </div>

        <!-- Capturas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold">Capturas</h3>
            <p class="text-sm text-gray-500">Este mes</p>
            <p class="text-4xl font-bold mt-2 text-blue-600">18</p>
        </div>

        <!-- Efectividad -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold">Efectividad</h3>
            <p class="text-sm text-gray-500">Promedio</p>
            <p class="text-4xl font-bold mt-2 text-green-600">75%</p>
        </div>

        <!-- Incidencias -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold">Incidencias</h3>
            <p class="text-sm text-gray-500">Este mes</p>
            <p class="text-4xl font-bold mt-2 text-amber-600">5</p>
        </div>
    </div>

    <!-- Gráficos y estadísticas adicionales -->
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Gráfico de Capturas por Mes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Capturas por Mes</h3>
            <div class="h-64 flex items-center justify-center border border-dashed border-gray-300 rounded-lg">
                <p class="text-gray-500">Gráfico de capturas mensuales</p>
            </div>
        </div>

        <!-- Distribución de Trampas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Distribución de Trampas</h3>
            <div class="h-64 flex items-center justify-center border border-dashed border-gray-300 rounded-lg">
                <p class="text-gray-500">Gráfico de distribución</p>
            </div>
        </div>
    </div>

    <!-- Tabla de Incidencias Recientes -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h3 class="text-lg font-semibold">Incidencias Recientes</h3>
            <p class="text-sm text-gray-500">Últimas 5 incidencias reportadas</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">2024-02-20</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Trampa dañada</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Zona A</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">2024-02-19</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Plaga detectada</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">Zona B</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Resuelto</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 