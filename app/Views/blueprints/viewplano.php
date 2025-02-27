<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Agregar en el head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .trap-marker {
        cursor: pointer;
        padding: 5px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        z-index: 10;
    }

    .zona {
        position: absolute;
        border: 2px dashed #666;
        background: rgba(100, 100, 100, 0.1);
        cursor: move;
    }

    .zona-circulo {
        border-radius: 50%;
    }

    .resize-handle {
        position: absolute;
        width: 10px;
        height: 10px;
        background: white;
        border: 1px solid #666;
        cursor: se-resize;
    }

    @keyframes highlight {
        0% { background-color: rgba(255, 255, 0, 0.5); }
        100% { background-color: transparent; }
    }
</style>

<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Sistema de Mapeo de Trampas</h1>
            <p class="text-gray-500"><?= $plano['nombre'] ?> - <?= $sede['nombre'] ?></p>
        </div>
        <div class="flex gap-3">
            <button id="btnSeleccionarImagen" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Seleccionar Imagen
            </button>
            <button id="btnGuardar" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save"></i>
                Guardar Estado
            </button>
            <button id="btnCargar" class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <i class="fas fa-upload"></i>
                Cargar Estado
            </button>
            <button id="btnLimpiar" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                <i class="fas fa-trash-alt"></i>
                Limpiar Todo
            </button>
        </div>
    </div>

    <!-- Área del Plano -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Plano -->
        <div class="lg:col-span-3 bg-white rounded-lg shadow-md p-4">
            <div id="planoContainer" class="w-full h-[600px] bg-gray-100 rounded-lg flex items-center justify-center relative">
                <img id="planoImage" class="max-w-full max-h-full hidden" style="object-fit: contain;" />
                <p id="placeholderText" class="text-gray-500">Seleccione una imagen para comenzar</p>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Herramientas -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="font-semibold mb-4">Herramientas</h3>
                <div class="space-y-2">
                    <!-- Dropdown Agregar Trampa -->
                    <div class="dropdown">
                        <button id="btnAgregarTrampa" class="w-full flex items-center justify-between px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <span class="flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Agregar Trampa
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="trap-menu hidden mt-2 w-full bg-white border rounded-lg shadow-lg">
                            <a href="#" class="dropdown-item block px-4 py-2 hover:bg-gray-100" data-trap-type="rodent">
                                <i class="fas fa-mouse mr-2"></i> Trampa para Roedores
                            </a>
                            <a href="#" class="dropdown-item block px-4 py-2 hover:bg-gray-100" data-trap-type="insect">
                                <i class="fas fa-bug mr-2"></i> Trampa para Insectos
                            </a>
                            <a href="#" class="dropdown-item block px-4 py-2 hover:bg-gray-100" data-trap-type="fly">
                                <i class="fas fa-fly mr-2"></i> Trampa para Moscas
                            </a>
                        </div>
                    </div>

                    <!-- Botón Mover Trampas -->
                    <button id="btnMoverTrampa" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        <i class="fas fa-arrows-alt mr-2"></i>
                        Mover Trampas
                    </button>

                    <!-- Botón Agregar Zona -->
                    <button id="btnAgregarZona" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-draw-polygon mr-2"></i>
                        Agregar Zona
                    </button>
                </div>
            </div>

            <!-- Lista de Trampas -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="font-semibold mb-4">Lista de Trampas</h3>
                <div class="overflow-y-auto max-h-[400px]">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Tipo</th>
                                <th class="px-4 py-2 text-left">Ubicación</th>
                                <th class="px-4 py-2 text-left">Zona</th>
                                <th class="px-4 py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="trampasTableBody">
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                                    No hay trampas registradas
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agregar los inputs ocultos -->
<input type="file" id="planoInput" class="form-control" accept="image/*" style="display: none;">
<input type="file" id="cargarEstadoInput" accept="application/json" style="display: none;">

