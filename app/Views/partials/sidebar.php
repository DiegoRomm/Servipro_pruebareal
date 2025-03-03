<!-- Mobile Sidebar Trigger -->
<button class="lg:hidden fixed left-4 top-4 p-2 rounded-lg hover:bg-gray-200">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
        <line x1="4" y1="12" x2="20" y2="12"/>
        <line x1="4" y1="6" x2="20" y2="6"/>
        <line x1="4" y1="18" x2="20" y2="18"/>
    </svg>
</button>

<!-- Mobile Sidebar -->
<div class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40" id="mobile-sidebar-overlay" style="display: none;"></div>
<div class="lg:hidden fixed inset-y-0 left-0 w-64 bg-white z-50 transform -translate-x-full transition-transform duration-300" id="mobile-sidebar">
    <div class="flex h-16 items-center border-b px-12">
        <h2 class="text-lg font-semibold">Control de Plagas</h2>
    </div>
    <div class="overflow-y-auto h-[calc(100vh-4rem)] p-4">
        <nav class="flex flex-col gap-2">
            <a href="<?= site_url('Inicio') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Inicio
            </a>
            <a href="<?= site_url('locations') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2">
                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                    <path d="M10 6h4"/>
                    <path d="M10 10h4"/>
                    <path d="M10 14h4"/>
                    <path d="M10 18h4"/>
                </svg>
                Sedes
            </a>
            <!-- Continuar con los demás elementos del sidebar -->
        </nav>
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="hidden lg:flex w-64 flex-col fixed h-full border-r bg-white transition-transform duration-300 transform translate-x-0">
    <div class="flex h-16 items-center border-b px-12">
        <h2 class="text-lg font-semibold">Control de Plagas</h2>
    </div>
    <div class="overflow-y-auto h-[calc(100vh-4rem)] p-4">
        <nav class="flex flex-col gap-2">
            <a href="<?= site_url('Inicio') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-home">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Inicio
            </a>
            <a href="<?= site_url('locations') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2">
                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                    <path d="M10 6h4"/>
                    <path d="M10 10h4"/>
                    <path d="M10 14h4"/>
                    <path d="M10 18h4"/>
                </svg>
                Sedes
            </a>
            <a href="<?= site_url('blueprints') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map">
                    <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/>
                    <path d="M15 5.764v12.762"/>
                    <path d="M9 3.236v12.762"/>
                </svg>
                Planos
            </a>
            <a href="<?= site_url('incidents') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Incidencias
            </a>
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                        <path d="m7.5 4.27 9 5.15"/>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>
                    Inventario
                </div>
                <div class="flex flex-col pl-4">
                    <a href="<?= site_url('inventory/traps') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mouse-pointer-click">
                            <path d="m9 9 5 12 1.8-5.2L21 14Z"/>
                            <path d="M7.2 2.2 8 5.1"/>
                            <path d="m5.1 8-2.9-.8"/>
                            <path d="M14 7.2l1-3.1"/>
                            <path d="m7.2 14-3.1 1"/>
                        </svg>
                        Trampas
                    </a>
                    <a href="<?= site_url('inventory/supplies') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                            <path d="m7.5 4.27 9 5.15"/>
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                            <path d="m3.3 7 8.7 5 8.7-5"/>
                            <path d="M12 22V12"/>
                        </svg>
                        Consumibles
                    </a>
                </div>
            </div>
            <a href="<?= site_url('staff') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Personal
            </a>
            <a href="<?= site_url('analytics') ?>" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart-3">
                    <path d="M3 3v18h18"/>
                    <path d="M18 17V9"/>
                    <path d="M13 17V5"/>
                    <path d="M8 17v-3"/>
                </svg>
                Dashboard
            </a>
        </nav>
    </div>
</aside> 