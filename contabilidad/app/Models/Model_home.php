<?php


namespace App\Models;

use CodeIgniter\Model;

class Model_home extends Model
{
  function __construct()
  {
    parent::__construct();
    $this->db = \Config\Database::connect();
  }

  function login($user, $pass)
  {
    $sql = "SELECT * FROM tbl_usuarios WHERE usuario='{$user}' AND contra='{$pass}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function DatosUsuario($user)
  {
    $sql = "SELECT id_tipo_usuario_fk,id_perfil FROM tbl_usuarios WHERE usuario='{$user}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function DatosAdministrador($idadministrador)
  {
    $sql = "SELECT * FROM tbl_administrador WHERE id_administrador='{$idadministrador}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ViajesIngresosTTE($fecha)
  {
    $sql = "SELECT COUNT(tblventas.id_ventas) as ventas,
   COALESCE((select SUM(v1.total) from tbl_ventas as v1 where v1.estatus='VENDIDO' AND v1.id_moneda_fk=2 and v1.id_empresa_fk=1 and v1.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59'),0)
   *
   (select cambio.valor from tbl_tipo_cambio as cambio)
   +
   COALESCE((select SUM(v2.total) from tbl_ventas as v2 where v2.estatus='VENDIDO' AND v2.id_moneda_fk=1 and v2.id_empresa_fk=1 and v2.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59' ),0)
    as ingreso FROM tbl_ventas as tblventas WHERE tblventas.id_empresa_fk=1 and tblventas.estatus='VENDIDO'  and tblventas.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ViajesIngresosSAAT($fecha)
  {
    $sql = "SELECT COUNT(tblventas.id_ventas) as ventas,
   COALESCE((select SUM(v1.total) from tbl_ventas as v1 where v1.estatus='VENDIDO' AND v1.id_moneda_fk=2 and v1.id_empresa_fk=2 and v1.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59'),0)
   *
   (select cambio.valor from tbl_tipo_cambio as cambio)
   +
   COALESCE((select SUM(v2.total) from tbl_ventas as v2 where v2.estatus='VENDIDO'AND v2.id_moneda_fk=1 and v2.id_empresa_fk=2 and v2.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59' ),0)
    as ingreso FROM tbl_ventas as tblventas WHERE tblventas.id_empresa_fk=2 and tblventas.estatus='VENDIDO'  and tblventas.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }



  function AgregarChofer($nombre, $apellidos, $telefono, $ganancia, $id_empresa_fk, $socio, $estatus, $noempleado, $unidad)
  {
    $sql = "INSERT INTO tbl_chofer (numero_empleado,nombre,apellidos,telefono,porcentaje_ganancia,id_empresa_fk,id_socio_fk,estatus,id_unidad_fk) 
          VALUES ('{$noempleado}','{$nombre}','{$apellidos}','{$telefono}','{$ganancia}','{$id_empresa_fk}','{$socio}','{$estatus}','{$unidad}')";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ExistenciaUsuarioChofer($usuario)
  {
    $sql = "SELECT * FROM tbl_usuarios WHERE usuario='{$usuario}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ExistenciaChofer($noempleado)
  {
    $sql = "SELECT * FROM tbl_chofer WHERE numero_empleado='{$noempleado}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function TodosChofer()
  {
    $sql = "SELECT chofer.* , 
  empresa.nombre as empresanom,
  socio.nombre as socionom,
  unidad.Placas as placas, 
  unidad.NumUnidad as numunidad,   
  usuarios.*
  FROM tbl_chofer as chofer 
  INNER JOIN tbl_usuarios as usuarios ON chofer.numero_empleado = usuarios.id_perfil 
  INNER JOIN tbl_empresa as empresa ON chofer.id_empresa_fk = empresa.id_empresa 
  INNER JOIN tbl_socios as socio ON chofer.id_socio_fk = socio.id_socios 
  INNER JOIN tbl_unidad as unidad ON chofer.id_unidad_fk = unidad.Id_unidad 
  WHERE chofer.id_empresa_fk=empresa.id_empresa and usuarios.id_tipo_usuario_fk=3
  ORDER BY chofer.numero_empleado ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ActualizarChofer($nombre, $apellidos, $telefono, $ganancia, $id_empresa_fk, $estatus, $idchofer, $unidad, $socio)
  {
    $sql = "UPDATE tbl_chofer SET nombre='{$nombre}',
  apellidos='{$apellidos}',
  telefono='{$telefono}',
  porcentaje_ganancia='{$ganancia}',
  id_empresa_fk='{$id_empresa_fk}',
  id_unidad_fk='{$unidad}',
  id_socio_fk='{$socio}',
  estatus='{$estatus}' 
  WHERE id_chofer='{$idchofer}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarUsuarioChofer($usuario, $contra, $estatus, $noempleado)
  {
    $sql = "UPDATE tbl_usuarios SET contra='{$contra}',
  usuario='{$usuario}',
  estatus='{$estatus}' 
  WHERE id_perfil='{$noempleado}' and id_tipo_usuario_fk=3 ";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function BuscarEmpresaChofer($idempresa)
  {
    $sql = "SELECT * FROM tbl_chofer WHERE id_empresa_fk='{$idempresa}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function BuscarEmpresaUnidad($idempresa)
  {
    $sql = "SELECT * FROM tbl_unidad WHERE id_empresa_fk='{$idempresa}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  //inicia  bloque unidad
  function TodasUnidades()
  {
    $sql = "SELECT *, 
  socio.nombre as socionom
  FROM tbl_unidad 
  INNER JOIN tbl_socios as socio ON tbl_unidad.id_socio_fk=socio.id_socios
  ORDER BY Id_unidad ASC
   ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
   function TodosTipoPago()
  {
    $sql = "SELECT *
  FROM tbl_tipo_pago ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ExistenciaUnidad($placas)
  {
    $sql = "SELECT * FROM tbl_unidad WHERE Placas='{$placas}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function AgregarUnidad($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $poliza, $tarjeta)
  {
    $sql = "INSERT INTO tbl_unidad (Placas,Marca,Modelo,NumUnidad,ano,id_empresa_fk,id_socio_fk,Estatus,poliza_seguro,tarjeta_circulacion) 
          VALUES ('{$placas}','{$marca}','{$modelo}','{$numunidad}','{$ano}','{$idempresa}','{$idsocio}','{$estatus}','{$poliza}','{$tarjeta}')";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ActualizarUnidad($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $idunidad, $poliza)
  {
    $sql = "UPDATE tbl_unidad SET Placas='{$placas}',
  Marca='{$marca}',
  Modelo='{$modelo}',
  ano='{$ano}',
  poliza_seguro='{$poliza}',
  NumUnidad='{$numunidad}',
  id_empresa_fk='{$idempresa}',
  id_socio_fk='{$idsocio}',
  Estatus='{$estatus}' 
  WHERE Id_unidad='{$idunidad}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarUnidad1($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $idunidad)
  {
    $sql = "UPDATE tbl_unidad SET Placas='{$placas}',
  Marca='{$marca}',
  Modelo='{$modelo}',
  ano='{$ano}',
  NumUnidad='{$numunidad}',
  id_empresa_fk='{$idempresa}',
  id_socio_fk='{$idsocio}',
  Estatus='{$estatus}' 
  WHERE Id_unidad='{$idunidad}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarUnidad2($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $idunidad, $tarjeta)
  {
    $sql = "UPDATE tbl_unidad SET Placas='{$placas}',
  Marca='{$marca}',
  Modelo='{$modelo}',
  ano='{$ano}',
  NumUnidad='{$numunidad}',
  tarjeta_circulacion='{$tarjeta}',
  id_empresa_fk='{$idempresa}',
  id_socio_fk='{$idsocio}',
  Estatus='{$estatus}' 
  WHERE Id_unidad='{$idunidad}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarUnidad3($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $idunidad, $poliza, $tarjeta)
  {
    $sql = "UPDATE tbl_unidad SET Placas='{$placas}',
  Marca='{$marca}',
  Modelo='{$modelo}',
  ano='{$ano}',
  NumUnidad='{$numunidad}',
  tarjeta_circulacion='{$tarjeta}',
  poliza_seguro='{$poliza}',
  id_empresa_fk='{$idempresa}',
  id_socio_fk='{$idsocio}',
  Estatus='{$estatus}' 
  WHERE Id_unidad='{$idunidad}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  //termina bloque unidad

  //inicia bloque socio
  function TodoSocio()
  {
    $sql = "SELECT *
  FROM tbl_socios
  ORDER BY id_socios ASC";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  //termina bloque socio


  function BuscarEmpresaVendedor($idempresa)
  {
    $sql = "SELECT * FROM tbl_vendedor WHERE id_empresa_fk='{$idempresa}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ExistenciaSupervisor($telefono)
  {
    $sql = "SELECT * FROM tbl_supervisor WHERE telefono='{$telefono}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function AgregarSupervisor($nombre, $apellidos, $telefono, $ganancia, $id_empresa_fk, $estatus)
  {
    $sql = "INSERT INTO tbl_supervisor (nombre,apellidos,telefono,porcentaje_ganancia,id_empresa_fk,estatus) 
          VALUES ('{$nombre}','{$apellidos}','{$telefono}','{$ganancia}','{$id_empresa_fk}','{$estatus}')";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function TodosSupervisor()
  {
    $sql = "SELECT supervisor.*, empresa.nombre as empresanom FROM tbl_supervisor as supervisor INNER JOIN tbl_empresa as empresa  ON supervisor.id_empresa_fk = empresa.id_empresa WHERE supervisor.id_empresa_fk=empresa.id_empresa ORDER BY id_supervisor ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function setStatusToSale($id_sale, $status, $motive)
  {
    $sql = "UPDATE tbl_ventas SET estatus='{$status}', motivo_cancelado='{$motive}'
  WHERE id_ventas={$id_sale}";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function setDriverToSale($id_sale, $id_driver)
  {
    $sql = "UPDATE tbl_ventas SET id_chofer_fk={$id_driver}
  WHERE id_ventas={$id_sale}";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function setUnidadToSale($id_sale, $NumUnidad)
  {
    $sql = "UPDATE tbl_ventas SET id_unidad_fk='{$NumUnidad}'
  WHERE id_ventas={$id_sale}";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function setTotalToSale($id_sale, $total)
  {
    $sql = "UPDATE tbl_ventas SET total='{$total}'
    WHERE id_ventas={$id_sale}";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function setTipoPago($id_sale, $tipopago)
  {
    $sql = "UPDATE tbl_ventas SET id_tipo_pago_fk='{$tipopago}'
    WHERE id_ventas={$id_sale}";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function getDriver($id_driver)
  {

    $sql = "SELECT numero_empleado,nombre,apellidos FROM tbl_chofer WHERE numero_empleado ='{$id_driver}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query->getresultArray();
    }
    else {
      return false;
    }
  }
  function getUnidad($NumUnidad)
  {

    $sql = "SELECT NumUnidad,Placas,Marca FROM tbl_unidad WHERE NumUnidad ='{$NumUnidad}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query->getresultArray();
    }
    else {
      return false;
    }
  }

  function ActualizarSupervisor($nombre, $apellidos, $telefono, $ganancia, $id_empresa_fk, $estatus, $idsupervisor)
  {
    $sql = "UPDATE tbl_supervisor SET nombre='{$nombre}',
  apellidos='{$apellidos}',
  telefono='{$telefono}',
  porcentaje_ganancia='{$ganancia}',
  id_empresa_fk='{$id_empresa_fk}',
  estatus='{$estatus}' 
  WHERE id_supervisor='{$idsupervisor}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ExistenciaUsuarioVendedor($usuario)
  {
    $sql = "SELECT * FROM tbl_usuarios WHERE usuario='{$usuario}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ExistenciaVendedor($telefono)
  {
    $sql = "SELECT * FROM tbl_vendedor WHERE telefono='{$telefono}'";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function AgregarVendedor($nombre, $apellidos, $telefono, $ganancia, $id_empresa_fk, $estatus)
  {
    $sql = "INSERT INTO tbl_vendedor (nombre,apellidos,telefono,porcentaje_ganancia,id_empresa_fk,estatus) 
          VALUES ('{$nombre}','{$apellidos}','{$telefono}','{$ganancia}','{$id_empresa_fk}','{$estatus}')";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function AgregarUsuario($usuario, $contra, $id_tipo_usuario_fk, $id_perfil, $estatus)
  {
    $sql = "INSERT INTO tbl_usuarios (usuario,contra,id_tipo_usuario_fk,id_perfil,estatus) 
          VALUES ('{$usuario}','{$contra}',{$id_tipo_usuario_fk},{$id_perfil},'{$estatus}')";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function TodosVendedores()
  {
    $sql = "SELECT vendedores.* , usuarios.*, empresa.nombre as empresanom FROM tbl_vendedor as vendedores 
  INNER JOIN tbl_usuarios as usuarios ON vendedores.id_vendedor = usuarios.id_perfil 
  INNER JOIN tbl_empresa as empresa ON vendedores.id_empresa_fk=empresa.id_empresa
  WHERE  usuarios.id_tipo_usuario_fk=2 and vendedores.id_empresa_fk=empresa.id_empresa ORDER BY id_vendedor ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarVendedor($nombre, $apellidos, $ganancia, $id_empresa_fk, $estatus, $idvendedor, $telefono)
  {
    $sql = "UPDATE tbl_vendedor SET nombre='{$nombre}',
  apellidos='{$apellidos}',
  telefono='{$telefono}',
  porcentaje_ganancia='{$ganancia}',
  id_empresa_fk='{$id_empresa_fk}',
  estatus='{$estatus}' 
  WHERE id_vendedor='{$idvendedor}'";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ActualizarUsuario($usuario, $contra, $estatus)
  {
    $sql = "UPDATE tbl_usuarios SET contra='{$contra}',
  estatus='{$estatus}' 
  WHERE usuario='{$usuario}' and id_tipo_usuario_fk=2";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }
  // actualizacion 20 febrero
  function BuscarVenta($empresa, $fecha)
  {
    $sql = "SELECT venta.* ,
  (Select Pago from tbl_tipo_pago WHERE id_tipo_pago=venta.id_tipo_pago_fk) as tipopago,
  (select nacionalidad from tbl_tipo_moneda where id_moneda=venta.id_moneda_fk) as moneda,
  (select nombre from tbl_vendedor where id_vendedor=venta.id_asignador) as asignadornom,
   empresa.nombre as empresanom,
   chofer.nombre as chofernom,
    vendedor.nombre as vendedornom 
     FROM tbl_ventas as venta 
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_empresa_fk={$empresa} and venta.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function BuscarVentaTicket($ticket)
  {
    $sql = "SELECT venta.* ,
  (Select Pago from tbl_tipo_pago WHERE id_tipo_pago=venta.id_tipo_pago_fk) as tipopago,
  (select nacionalidad from tbl_tipo_moneda where id_moneda=venta.id_moneda_fk) as moneda,
  (select nombre from tbl_vendedor where id_vendedor=venta.id_asignador) as asignadornom,
   empresa.nombre as empresanom,
   chofer.nombre as chofernom,
    vendedor.nombre as vendedornom 
     FROM tbl_ventas as venta 
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_ventas={$ticket} ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function BuscarVentaTicketFecha($ticket,$fecha)
  {
    $sql = "SELECT venta.* ,
  (Select Pago from tbl_tipo_pago WHERE id_tipo_pago=venta.id_tipo_pago_fk) as tipopago,
  (select nacionalidad from tbl_tipo_moneda where id_moneda=venta.id_moneda_fk) as moneda,
  (select nombre from tbl_vendedor where id_vendedor=venta.id_asignador) as asignadornom,
   empresa.nombre as empresanom,
   chofer.nombre as chofernom,
    vendedor.nombre as vendedornom 
     FROM tbl_ventas as venta 
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_ventas={$ticket} and venta.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  //actualizaicon 20 de febrero
  function BuscarVentasActual($fecha)
  {
    $sql = "SELECT venta.* ,
  (Select Pago from tbl_tipo_pago WHERE id_tipo_pago=venta.id_tipo_pago_fk) as tipopago,
  (select nacionalidad from tbl_tipo_moneda where id_moneda=venta.id_moneda_fk) as moneda,
  (select nombre from tbl_vendedor where id_vendedor=venta.id_asignador) as asignadornom,
   empresa.nombre as empresanom, 
   chofer.nombre as chofernom, 
   vendedor.nombre as vendedornom
 
   FROM tbl_ventas as venta 
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.numero_empleado 
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  
  WHERE   venta.fecha_venta BETWEEN '{$fecha} 00:00:00' AND '{$fecha} 23:59:59' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }




  function ReporteVentaEmpresa($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* ,
 empresa.nombre as empresanom, 
 punto.punto_venta as nompunto, 
 chofer.nombre as chofernom, 
 unidad.NumUnidad as NumUnidad,
 cliente.nombre as clientenom,
 pago.Pago as tipopago, 
 vendedor.nombre as vendedornom,
 (select cambio.valor from tbl_tipo_cambio as cambio) as cambio
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer 
  INNER JOIN tbl_tipo_pago as pago ON venta.id_tipo_pago_fk=pago.id_tipo_pago
  INNER JOIN tbl_punto_venta as punto ON venta.punto_venta = punto.id_punto_venta 
   INNER JOIN tbl_unidad as unidad ON venta.id_unidad_fk = unidad.NumUnidad  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  INNER JOIN tbl_clientes as cliente ON venta.id_cliente_fk=cliente.id_cliente
  WHERE  venta.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and  venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferes($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.id_chofer_fk as idchofer,
  venta.* , 
  empresa.nombre as empresachofernom,
  chofer.nombre as chofernom, 
  pago.Pago as tipopago,
  unidad.NumUnidad as NumUnidad, 
  chofer.numero_empleado as numempleado,
  vendedor.nombre as vendedornom,
  (select cambio.valor from tbl_tipo_cambio as cambio) as cambio
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_tipo_pago as pago ON venta.id_tipo_pago_fk=pago.id_tipo_pago
  INNER JOIN tbl_unidad as unidad ON venta.id_unidad_fk = unidad.NumUnidad  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChofer($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT venta.* , empresa.nombre as empresachofernom, chofer.nombre as chofernom, chofer.numero_empleado as numempleado,vendedor.nombre as vendedornom,
  (select cambio.valor from tbl_tipo_cambio as cambio) as cambio
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and  venta.id_chofer_fk={$chofer}  and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }

  function ReporteVentaChoferesGanancia($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  
  SUM(venta.totalMXN) as sumatotal,
  SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia ,
  empresa.nombre as empresanom, 
  chofer.nombre as chofernom,
  COUNT(venta.id_ventas) as cantidadTicket,
  COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  chofer.numero_empleado as numempleado,
  chofer.porcentaje_ganancia as choferganancia,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_chofer_fk={$chofer}   and  venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferesGanancia1($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  
  SUM(venta.total) as sumatotal,
  SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia ,
  empresa.nombre as empresanom, 
  chofer.nombre as chofernom,
  chofer.numero_empleado as numempleado,
  chofer.porcentaje_ganancia as choferganancia,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and  venta.id_chofer_fk={$chofer} and venta.id_moneda_fk=2  and  venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferesGanancia2($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  
  SUM(venta.total) as sumatotal,
  SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia ,
  empresa.nombre as empresanom, 
  chofer.nombre as chofernom,
  chofer.numero_empleado as numempleado,
  chofer.porcentaje_ganancia as choferganancia,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_chofer_fk={$chofer} and venta.id_moneda_fk=1  and  venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferGanancia($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia  ,
  empresa.nombre as empresanom,
   chofer.nombre as chofernom, 
   chofer.numero_empleado as numempleado,
   chofer.porcentaje_ganancia as choferganancia,
   (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_chofer_fk={$chofer} and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferGanancia1($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  SUM(venta.total) as sumatotal,
   SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia  ,
   empresa.nombre as empresanom, 
   chofer.nombre as chofernom, 
   chofer.numero_empleado as numempleado,
   chofer.porcentaje_ganancia as choferganancia,
   (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_chofer_fk={$chofer} and venta.id_moneda_fk=2 and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaChoferGanancia2($empresa, $fechainicio, $fechafinal, $chofer)
  {
    $sql = "SELECT  SUM(venta.total) as sumatotal,
   SUM(venta.total)/100 *(chofer.porcentaje_ganancia) as totalganancia  ,
   empresa.nombre as empresanom, 
   chofer.nombre as chofernom, 
   chofer.numero_empleado as numempleado,
   chofer.porcentaje_ganancia as choferganancia,
   (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_chofer_fk={$chofer} and venta.id_moneda_fk=1 and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedores($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
  empresa.nombre as empresanom, 
  vendedor.nombre as vendedornom, 
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
  pago.Pago as tipopago,
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_tipo_pago as pago ON venta.id_tipo_pago_fk=pago.id_tipo_pago
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorGanancia($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia   ,
  empresa.nombre as empresanom,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorBandera($vendedorid, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
   COUNT(venta.id_ventas) as cantidadTicket,
   COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(tbl_punto_venta.porcentaje) as totalganancia  ,
  empresa.nombre as empresanom,
  tbl_punto_venta.porcentaje as comision,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
   INNER JOIN tbl_punto_venta as tbl_punto_venta ON venta.punto_venta=tbl_punto_venta.id_punto_venta
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_vendedor_fk={$vendedorid} and venta.punto_venta=2 and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorRampa($vendedorid, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
   COUNT(venta.id_ventas) as cantidadTicket,
   COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia,
  empresa.nombre as empresanom,
  tbl_punto_venta.porcentaje as comision,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
   INNER JOIN tbl_punto_venta as tbl_punto_venta ON venta.punto_venta=tbl_punto_venta.id_punto_venta
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_vendedor_fk={$vendedorid} and venta.punto_venta=3 and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorVelador($vendedorid, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
   COUNT(venta.id_ventas) as cantidadTicket,
   COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia   ,
  empresa.nombre as empresanom,
  tbl_punto_venta.porcentaje as comision,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
   INNER JOIN tbl_punto_venta as tbl_punto_venta ON venta.punto_venta=tbl_punto_venta.id_punto_venta
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_vendedor_fk={$vendedorid} and venta.punto_venta=4 and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorM5($vendedorid, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
   COUNT(venta.id_ventas) as cantidadTicket,
   COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  SUM(venta.totalMXN) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia   ,
  empresa.nombre as empresanom,
  tbl_punto_venta.porcentaje as comision,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
   INNER JOIN tbl_punto_venta as tbl_punto_venta ON venta.punto_venta=tbl_punto_venta.id_punto_venta
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_vendedor_fk={$vendedorid} and venta.punto_venta=1 and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function TodosVendedoresReporte($fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.*, vendedor.*
  FROM tbl_ventas as venta
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
   WHERE venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }





  function ReporteVentaVendedorGanancia1($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
  SUM(venta.total) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia   ,
  empresa.nombre as empresanom,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_moneda_fk=2 and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaVendedorGanancia2($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.* , 
  SUM(venta.total) as sumatotal, 
  SUM(venta.total)/100 *(vendedor.porcentaje_ganancia) as totalganancia   ,
  empresa.nombre as empresanom,
  vendedor.nombre as vendedornom,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,  
  vendedor.porcentaje_ganancia as vendedorganancia
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  venta.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_moneda_fk=1 and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY id_vendedor_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaUnidades($empresa, $fechainicio, $fechafinal)
  {
    $sql = "SELECT venta.id_chofer_fk as idchofer,
  venta.* , 
  empresa.nombre as empresachofernom,
  chofer.nombre as chofernom, 
  unidad.NumUnidad as NumUnidad, 
  chofer.numero_empleado as numempleado,
  vendedor.nombre as vendedornom,
  (select cambio.valor from tbl_tipo_cambio as cambio) as cambio
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.numero_empleado  
  INNER JOIN tbl_unidad as unidad ON venta.id_unidad_fk = unidad.NumUnidad  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  chofer.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' ORDER BY id_ventas ASC ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }
  function ReporteVentaUnidadesGanancia($empresa, $fechainicio, $fechafinal, $unidad)
  {
    $sql = "SELECT  
  SUM(venta.totalMXN) as sumatotal,
  SUM(venta.totalMXN)/100 *(chofer.porcentaje_ganancia) as totalganancia ,
  empresa.nombre as empresanom, 
  unidad.Placas as placas,
  COUNT(venta.id_ventas) as cantidadTicket,
  COUNT(DISTINCT DATE(venta.fecha_venta)) AS dias_con_ventas,
  unidad.NumUnidad as numunidad,
  chofer.porcentaje_ganancia as choferganancia,
  (SELECT valor FROM tbl_tipo_cambio) as tipocambio,
   (SELECT nombre  FROM tbl_empresa as empresainto WHERE empresainto.id_empresa=chofer.id_empresa_fk  ) as empresachofernom,vendedor.nombre as vendedornom
  FROM tbl_ventas as venta
  INNER JOIN tbl_chofer as chofer ON venta.id_chofer_fk = chofer.id_chofer  
  INNER JOIN tbl_unidad as unidad ON venta.id_unidad_fk = unidad.NumUnidad  
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  INNER JOIN tbl_vendedor as vendedor ON venta.id_vendedor_fk=vendedor.id_vendedor
  WHERE  unidad.id_empresa_fk={$empresa} and venta.estatus='VENDIDO' and venta.id_unidad_fk={$unidad}   and  venta.fecha_venta BETWEEN '{$fechainicio}' AND '{$fechafinal}' GROUP BY venta.id_empresa_fk
  ";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }







  function ActualizarCambio($cantidad)
  {
    $sql = "UPDATE tbl_tipo_cambio SET valor={$cantidad}
  WHERE id_cambio=1";
    $query = $this->db->query($sql);

    if ($query) {
      return $query;
    }
    else {
      return false;
    }
  }

  function TipoCambio()
  {
    $sql = "SELECT valor FROM tbl_tipo_cambio 
  WHERE id_cambio=1";
    $query = $this->db->query($sql);

    if ($query->getresultArray()) {
      return $query;
    }
    else {
      return false;
    }
  }



}



?>