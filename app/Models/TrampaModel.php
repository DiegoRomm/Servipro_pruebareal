<?php

namespace App\Models;

use CodeIgniter\Model;

class TrampaModel extends Model
{
    protected $table      = 'trampas'; // Nombre de la tabla
    protected $primaryKey = 'id';     // Clave primaria

    protected $allowedFields = [
        'id_trampa', 'sede_id', 'plano_id', 'tipo', 'ubicacion', 
        'coordenada_x', 'coordenada_y', 'fecha_instalacion', 'estado'
    ]; // Campos permitidos
    
    // Definir hooks para procesar datos antes de insertar
    protected $beforeInsert = ['generarIdTrampa'];
    
    /**
     * Genera un ID único para cada trampa antes de insertarla
     * 
     * @param array $data Datos a insertar
     * @return array Datos modificados con el ID único
     */
    protected function generarIdTrampa(array $data)
    {
        // Si ya se proporcionó un id_trampa, no lo sobrescribimos
        if (!empty($data['data']['id_trampa'])) {
            return $data;
        }
        
        // Generar un ID único para la trampa
        $data['data']['id_trampa'] = $this->generarCodigoUnico();
        
        return $data;
    }
    
    /**
     * Genera un código único de 4 dígitos para la trampa
     * 
     * @return string Código único generado de 4 dígitos
     */
    private function generarCodigoUnico()
    {
        // Obtener el último ID numérico
        $ultimoId = $this->obtenerUltimoNumeroSecuencial();
        
        // Incrementar en 1 y asegurar que sea de 4 dígitos
        $nuevoId = $ultimoId + 1;
        $idFormateado = str_pad($nuevoId, 4, '0', STR_PAD_LEFT);
        
        return $idFormateado;
    }
    
    /**
     * Obtiene el último número secuencial usado
     * 
     * @return int Último número secuencial
     */
    private function obtenerUltimoNumeroSecuencial()
    {
        // Buscar el último id_trampa numérico
        $ultimaTrampa = $this->select('id_trampa')
                             ->orderBy('id', 'DESC')
                             ->first();
        
        if (empty($ultimaTrampa)) {
            return 0;
        }
        
        // Convertir a entero, si no es numérico retornar 0
        $ultimoId = (int) $ultimaTrampa['id_trampa'];
        return $ultimoId > 0 ? $ultimoId : 0;
    }
}