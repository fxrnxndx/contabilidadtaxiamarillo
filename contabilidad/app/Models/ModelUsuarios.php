<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUsuarios extends Model
{
    protected $table = 'tbl_usuarios';
    protected $primaryKey = 'idUsuario';
    protected $allowedFields = ['idUsuario', 'usuario', 'password', 'correo', 'date_create'];

    protected $returnType     = 'array';

    public function obtenerUsuarios()
    {
        return $this->orderBy('usuario', 'ASC')->findAll();
    }

    //verificar usuario y password
    public function verificarUsuario($usuario, $password)
    {
        $existeRecord = $this->where('usuario', $usuario)
                            ->where('password', $password)
                            ->first();

        if ($existeRecord) {
            return true; // existe
        }
        return false; // Registro no existe
    }
}