<!-- Scripts -->
<script src="<?= base_url('js/mapa.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias a elementos
        const planoContainer = document.getElementById('planoContainer');
        const planoImage = document.getElementById('planoImage');
        const planoInput = document.getElementById('planoInput');
        const btnSeleccionarImagen = document.getElementById('btnSeleccionarImagen');
        const btnGuardar = document.getElementById('btnGuardar');
        const btnCargar = document.getElementById('btnCargar');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const btnMoverTrampa = document.getElementById('btnMoverTrampa');
        const btnAgregarZona = document.getElementById('btnAgregarZona');
        const btnAgregarTrampa = document.getElementById('btnAgregarTrampa');
        const dropdownTrampa = document.querySelector('.dropdown');
        const cargarEstadoInput = document.getElementById('cargarEstadoInput');

        // Variables para el manejo de trampas
        let modoEdicion = null;
        let tipoTrampaSeleccionado = null;
        let contadorTrampas = 1;
        let trampaSeleccionada = null;
        let offsetX = 0;
        let offsetY = 0;

        // Agregar estas variables al inicio del script
        let dibujandoPoligono = false;
        let puntosPoligono = [];
        let poligonoTemporal = null;
        let tooltipElement = null;
        let confirmButton = null;

        // Función para desactivar todos los botones excepto Seleccionar Imagen y Cargar
        function desactivarBotones() {
            btnGuardar.disabled = true;
            btnLimpiar.disabled = true;
            btnMoverTrampa.disabled = true;
            btnAgregarZona.disabled = true;
            btnAgregarTrampa.disabled = true;
            
            // Agregar clase para estilo desactivado
            [btnGuardar, btnLimpiar, btnMoverTrampa, btnAgregarZona, btnAgregarTrampa].forEach(btn => {
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            });
        }

        // Función para activar todos los botones
        function activarBotones() {
            btnGuardar.disabled = false;
            btnLimpiar.disabled = false;
            btnMoverTrampa.disabled = false;
            btnAgregarZona.disabled = false;
            btnAgregarTrampa.disabled = false;
            
            // Remover clase para estilo desactivado
            [btnGuardar, btnLimpiar, btnMoverTrampa, btnAgregarZona, btnAgregarTrampa].forEach(btn => {
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }

        // Desactivar botones al inicio
        desactivarBotones();

        // Botón Seleccionar Imagen
        btnSeleccionarImagen.addEventListener('click', () => {
            planoInput.click();
        });

        planoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    planoImage.src = e.target.result;
                    planoImage.style.display = 'block';
                    document.getElementById('placeholderText').style.display = 'none';
                    // Activar botones cuando se carga la imagen
                    activarBotones();
                };
                reader.readAsDataURL(file);
            }
        });

        // Botón Guardar Estado
        btnGuardar.addEventListener('click', () => {
            const estado = {
                imagen: planoImage.src,
                trampas: window.puntos || [],
                zonas: window.zonas || []
            };
            const blob = new Blob([JSON.stringify(estado)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'estado-plano.json';
            a.click();
        });

        // Función para limpiar completamente el estado
        function limpiarEstadoCompleto() {
            // Limpiar imagen
            if (planoImage) {
                planoImage.src = '';
                planoImage.style.display = 'none';
            }

            const placeholderText = document.getElementById('placeholderText');
            if (placeholderText) {
                placeholderText.style.display = 'block';
            }
            
            // Limpiar inputs
            if (planoInput) planoInput.value = '';
            if (cargarEstadoInput) cargarEstadoInput.value = '';
            
            // Limpiar arrays
            window.puntos = [];
            window.zonas = [];
            
            // Limpiar marcadores y zonas del DOM
            if (planoContainer) {
                const marcasExistentes = planoContainer.querySelectorAll('.trap-marker, .zona');
                marcasExistentes.forEach(marca => marca.remove());
            }
            
            // Limpiar tabla
            if (typeof actualizarTablaTrampas === 'function') {
                actualizarTablaTrampas();
            }
            
            // Resetear modos de edición
            if (planoContainer) {
                planoContainer.dataset.modoEdicion = '';
                planoContainer.dataset.tipoTrampa = '';
            }
            
            // Resetear clases activas de botones
            if (btnMoverTrampa) {
                btnMoverTrampa.classList.remove('active', 'bg-green-600', 'hover:bg-green-700');
                btnMoverTrampa.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
                btnMoverTrampa.innerHTML = `
                    <i class="fas fa-arrows-alt mr-2"></i>
                    Mover Trampas
                `;
            }

            // Verificar que el dropdown y su menú existan antes de manipularlos
            const trapMenu = dropdownTrampa?.querySelector('.trap-menu');
            if (trapMenu) {
                trapMenu.classList.add('hidden');
            }

            // Desactivar botones después de limpiar
            desactivarBotones();
        }

        // Botón Limpiar Todo
        btnLimpiar.addEventListener('click', () => {
            if (confirm('¿Está seguro de que desea limpiar todo?')) {
                limpiarEstadoCompleto();
            }
        });

        // Botón Cargar Estado
        btnCargar.addEventListener('click', () => {
            cargarEstadoInput.click();
        });

        // Agregar esta función antes del evento DOMContentLoaded
        function marcarTrampa(punto) {
            const planoContainer = document.getElementById('planoContainer');
            const planoImage = document.getElementById('planoImage');
            
            // Obtener las dimensiones actuales
            const imagenRect = planoImage.getBoundingClientRect();
            const containerRect = planoContainer.getBoundingClientRect();

            // Crear el marcador visual
            const marcador = document.createElement('div');
            marcador.className = 'trap-marker';
            marcador.style.position = 'absolute';
            
            // Calcular la posición relativa al contenedor
            const imagenLeft = imagenRect.left - containerRect.left;
            const imagenTop = imagenRect.top - containerRect.top;
            
            // Posicionar el marcador
            marcador.style.left = `${imagenLeft + punto.x}px`;
            marcador.style.top = `${imagenTop + punto.y}px`;
            marcador.style.transform = 'translate(-50%, -50%)';
            marcador.dataset.index = window.puntos.indexOf(punto);

            // Agregar icono según el tipo
            const icon = document.createElement('i');
            switch (punto.tipo) {
                case 'rodent':
                    icon.className = 'fas fa-mouse';
                    break;
                case 'insect':
                    icon.className = 'fas fa-bug';
                    break;
                case 'fly':
                    icon.className = 'fas fa-fly';
                    break;
                case 'moth':
                    icon.className = 'fas fa-moth';
                    break;
            }
            marcador.appendChild(icon);

            // Agregar tooltip con información
            marcador.title = `${getTipoTrampa(punto.tipo)} - ${punto.id}`;

            // Agregar evento para eliminar
            marcador.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (confirm('¿Desea eliminar esta trampa?')) {
                    const index = parseInt(this.dataset.index);
                    window.puntos.splice(index, 1);
                    this.remove();
                    reindexarTrampas();
                    actualizarTablaTrampas();
                }
            });

            // Agregar evento de clic al marcador
            marcador.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remover resaltado de todas las trampas
                document.querySelectorAll('.trap-marker').forEach(marker => {
                    marker.classList.remove('highlighted');
                });
                
                // Remover selección de todas las filas
                const tbody = document.getElementById('trampasTableBody');
                tbody.querySelectorAll('tr').forEach(row => {
                    row.classList.remove('selected');
                });
                
                // Resaltar este marcador
                this.classList.add('highlighted');
                
                // Encontrar y resaltar la fila correspondiente
                const index = parseInt(this.dataset.index);
                const filas = tbody.querySelectorAll('tr');
                if (filas[index]) {
                    filas[index].classList.add('selected');
                    filas[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });

            planoContainer.appendChild(marcador);
        }

        // Modificar la parte del código que carga el estado
        cargarEstadoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    try {
                        const estado = JSON.parse(e.target.result);
                        
                        if (!estado.imagen) {
                            throw new Error('El archivo no contiene una imagen');
                        }

                        // Limpiar el estado actual
                        limpiarEstadoCompleto();

                        // Cargar la imagen primero
                        const img = new Image();
                        img.onload = function() {
                            planoImage.src = estado.imagen;
                            planoImage.style.display = 'block';
                            document.getElementById('placeholderText').style.display = 'none';
                            // Activar botones cuando se carga el estado
                            activarBotones();

                            // Esperar a que la imagen se renderice completamente
                            setTimeout(() => {
                                // Cargar trampas
                                if (Array.isArray(estado.trampas)) {
                                    window.puntos = estado.trampas;
                                    window.puntos.forEach(punto => {
                                        marcarTrampa(punto);
                                    });
                                }
                                
                                // Actualizar la tabla
                                actualizarTablaTrampas();

                                // En la parte donde se cargan las zonas (dentro del setTimeout)
                                if (Array.isArray(estado.zonas)) {
                                    window.zonas = estado.zonas;
                                    window.zonas.forEach(zona => {
                                        if (zona.tipo === 'poligono') {
                                            // Crear el polígono
                                            const poligono = document.createElement('div');
                                            poligono.className = 'zona-poligono';
                                            const path = zona.puntos.map(p => `${p.x}px ${p.y}px`).join(',');
                                            poligono.style.clipPath = `polygon(${path})`;
                                            poligono.dataset.zonaId = zona.id;
                                            planoContainer.appendChild(poligono);

                                            // Crear el texto si existe nombre
                                            if (zona.nombre) {
                                                const textoZona = document.createElement('div');
                                                textoZona.className = 'zona-texto';
                                                textoZona.textContent = zona.nombre;
                                                textoZona.style.left = `${zona.centro.x}px`;
                                                textoZona.style.top = `${zona.centro.y}px`;
                                                planoContainer.appendChild(textoZona);
                                            }
                                        }
                                    });
                                }
                            }, 100);
                        };
                        
                        img.onerror = function() {
                            throw new Error('No se pudo cargar la imagen del estado');
                        };
                        
                        img.src = estado.imagen;
                        
                    } catch (error) {
                        console.error('Error al cargar el archivo:', error);
                        alert('Error al cargar el archivo: ' + error.message + '\nAsegúrese de que sea un archivo JSON válido con el formato correcto.');
                    }
                };
                reader.readAsText(file);
            }
        });

        // Botón Mover Trampas
        btnMoverTrampa.addEventListener('click', () => {
            const modoActual = planoContainer.dataset.modoEdicion || '';
            if (modoActual === 'mover') {
                // Desactivar modo mover
                planoContainer.dataset.modoEdicion = '';
                btnMoverTrampa.classList.remove('active', 'bg-green-600', 'hover:bg-green-700');
                btnMoverTrampa.classList.add('bg-yellow-600', 'hover:bg-yellow-700');
                btnMoverTrampa.innerHTML = `
                    <i class="fas fa-arrows-alt mr-2"></i>
                    Mover Trampas
                `;
                planoContainer.style.cursor = 'default';
                
                // Remover clase de las trampas
                document.querySelectorAll('.trap-marker').forEach(trampa => {
                    trampa.classList.remove('movable');
                });
            } else {
                // Activar modo mover
                planoContainer.dataset.modoEdicion = 'mover';
                btnMoverTrampa.classList.add('active', 'bg-green-600', 'hover:bg-green-700');
                btnMoverTrampa.classList.remove('bg-yellow-600', 'hover:bg-yellow-700');
                btnMoverTrampa.innerHTML = `
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                `;
                planoContainer.style.cursor = 'move';
                
                // Agregar clase a las trampas
                document.querySelectorAll('.trap-marker').forEach(trampa => {
                    trampa.classList.add('movable');
                });
            }
        });

        // Agregar eventos para mover trampas
        planoContainer.addEventListener('mousedown', function(e) {
            if (planoContainer.dataset.modoEdicion !== 'mover') return;
            
            const trampa = e.target.closest('.trap-marker');
            if (trampa) {
                e.preventDefault();
                trampaSeleccionada = trampa;
                
                // Calcular el offset del clic relativo a la trampa
                const trampaRect = trampa.getBoundingClientRect();
                offsetX = e.clientX - trampaRect.left - trampaRect.width / 2;
                offsetY = e.clientY - trampaRect.top - trampaRect.height / 2;
                
                trampa.style.zIndex = '1000';
                trampa.classList.add('moving');
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (!trampaSeleccionada) return;
            
            const containerRect = planoContainer.getBoundingClientRect();
            const imagenRect = planoImage.getBoundingClientRect();
            
            // Calcular límites del área válida
            const minX = imagenRect.left - containerRect.left;
            const maxX = minX + imagenRect.width;
            const minY = imagenRect.top - containerRect.top;
            const maxY = minY + imagenRect.height;
            
            // Calcular nueva posición
            let newX = e.clientX - containerRect.left - offsetX;
            let newY = e.clientY - containerRect.top - offsetY;
            
            // Limitar al área de la imagen
            newX = Math.max(minX, Math.min(maxX, newX));
            newY = Math.max(minY, Math.min(maxY, newY));
            
            // Actualizar posición
            trampaSeleccionada.style.left = `${newX}px`;
            trampaSeleccionada.style.top = `${newY}px`;
        });

        document.addEventListener('mouseup', function() {
            if (!trampaSeleccionada) return;
            
            // Actualizar coordenadas en el array de puntos
            const index = parseInt(trampaSeleccionada.dataset.index);
            const containerRect = planoContainer.getBoundingClientRect();
            const imagenRect = planoImage.getBoundingClientRect();
            
            const trampaRect = trampaSeleccionada.getBoundingClientRect();
            const newX = trampaRect.left + trampaRect.width / 2 - imagenRect.left;
            const newY = trampaRect.top + trampaRect.height / 2 - imagenRect.top;
            
            if (window.puntos[index]) {
                window.puntos[index].x = newX;
                window.puntos[index].y = newY;
            }
            
            // Limpiar estado
            trampaSeleccionada.style.zIndex = '10';
            trampaSeleccionada.classList.remove('moving');
            trampaSeleccionada = null;
            offsetX = 0;
            offsetY = 0;
            
            // Actualizar tabla
            actualizarTablaTrampas();
        });

        // Dropdown de Agregar Trampa
        const dropdownButton = dropdownTrampa.querySelector('button');
        const dropdownMenu = dropdownTrampa.querySelector('.trap-menu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Eventos para tipos de trampas
        const trapLinks = dropdownMenu.querySelectorAll('a[data-trap-type]');
        trapLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                tipoTrampaSeleccionado = e.target.closest('a').dataset.trapType;
                modoEdicion = 'agregarTrampa';
                dropdownMenu.classList.add('hidden');
                
                // Cambiar el cursor para indicar modo de agregar
                planoContainer.style.cursor = 'crosshair';
                
                // Agregar clase activa al botón
                dropdownButton.classList.add('active');
                dropdownButton.style.backgroundColor = '#2563eb'; // Azul más oscuro
            });
        });

        // Reemplazar el evento de clic actual por este:
        planoContainer.addEventListener('click', function(e) {
            const rect = planoContainer.getBoundingClientRect();
            const imagen = planoImage.getBoundingClientRect();
            
            const clickX = e.clientX - rect.left;
            const clickY = e.clientY - rect.top;
            
            // Verificar si el clic está dentro de la imagen
            const imagenLeft = imagen.left - rect.left;
            const imagenTop = imagen.top - rect.top;
            const imagenRight = imagenLeft + imagen.width;
            const imagenBottom = imagenTop + imagen.height;
            
            if (clickX >= imagenLeft && clickX <= imagenRight && 
                clickY >= imagenTop && clickY <= imagenBottom) {
                
                // Manejar modo de dibujar zona
                if (planoContainer.dataset.modoEdicion === 'dibujarZona') {
                    // Agregar punto al polígono
                    puntosPoligono.push({ x: clickX, y: clickY });
                    
                    // Crear marcador de punto
                    const punto = document.createElement('div');
                    punto.className = 'punto-poligono';
                    punto.style.left = `${clickX}px`;
                    punto.style.top = `${clickY}px`;
                    planoContainer.appendChild(punto);
                    
                    // Actualizar polígono temporal
                    if (puntosPoligono.length > 2) {
                        const path = puntosPoligono.map(p => `${p.x}px ${p.y}px`).join(',');
                        poligonoTemporal.style.clipPath = `polygon(${path})`;
                        poligonoTemporal.style.display = 'block';
                    }

                    // Actualizar tooltip y mostrar botón de confirmar
                    if (puntosPoligono.length >= 3) {
                        tooltipElement.innerHTML = 'Haga clic en "Confirmar Zona" para finalizar';
                        confirmButton.classList.remove('hidden');
                    } else {
                        tooltipElement.innerHTML = `Haga clic para agregar puntos. Faltan ${3 - puntosPoligono.length} puntos mínimos.`;
                    }
                }
                
                // Manejar modo de agregar trampa
                else if (modoEdicion === 'agregarTrampa' && tipoTrampaSeleccionado) {
                    // Solicitar la zona
                    const zona = prompt('Ingrese la zona donde se ubicará la trampa:', '');
                    
                    // Solo continuar si se ingresó una zona
                    if (zona) {
                        // Crear nueva trampa con zona
                        const nuevaTrampa = {
                            id: `T${contadorTrampas++}`,
                            tipo: tipoTrampaSeleccionado,
                            x: clickX - imagenLeft,
                            y: clickY - imagenTop,
                            zona: zona // Agregar la zona a la trampa
                        };

                        // Agregar al array de puntos
                        if (!window.puntos) window.puntos = [];
                        window.puntos.push(nuevaTrampa);

                        // Crear el marcador visual
                        const marcador = document.createElement('div');
                        marcador.className = 'trap-marker';
                        marcador.style.position = 'absolute';
                        marcador.style.left = `${clickX}px`;
                        marcador.style.top = `${clickY}px`;
                        marcador.style.transform = 'translate(-50%, -50%)';
                        marcador.dataset.index = window.puntos.length - 1;

                        // Agregar icono según el tipo
                        const icon = document.createElement('i');
                        switch (tipoTrampaSeleccionado) {
                            case 'rodent':
                                icon.className = 'fas fa-mouse';
                                break;
                            case 'insect':
                                icon.className = 'fas fa-bug';
                                break;
                            case 'fly':
                                icon.className = 'fas fa-fly';
                                break;
                            case 'moth':
                                icon.className = 'fas fa-moth';
                                break;
                        }
                        marcador.appendChild(icon);

                        // Agregar tooltip con información
                        marcador.title = `${getTipoTrampa(tipoTrampaSeleccionado)} - ${nuevaTrampa.id}`;

                        // Agregar evento para eliminar
                        marcador.addEventListener('contextmenu', function(e) {
                            e.preventDefault();
                            if (confirm('¿Desea eliminar esta trampa?')) {
                                const index = parseInt(this.dataset.index);
                                window.puntos.splice(index, 1);
                                this.remove();
                                reindexarTrampas();
                                actualizarTablaTrampas();
                            }
                        });

                        planoContainer.appendChild(marcador);
                        actualizarTablaTrampas();

                        // Desactivar modo de agregar trampa después de colocar una
                        modoEdicion = null;
                        tipoTrampaSeleccionado = null;
                        planoContainer.style.cursor = 'default';
                        
                        // Resetear estado visual del botón
                        dropdownButton.classList.remove('active');
                        dropdownButton.style.backgroundColor = '';
                    }
                }
            }
        });

        // Cerrar dropdown cuando se hace clic fuera
        document.addEventListener('click', (e) => {
            if (!dropdownTrampa.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Agregar esta función para reindexar las trampas
        function reindexarTrampas() {
            // Reindexar los marcadores en el DOM
            document.querySelectorAll('.trap-marker').forEach((marker, index) => {
                marker.dataset.index = index;
            });
        }

        // Modificar la función de eliminar en actualizarTablaTrampas
        function actualizarTablaTrampas() {
            const tbody = document.getElementById('trampasTableBody');
            if (!tbody) return;
            
            tbody.innerHTML = '';

            if (!window.puntos || window.puntos.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">
                            No hay trampas registradas
                        </td>
                    </tr>`;
                return;
            }

            // Modificar el encabezado de la tabla para incluir la columna de zona
            const thead = document.querySelector('table thead tr');
            if (thead) {
                thead.innerHTML = `
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Tipo</th>
                    <th class="px-4 py-2 text-left">Ubicación</th>
                    <th class="px-4 py-2 text-left">Zona</th>
                    <th class="px-4 py-2 text-right">Acciones</th>
                `;
            }

            window.puntos.forEach((punto, index) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 cursor-pointer';
                tr.innerHTML = `
                    <td class="px-4 py-2">${punto.id || `T${index + 1}`}</td>
                    <td class="px-4 py-2">${getTipoTrampa(punto.tipo)}</td>
                    <td class="px-4 py-2">(${Math.round(punto.x)}, ${Math.round(punto.y)})</td>
                    <td class="px-4 py-2">${punto.zona || 'Sin zona'}</td>
                    <td class="px-4 py-2 text-right">
                        <button class="text-red-600 hover:text-red-800 delete-trap" title="Eliminar trampa">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                
                // Agregar evento de clic a la fila
                tr.addEventListener('click', (e) => {
                    if (e.target.closest('.delete-trap')) return;
                    
                    document.querySelectorAll('.trap-marker').forEach(marker => {
                        marker.classList.remove('highlighted');
                    });
                    
                    tbody.querySelectorAll('tr').forEach(row => {
                        row.classList.remove('selected');
                    });
                    
                    const marker = document.querySelector(`.trap-marker[data-index="${index}"]`);
                    if (marker) {
                        marker.classList.add('highlighted');
                        marker.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    
                    tr.classList.add('selected');
                });

                // Modificar el evento del botón eliminar
                const deleteBtn = tr.querySelector('.delete-trap');
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (confirm('¿Está seguro de que desea eliminar esta trampa?')) {
                        // Eliminar el marcador del plano
                        const marker = document.querySelector(`.trap-marker[data-index="${index}"]`);
                        if (marker) marker.remove();
                        
                        // Eliminar del array de puntos
                        window.puntos.splice(index, 1);
                        
                        // Reindexar las trampas restantes
                        reindexarTrampas();
                        
                        // Actualizar la tabla
                        actualizarTablaTrampas();
                    }
                });
                
                tbody.appendChild(tr);
            });
        }

        // Función auxiliar para obtener el nombre del tipo de trampa
        function getTipoTrampa(tipo) {
            const tipos = {
                'rodent': 'Trampa para Roedores',
                'insect': 'Trampa para Insectos',
                'fly': 'Trampa para Moscas',
                'moth': 'Trampa para Polillas'
            };
            return tipos[tipo] || 'Desconocido';
        }

        // Agregar estilos CSS para los marcadores
        const style = document.createElement('style');
        style.textContent = `
            .trap-marker {
                cursor: pointer;
                padding: 8px;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 50%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                z-index: 10;
                transition: transform 0.2s;
            }
            .trap-marker:hover {
                transform: scale(1.1);
                background: rgba(255, 255, 255, 1);
            }
            .trap-marker i {
                font-size: 16px;
                color: #444;
            }
        `;
        document.head.appendChild(style);

        // Agregar estilos para el contenedor del plano
        const planoContainerStyle = document.createElement('style');
        planoContainerStyle.textContent = `
            #planoContainer {
                position: relative;
                overflow: hidden;
            }
            #planoImage {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }
        `;
        document.head.appendChild(planoContainerStyle);

        // Agregar estos estilos CSS
        const moveStyles = document.createElement('style');
        moveStyles.textContent = `
            .trap-marker.movable {
                cursor: move;
            }
            .trap-marker.moving {
                opacity: 0.8;
                transform: scale(1.1);
            }
        `;
        document.head.appendChild(moveStyles);

        // Agregar estos estilos CSS para el botón activo
        const dropdownStyles = document.createElement('style');
        dropdownStyles.textContent = `
            .dropdown button.active {
                background-color: #2563eb !important;
            }
            .dropdown button.active:hover {
                background-color: #1d4ed8 !important;
            }
        `;
        document.head.appendChild(dropdownStyles);

        // Agregar estos estilos CSS para el resaltado
        const highlightStyles = document.createElement('style');
        highlightStyles.textContent = `
            .trap-marker.highlighted {
                box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.7);
                transform: scale(1.1);
                z-index: 1000 !important;
            }
            .trap-marker.highlighted i {
                color: #000;
            }
            tr.selected {
                background-color: rgba(255, 215, 0, 0.1);
            }
            tr.selected:hover {
                background-color: rgba(255, 215, 0, 0.2);
            }
            .trap-marker {
                transition: all 0.2s ease-in-out;
            }
        `;
        document.head.appendChild(highlightStyles);

        // Agregar el evento para el botón de Agregar Zona
        btnAgregarZona.addEventListener('click', () => {
            const modoActual = planoContainer.dataset.modoEdicion || '';
            if (modoActual === 'dibujarZona') {
                // Desactivar modo dibujar
                finalizarDibujoPoligono();
                planoContainer.dataset.modoEdicion = '';
                btnAgregarZona.classList.remove('active');
                planoContainer.style.cursor = 'default';
            } else {
                // Activar modo dibujar
                planoContainer.dataset.modoEdicion = 'dibujarZona';
                btnAgregarZona.classList.add('active');
                planoContainer.style.cursor = 'crosshair';
                iniciarDibujoPoligono();
            }
        });

        // Función para iniciar el dibujo del polígono
        function iniciarDibujoPoligono() {
            dibujandoPoligono = true;
            puntosPoligono = [];
            
            // Crear el polígono temporal
            poligonoTemporal = document.createElement('div');
            poligonoTemporal.className = 'zona-poligono-temporal';
            planoContainer.appendChild(poligonoTemporal);

            // Crear tooltip flotante
            tooltipElement = document.createElement('div');
            tooltipElement.className = 'tooltip-flotante';
            tooltipElement.innerHTML = 'Haga clic para agregar puntos. Mínimo 3 puntos.';
            document.body.appendChild(tooltipElement);

            // Crear botón de confirmar
            confirmButton = document.createElement('button');
            confirmButton.className = 'confirm-polygon-button hidden';
            confirmButton.innerHTML = `
                <i class="fas fa-check mr-2"></i>
                Confirmar Zona
            `;
            planoContainer.appendChild(confirmButton);

            // Evento para el botón confirmar
            confirmButton.addEventListener('click', () => {
                if (puntosPoligono.length >= 3) {
                    finalizarDibujoPoligono();
                    planoContainer.dataset.modoEdicion = '';
                    btnAgregarZona.classList.remove('active');
                    planoContainer.style.cursor = 'default';
                }
            });

            // Actualizar posición del tooltip con el movimiento del mouse
            document.addEventListener('mousemove', actualizarPosicionTooltip);
        }

        // Función para actualizar la posición del tooltip
        function actualizarPosicionTooltip(e) {
            if (tooltipElement) {
                const offset = 5; // Distancia del cursor al tooltip
                tooltipElement.style.left = `${e.clientX + offset}px`;
                tooltipElement.style.top = `${e.clientY + offset}px`;
            }
        }

        // Función para finalizar el dibujo
        function finalizarDibujoPoligono() {
            if (puntosPoligono.length >= 3) {
                // Solicitar nombre de la zona
                const nombreZona = prompt('Ingrese un nombre para la zona:', '');
                if (nombreZona) {
                    // Crear el polígono final
                    const poligono = document.createElement('div');
                    poligono.className = 'zona-poligono';
                    
                    // Calcular el path del polígono
                    const path = puntosPoligono.map(p => `${p.x}px ${p.y}px`).join(',');
                    poligono.style.clipPath = `polygon(${path})`;
                    
                    // Crear el contenedor del texto
                    const textoZona = document.createElement('div');
                    textoZona.className = 'zona-texto';
                    textoZona.textContent = nombreZona;
                    
                    // Calcular el centro de la zona para posicionar el texto
                    const centroX = puntosPoligono.reduce((sum, p) => sum + p.x, 0) / puntosPoligono.length;
                    const centroY = puntosPoligono.reduce((sum, p) => sum + p.y, 0) / puntosPoligono.length;
                    
                    textoZona.style.left = `${centroX}px`;
                    textoZona.style.top = `${centroY}px`;
                    
                    // Guardar la zona
                    if (!window.zonas) window.zonas = [];
                    const zonaId = `Z${window.zonas.length + 1}`;
                    window.zonas.push({
                        tipo: 'poligono',
                        puntos: puntosPoligono,
                        id: zonaId,
                        nombre: nombreZona,
                        centro: { x: centroX, y: centroY }
                    });
                    
                    // Agregar ID al elemento del DOM
                    poligono.dataset.zonaId = zonaId;
                    planoContainer.appendChild(poligono);
                    planoContainer.appendChild(textoZona);
                }
            }
            
            // Limpiar
            dibujandoPoligono = false;
            puntosPoligono = [];
            
            if (poligonoTemporal) {
                poligonoTemporal.remove();
                poligonoTemporal = null;
            }
            if (tooltipElement) {
                tooltipElement.remove();
                tooltipElement = null;
                document.removeEventListener('mousemove', actualizarPosicionTooltip);
            }
            if (confirmButton) {
                confirmButton.remove();
                confirmButton = null;
            }
            document.querySelectorAll('.punto-poligono').forEach(punto => punto.remove());
        }

        // Agregar estos estilos para el texto de la zona
        const zonaStyles = document.createElement('style');
        zonaStyles.textContent = `
            .tooltip-flotante {
                position: fixed;
                background-color: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 8px 12px;
                border-radius: 4px;
                font-size: 14px;
                pointer-events: none;
                z-index: 1000;
                transform: translate(0, -100%);
                white-space: nowrap;
            }

            .confirm-polygon-button {
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #059669;
                color: white;
                padding: 8px 16px;
                border-radius: 6px;
                cursor: pointer;
                display: flex;
                align-items: center;
                transition: all 0.2s;
                z-index: 1000;
            }

            .confirm-polygon-button:hover {
                background-color: #047857;
            }

            .confirm-polygon-button.hidden {
                display: none;
            }

            .zona-poligono-temporal,
            .zona-poligono {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(255, 255, 0, 0.2);
                border: 2px dashed rgba(0, 0, 0, 0.5);
                pointer-events: none;
            }

            .punto-poligono {
                position: absolute;
                width: 8px;
                height: 8px;
                background-color: #fff;
                border: 2px solid #000;
                border-radius: 50%;
                transform: translate(-50%, -50%);
                z-index: 1001;
            }

            .zona-texto {
                position: absolute;
                transform: translate(-50%, -50%);
                background-color: rgba(0, 0, 0, 0.7);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 14px;
                pointer-events: none;
                z-index: 1002;
                white-space: nowrap;
                text-align: center;
            }
        `;
        document.head.appendChild(zonaStyles);

        // Agregar estilos para botones desactivados
        const buttonStyles = document.createElement('style');
        buttonStyles.textContent = `
            button:disabled {
                pointer-events: none;
            }
            
            .cursor-not-allowed {
                cursor: not-allowed !important;
            }
        `;
        document.head.appendChild(buttonStyles);
    });
</script>

<?= $this->endSection() ?> 