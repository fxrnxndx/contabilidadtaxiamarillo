<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCategoria extends Model
{
    protected $table = 'tbl_categoria';
    protected $primaryKey = 'idCategoria';
    protected $allowedFields = ['idCategoria', 'nombre', 'descripcion'];

    protected $returnType     = 'array';

    public function obtenerCategorias()
    {
        return $this->orderBy('nombre', 'ASC')->findAll();
    }
    //obtener categorias excepto el idCategoria 1 (sin categoria)
    public function obtenerCategoriasExceptoSinCategoria()
    {
        return $this->where('idCategoria !=', 1)->orderBy('nombre', 'ASC')->findAll();
    }
    //obtener categoria por id
    public function obtenerCategoriaPorId($id)
    {
        return $this->where('idCategoria', $id)->first();
    }

    //registrar categoria
    public function registrarCategoria($data)
    {
        return $this->insert($data);
    }

    //actualizar categoria
    public function actualizarCategoria($id, $data)
    {
        return $this->update($id, $data);
    }
    //eliminar categoria
    public function eliminarCategoria($id)
    {
        return $this->delete($id);
    }
}