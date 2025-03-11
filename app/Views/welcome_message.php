<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiPro - Sistema de Mapeo de Trampas</title>
    <link rel="icon" type="image/x-icon" href="servipro.png">

    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir archivo CSS personalizado  REVISAR EL BASE_URL-->
    
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <!-- Agregar Font Awesome en el head -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo.jpeg" alt="ServiPro Logo" height="70" class="d-inline-block align-text-top me-2">
                ServiPro Pruebas
            </a>
        </div>
    </nav>
    
    
    <!-- Contenido principal -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Sistema de Mapeo de Trampas Pruebas</h2>

                <!-- Botón para acceder al panel principal -->
                <div class="row mb-4">
                    <div class="col">
                        <a href="<?= base_url('home') ?>" class="btn btn-success btn-lg">
                            <i class="fas fa-th-large me-2"></i>
                            Acceder al Panel Principal
                        </a>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mb-3">
                    <div class="col">
                        <input type="file" id="planoInput" class="form-control" accept="image/*" style="display: none;">
                        <button id="btnSeleccionarImagen" class="btn btn-primary">Seleccionar Imagen</button>
                    </div>
                    <div class="col">
                        <button id="btnGuardar" class="btn btn-primary">Guardar Estado</button>
                        <input type="file" id="cargarEstadoInput" accept="application/json" style="display: none;">
                        <button id="btnCargar" class="btn btn-secondary">Cargar Estado</button>
                        <button id="btnLimpiar" class="btn btn-danger">Limpiar Todo</button>
                    </div>
                </div>

                <!-- Contenedor del plano -->
                <div id="planoContainer">
                    <img id="planoImage" style="display: none;">
                </div>

                <!-- Agregar después del div del planoContainer y antes del div de los botones -->
                <div class="table-responsive mt-4">
                    <h3>Lista de Trampas</h3>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tipo de Trampa</th>
                                <th>Coordenadas (X, Y)</th>
                                <th>Zona/Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="trampasTableBody">
                            <!-- Las filas se agregarán dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <!-- Botones para agregar trampas y zonas -->
                <div class="btn-group mb-3">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="btnAgregarTrampa" data-bs-toggle="dropdown">
                            Agregar Trampa
                        </button>
                        <ul class="dropdown-menu trap-menu">
                            <li><a class="dropdown-item" href="#" data-trap-type="rodent"><i class="fas fa-mouse"></i> Trampa para Roedores</a></li>
                            <li><a class="dropdown-item" href="#" data-trap-type="insect"><i class="fas fa-bug"></i> Trampa para Insectos</a></li>
                            <li><a class="dropdown-item" href="#" data-trap-type="fly"><i class="fas fa-fly"></i> Trampa para Moscas</a></li>
                            <li><a class="dropdown-item" href="#" data-trap-type="moth"><i class="fas fa-moth"></i> Trampa para Polillas</a></li>
                        </ul>
                    </div>
                    <button id="btnMoverTrampa" class="btn btn-warning">Mover Trampas</button>
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" id="btnAgregarZona" data-bs-toggle="dropdown">
                            Agregar Zona
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" id="btnZonaRectangulo">Rectángulo</a></li>
                            <li><a class="dropdown-item" href="#" id="btnZonaCirculo">Círculo</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluir archivo JavaScript personalizado -->
    <script src="<?= base_url('assets/js/mapa.js') ?>"></script>


</body>
</html>