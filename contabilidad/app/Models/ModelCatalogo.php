<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCatalogo extends Model
{
    protected $table = 'tbl_catalogo';
    protected $primaryKey = 'idCatalogo';
    protected $allowedFields = ['idCatalogo', 'idCategoria', 'numParte', 'nombre', 'descripcion', 'compatible', 'marca', 'modelo', 'unidad', 'precio', 'img', 'date_create', 'popular', 'stock'];

    protected $returnType     = 'array';
    
    public function obtenerCatalogo()
    {
        return $this->select('tbl_catalogo.*, tbl_categoria.nombre as nombreCategoria')
                    ->join('tbl_categoria', 'tbl_categoria.idCategoria = tbl_catalogo.idCategoria', 'left')
                    ->orderBy('tbl_catalogo.nombre', 'ASC')
                    ->findAll();
    }

    // Método para obtener con paginación
    public function getPaginated($perPage = 12)
    {
        return $this->orderBy('nombre', 'ASC')->paginate($perPage);
    }

    //verificar si existe un numero de parte
    public function existeNumParte($numParte)
    {
        return $this->where('numParte', $numParte)
                    ->first();
    }

    //insertar un producto
    public function insertarProducto($producto)
    {
        return $this->insert($producto);
    }

    // insertar una lista de productos
    public function insertarListaProductos($productos)
    {
        return $this->insertBatch($productos);
    }

    //obtener 5 produtos populares aleatorios
    public function obtenerProductosPopulares($limit = 5)
    {
        return $this->where('popular', 1)
                    ->orderBy('RAND()')
                    ->limit($limit)
                    ->find();
    }

    //obtener un producto por su id
    public function obtenerProductoPorId($id)
    {
        return $this->where('idCatalogo', $id)
                    ->first();
    }

    //actualizar un producto
    public function actualizarProducto($id, $data)
    {
        return $this->update($id, $data);
    }

    //eliminar un producto
    public function eliminarProducto($id)
    {
        return $this->delete($id);
    }


}