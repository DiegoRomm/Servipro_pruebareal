<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SedeModel;
use CodeIgniter\I18n\Time;

class SedesController extends BaseController
{
    public function index()
    {
        return view('prueba');
    }

    public function guardar()
    {
        // Validar los datos del formulario
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre'    => 'required|max_length[255]',
            'direccion' => 'required|max_length[255]',
            'ciudad'    => 'required|max_length[100]',
            'pais'      => 'required|max_length[100]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation failed: ' . print_r($validation->getErrors(), true));
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Por favor, complete todos los campos correctamente.');
        }

        try {
            // Crear fecha actual en zona horaria de México
            $now = Time::now('America/Mexico_City');

            // Obtener los datos del formulario
            $data = [
                'nombre'         => $this->request->getPost('nombre'),
                'direccion'      => $this->request->getPost('direccion'),
                'ciudad'         => $this->request->getPost('ciudad'),
                'pais'           => $this->request->getPost('pais'),
                'fecha_creacion' => $now->format('Y-m-d H:i:s')
            ];

            // Log de los datos que se intentan guardar
            log_message('info', 'Intentando guardar sede con datos: ' . print_r($data, true));

            // Guardar los datos en la base de datos
            $sedeModel = new SedeModel();
            $sedeModel->insert($data);

            // Log de éxito
            log_message('info', 'Sede guardada correctamente con ID: ' . $sedeModel->getInsertID());

            return redirect()->to('Inicio')
                            ->with('message', 'Sede guardada correctamente.');
        } catch (\Exception $e) {
            // Log del error
            log_message('error', 'Error al guardar sede: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error al guardar la sede. Por favor, intente nuevamente.');
        }
    }

    public function listar()
    {
        // Cargar el modelo
        $sedeModel = new SedeModel();

        // Obtener todas las sedes
        $data['sedes'] = $sedeModel->findAll();

        // Cargar la vista y pasar los datos
        return view('prueba2', $data);
    }

    public function ver($id = null)
    {
        // Verificar si se proporcionó un ID
        if ($id === null) {
            return redirect()->to('/sedes/listar')->with('error', 'ID de sede no proporcionado.');
        }

        // Cargar el modelo
        $sedeModel = new SedeModel();

        // Obtener la sede por su ID
        $data['sede'] = $sedeModel->find($id);

        // Verificar si la sede existe
        if (empty($data['sede'])) {
            return redirect()->to('/sedes/listar')->with('error', 'Sede no encontrada.');
        }

        // Cargar la vista y pasar los datos
        return view('prueba3', $data);
    }
    
    public function vista()
    {
        return view('welcome_message');
    }
}