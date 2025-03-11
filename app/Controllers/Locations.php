<?php
namespace App\Controllers;

use App\Models\SedeModel;
use App\Models\TrampaModel;
use App\Models\IncidenciaModel;
use CodeIgniter\I18n\Time;

class Locations extends BaseController
{
    public function index(): string
    {
        // Cargar el modelo de sedes
        $sedeModel = new SedeModel();
        
        // Obtener todas las sedes
        $data['sedes'] = $sedeModel->findAll();

        // Cargar el modelo de trampas
        $trampaModel = new TrampaModel();

        // Si hay una sede seleccionada (por defecto la primera)
        $sedeSeleccionada = $this->request->getGet('sede_id');
        if (empty($sedeSeleccionada) && !empty($data['sedes'])) {
            $sedeSeleccionada = $data['sedes'][0]['id'];
        }

        // Verificar si la sede seleccionada es válida
        if (empty($sedeSeleccionada)) {
            $data['mensaje_error'] = "No hay sede seleccionada.";
            return view('locations/index', $data);
        }

        $data['sedeSeleccionada'] = $sedeSeleccionada;
        $db = \Config\Database::connect();

        // Inicializar datos para evitar errores en la vista
        $data['totalTrampasSede'] = 0;
        $data['trampasDetalle'] = [];
        $data['totalIncidenciasPorTipo'] = [];
        $data['totalCapturas'] = 0;
        $data['efectividad'] = 0;
        $data['capturasPorMes'] = [];

        // Obtener el total de trampas para la sedeeeeeeeeeeeeeee
        $builder = $db->table('trampas')->where('sede_id', $sedeSeleccionada);
        $data['totalTrampasSede'] = $builder->countAllResults(false);

        // Obtener el detalle de las trampas (nombre, tipo y ubicación)
        $query = $db->table('trampas')
            ->select('id, nombre, tipo, ubicacion')
            ->where('sede_id', $sedeSeleccionada)
            ->get();
        $data['trampasDetalle'] = $query->getResultArray();

        // Obtener el total de incidencias agrupadas por tipo_incidencia y tipo_plaga
        $query = $db->table('incidencias')
            ->select('tipo_incidencia, tipo_plaga, COUNT(*) as total')
            ->where('sede_id', $sedeSeleccionada)
            ->groupBy(['tipo_incidencia', 'tipo_plaga'])
            ->get();
        $data['totalIncidenciasPorTipo'] = $query->getResultArray();

        // Obtener el total de capturas (solo incidencias de tipo "Captura")
        $query = $db->table('incidencias i')
            ->select('COUNT(*) as totalCapturas')
            ->join('trampas t', 'i.id_trampa = t.id')
            ->where('t.sede_id', $sedeSeleccionada)
            ->where('i.tipo_incidencia', 'Captura')
            ->get();
        $result = $query->getRow();
        $data['totalCapturas'] = $result->totalCapturas ?? 0;

        // Calcular la efectividad evitando división por cero
        if ($data['totalCapturas'] > 0) {
            $data['efectividad'] = round(($data['totalTrampasSede'] / $data['totalCapturas']) * 100, 2);
        }

      // Obtener las capturas por mes (garantizando que devuelve datos en formato correcto)
      $query = $db->table('incidencias i')
      ->select("DATE_FORMAT(i.fecha, '%Y-%m') as mes, i.tipo_plaga, COUNT(*) as total")
      ->join('trampas t', 'i.id_trampa = t.id')
      ->where('t.sede_id', $sedeSeleccionada)
      ->groupBy(["mes", "i.tipo_plaga"])
      ->orderBy("mes", "ASC")
      ->get();
  
  $data['incidenciasPorTipoPlaga'] = $query->getResultArray();
  $query = $db->table('incidencias i')
    ->select("DATE_FORMAT(i.fecha, '%Y-%m') as mes, i.tipo_incidencia, COUNT(*) as total")
    ->join('trampas t', 'i.id_trampa = t.id')
    ->where('t.sede_id', $sedeSeleccionada)
    ->groupBy(["mes", "i.tipo_incidencia"])
    ->orderBy("mes", "ASC")
    ->get();

$data['incidenciasPorTipoIncidencia'] = $query->getResultArray();
// Obtener el nombre de la sede seleccionada
$sedeSeleccionadaNombre = "";
foreach ($data['sedes'] as $sede) {
    if ($sede['id'] == $sedeSeleccionada) {
        $sedeSeleccionadaNombre = $sede['nombre'];
        break;
    }
}

// Pasar el nombre de la sede a la vista
$data['sedeSeleccionadaNombre'] = $sedeSeleccionadaNombre;

// Obtener el conteo de trampas por ubicación
$query = $db->table('trampas')
    ->select('ubicacion, COUNT(*) as total')
    ->where('sede_id', $sedeSeleccionada)
    ->groupBy('ubicacion')
    ->get();
$data['trampasPorUbicacion'] = $query->getResultArray();

// Imprimir los datos en el servidor para verificar que son correctos
error_log("Datos capturasPorMes: " . json_encode($data['capturasPorMes']));

        return view('locations/index', $data);
    }
}
