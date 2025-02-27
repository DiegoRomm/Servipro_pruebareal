<?php

namespace App\Controllers;
use App\Models\SedeModel;
use App\Models\PlanoModel;
use CodeIgniter\I18n\Time;

class Blueprints extends BaseController
{
    public function index()
    {
        // Cargar el modelo de sedes
        $sedeModel = new SedeModel();
        
        // Obtener todas las sedes
        $data['sedes'] = $sedeModel->findAll();
        
        // Cargar la vista con los datos
        return view('blueprints/index', $data);
    }

    public function view($id = null): string
    {
        if (!$id) {
            return redirect()->to('/blueprints')->with('error', 'Sede no especificada');
        }

        // Cargar modelos
        $sedeModel = new SedeModel();
        $planoModel = new PlanoModel();

        // Obtener información de la sede
        $sede = $sedeModel->find($id);
        if (!$sede) {
            return redirect()->to('/blueprints')->with('error', 'Sede no encontrada');
        }

        // Obtener planos de la sede
        $planos = $planoModel->where('sede_id', $id)->findAll();

        $data = [
            'sede' => $sede,
            'planos' => $planos
        ];

        return view('blueprints/view', $data);
    }

    public function guardar_plano()
    {
        // Validar los datos del formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|max_length[255]',
            'descripcion' => 'required',
            'sede_id' => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Por favor, complete todos los campos correctamente.');
        }

        try {
            // Obtener los datos del formulario
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
                'sede_id' => $this->request->getPost('sede_id'),
                'fecha_creacion' => Time::now('America/Mexico_City')->format('Y-m-d H:i:s')
            ];

            // Guardar los datos en la base de datos
            $planoModel = new PlanoModel();
            $planoId = $planoModel->insert($data, true); // El segundo parámetro true hace que retorne el ID insertado

            // Redirigir a la vista del plano con mensaje de éxito
            return redirect()->to('blueprints/viewplano/' . $planoId)
                            ->with('message', 'Plano guardado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error al guardar el plano. Por favor, intente nuevamente.');
        }
    }

    // Agregar el método para ver un plano específico
    public function viewplano($id = null)
    {
        if (!$id) {
            return redirect()->to('/blueprints')->with('error', 'Plano no especificado');
        }

        // Cargar modelos
        $planoModel = new PlanoModel();
        $sedeModel = new SedeModel();

        // Obtener información del plano
        $plano = $planoModel->find($id);
        if (!$plano) {
            return redirect()->to('/blueprints')->with('error', 'Plano no encontrado');
        }

        // Obtener información de la sede asociada
        $sede = $sedeModel->find($plano['sede_id']);

        $data = [
            'plano' => $plano,
            'sede' => $sede
        ];

        return view('blueprints/viewplano', $data);
    }
} 