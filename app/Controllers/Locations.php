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
        
        $data['sedeSeleccionada'] = $sedeSeleccionada;
        
        // Si hay una sede seleccionada, obtener el total de trampas para esa sede
        if (!empty($sedeSeleccionada)) {
            // Obtener el total de trampas para esta sede
            $data['totalTrampasSede'] = $trampaModel->where('sede_id', $sedeSeleccionada)->countAllResults();
            
            // Usar una consulta SQL directa para obtener las capturas
            $db = \Config\Database::connect();
            $builder = $db->table('incidencias i');
            $builder->select('COUNT(*) as total');
            $builder->join('trampas t', 'i.id_trampa = t.id_trampa');
            $builder->where('t.sede_id', $sedeSeleccionada);
            $builder->like('i.tipo_incidencia', 'captura', 'both', null, true); // case-insensitive
            $result = $builder->get()->getRow();
            
            // Guardar el total de capturas
            $data['totalCapturas'] = $result->total;
        } else {
            $data['totalTrampasSede'] = 0;
            $data['totalCapturas'] = 0;
        }
        
        return view('locations/index', $data);
    }
} 