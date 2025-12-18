<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Clientes extends Model
{
    protected $table = 'tbl_clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = ['id_cliente', 'nombre', 'apellidos', 'correo', 'telefono1', 'telefono2', 'fecha_creacion'];
    protected $returnType = 'array';

    //traer todos los clientes
    public function obtenerClientes()
    {
        return $this->orderBy('apellidos', 'ASC')->findAll();
    }
    public function obtenerClientesCount()
    {
        return $this->countAll();
    }
    public function obtenerClientesBySearch($search)
    {
        return $this->like('nombre', $search)->orLike('apellidos', $search)->orderBy('apellidos', 'ASC')->findAll();
    }

    public function obtenerCliente($id_cliente)
    {
        return $this->where('id_cliente', $id_cliente)->first();
    }

    public function registrarCliente($data)
    {
        return $this->insert($data);
    }

    public function actualizarCliente($data)
    {
        return $this->update($data['id_cliente'], $data);
    }

    public function eliminarCliente($id_cliente)
    {
        return $this->delete($id_cliente);
    }

    //buscar por nombre y apellidos
    public function obtenerClienteByNombreApellidos($nombre, $apellidos)
    {
        return $this->where('nombre', $nombre)->where('apellidos', $apellidos)->first();
    }
}