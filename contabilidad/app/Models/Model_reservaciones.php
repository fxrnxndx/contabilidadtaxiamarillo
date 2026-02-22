<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_reservaciones extends Model
{
    protected $table = 'tbl_reservaciones';
    protected $primaryKey = 'id_reservacion';
    protected $allowedFields = ['id_reservacion', 'id_venta', 'id_cliente', 'id_usuario_reserva', 'fecha_servicio', 'hora_servicio', 'num_pasajeros', 'domicilio_origen', 'domicilio_destino', 'costo_servicio', 'notas', 'status', 'fecha_creacion'];
    protected $returnType = 'array';
    //traer todos los clientes
    public function obtenerReservaciones()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->orderBy('tbl_reservaciones.fecha_creacion', 'DESC')->findAll();
    }

    //obtener reservaciones con status pendiente y confirmado
    public function obtenerReservacionesPendientesConfirmados()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', 'PENDIENTE')->orWhere('tbl_reservaciones.status', 'CONFIRMADO')->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //obtener reservaciones con status pendiente
    public function obtenerReservacionesPendientes()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', 'PENDIENTE')->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //obtener reservaciones con status confirmado
    public function obtenerReservacionesConfirmados()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', 'CONFIRMADO')->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //obtener reservaciones con status cancelado
    public function obtenerReservacionesCancelados()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', 'CANCELADO')->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //obtener reservaciones con status VIAJE REALIZADO
    public function obtenerReservacionesViajeRealizado()
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', 'VIAJE REALIZADO')->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //obtener reservaciones por status
    public function obtenerReservacionesPorEstatus($estatus)
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.status', $estatus)->orderBy('tbl_reservaciones.fecha_servicio', 'ASC')->findAll();
    }

    //registrar reservacion
    public function registrarReservacion($data)
    {
        return $this->insert($data);
    }

    //actualizar reservacion
    public function actualizarReservacion($data)
    {
        return $this->update($data['id_reservacion'], $data);
    }
    //obtener dias faltantes
    public function obtenerDiasFaltantes($fecha)
    {
        date_default_timezone_set('America/Tijuana');
        $fechaActual = date('Y-m-d');
        $fechaServicio = $fecha;
        $fechaServicio = date('Y-m-d', strtotime($fechaServicio));
        $diasFaltantes = (strtotime($fechaServicio) - strtotime($fechaActual)) / 86400;
        return $diasFaltantes;
    }
    //obtener reservacion
    public function obtenerReservacion($id_reservacion)
    {
        //hacemos join con la tabla clientes
        $this->select('tbl_reservaciones.*, tbl_clientes.nombre, tbl_clientes.apellidos');
        $this->join('tbl_clientes', 'tbl_reservaciones.id_cliente = tbl_clientes.id_cliente');
        return $this->where('tbl_reservaciones.id_reservacion', $id_reservacion)->first();
    }

}