<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Control de Plagas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>css/styles.css?v=1.0">
</head>
<body class="bg-gray-100">
    <!-- Botón para toggle del sidebar -->
    <button id="sidebar-toggle" class="fixed top-4 left-6 lg:left-[270px] p-2 bg-white rounded-lg shadow-md hover:bg-gray-100 z-50 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
            <line x1="4" y1="12" x2="20" y2="12"/>
            <line x1="4" y1="6" x2="20" y2="6"/>
            <line x1="4" y1="18" x2="20" y2="18"/>
        </svg>
    </button>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <?= $this->include('partials/sidebar') ?>

        <!-- Contenido principal -->
        <main class="flex-1 p-6 transition-all duration-300" id="main-content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Script para el sidebar móvil
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        const mobileSidebarTrigger = document.querySelector('button[class*="lg:hidden"]');

        mobileSidebarTrigger.addEventListener('click', () => {
            mobileSidebar.style.transform = 'translateX(0)';
            mobileSidebarOverlay.style.display = 'block';
        });

        mobileSidebarOverlay.addEventListener('click', () => {
            mobileSidebar.style.transform = 'translateX(-100%)';
            mobileSidebarOverlay.style.display = 'none';
        });

        const sidebar = document.querySelector('aside');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        let sidebarVisible = true;

        // Función para actualizar el padding del contenido principal
        function updateMainContentPadding() {
            if (window.innerWidth >= 1024) { // lg breakpoint
                mainContent.style.paddingLeft = sidebarVisible ? '288px' : '24px'; // 288px = 72rem (lg:pl-72)
            } else {
                mainContent.style.paddingLeft = '24px'; // 24px = 6 (p-6)
            }
        }

        // Inicializar el padding
        updateMainContentPadding();

        // Actualizar cuando se redimensiona la ventana
        window.addEventListener('resize', updateMainContentPadding);

        sidebarToggle.addEventListener('click', () => {
            sidebarVisible = !sidebarVisible;
            
            if (sidebarVisible) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                sidebarToggle.classList.add('lg:left-[270px]');
                sidebarToggle.classList.remove('left-6');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebarToggle.classList.remove('lg:left-[270px]');
                sidebarToggle.classList.add('left-6');
            }
            updateMainContentPadding();
        });
    </script>
</body>
</html> 