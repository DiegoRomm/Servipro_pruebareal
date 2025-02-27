<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Paneeeel Principal</h1>
        <button onclick="openModal()" class="flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2 mr-2">
                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                <path d="M10 6h4"/>
                <path d="M10 10h4"/>
                <path d="M10 14h4"/>
                <path d="M10 18h4"/>
            </svg>
            Agregar Sede
        </button>
    </div>

    <!-- Tarjetas de Sedes -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($sedes as $sede): ?>
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-xl font-bold"><?= $sede['nombre'] ?></h2>
                <p class="text-sm text-gray-500"><?= $sede['direccion'] ?></p>
            </div>
            <div class="p-6 pt-0">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Planos</p>
                        <p class="text-2xl font-bold"><?= $sede['total_planos'] ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Trampas</p>
                        <p class="text-2xl font-bold"><?= $sede['total_trampas'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal Agregar Sede -->
    <div id="modalAgregarSede" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Agregar Nueva Sede</h3>
                    <form action="<?= base_url('sedes/guardar') ?>" method="POST">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre de la Sede</label>
                                <input type="text" name="nombre" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dirección</label>
                                <input type="text" name="direccion" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <input type="text" name="ciudad" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">País</label>
                                <input type="text" name="pais" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                                Guardar Sede
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    <?php if (session()->getFlashdata('message')): ?>
        <div id="alertMessage" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div id="alertMessage" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
</div>

<script>
function openModal() {
    document.getElementById('modalAgregarSede').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalAgregarSede').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalAgregarSede').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Ocultar mensajes de alerta después de 3 segundos
const alertMessage = document.getElementById('alertMessage');
if (alertMessage) {
    setTimeout(() => {
        alertMessage.style.opacity = '0';
        alertMessage.style.transition = 'opacity 0.5s';
        setTimeout(() => alertMessage.remove(), 500);
    }, 3000);
}
</script>
<?= $this->endSection() ?> 

