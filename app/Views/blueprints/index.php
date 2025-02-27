<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Encabezado -->
    <div>
        <h1 class="text-3xl font-bold">Planos</h1>
        <p class="text-gray-500">Seleccione una sede para ver sus planos</p>
    </div>

    <!-- Selector de Sede -->
    <div class="max-w-xl">
        <select id="sedeSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">-- Seleccione una Sede --</option>
            <?php foreach ($sedes as $sede): ?>
                <option value="<?= $sede['id'] ?>"><?= $sede['nombre'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Estado Inicial / Sin Selección -->
    <div id="estadoInicial" class="flex flex-col items-center justify-center py-12">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Seleccione una Sede</h3>
            <p class="mt-1 text-sm text-gray-500">Elija una sede para ver los planos disponibles</p>
        </div>
    </div>
</div>

<script>
document.getElementById('sedeSelect').addEventListener('change', function() {
    const sedeId = this.value;
    if (sedeId) {
        window.location.href = `<?= base_url('blueprints/view/') ?>/${sedeId}`;
    }
});
</script>
<?= $this->endSection() ?> 