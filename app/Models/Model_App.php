<?php


namespace App\Models;

use CodeIgniter\Model;

class Model_App extends Model
{
    function __construct(){
		parent::__construct();
		$this->db= \Config\Database::connect();
	}

    function login($user,$pass){
        $sql = "SELECT * FROM tbl_usuarios WHERE usuario='{$user}' AND contra='{$pass}' AND estatus='ACTIVADO'";
		    $query= $this->db->query($sql);
        
         if($query->getresultArray())
		   {
		     return $query;
		   }
		else
		   {
		     return false;
		   }
	}
  function DatosUsuario($user){
    $sql = "SELECT id_tipo_usuario_fk,id_perfil FROM tbl_usuarios WHERE usuario='{$user}'";
    $query= $this->db->query($sql);
    
     if($query->getresultArray())
   {
     return $query;
   }
  else
   {
     return false;
   }
}





function TodosChofer(){
  $sql = "SELECT chofer.* , 
  empresa.nombre as empresanom,
  socio.nombre as socionom ,
  unidad.Marca as unidadmarca,
  unidad.Modelo as unidadmodelo,
  unidad.Placas as unidadplacas,
  unidad.NumUnidad as numunidad 
  FROM tbl_chofer as chofer 
  INNER JOIN tbl_empresa as empresa ON chofer.id_empresa_fk = empresa.id_empresa 
  INNER JOIN tbl_socios as socio ON chofer.id_socio_fk = socio.id_socios 
  INNER JOIN tbl_unidad as unidad ON chofer.id_unidad_fk = unidad.Id_unidad 
  WHERE chofer.id_empresa_fk=empresa.id_empresa AND chofer.estatus='ACTIVADO'
  ORDER BY chofer.numero_empleado ASC ";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}

function TodasUnidades(){
  $sql = "SELECT * FROM tbl_unidad";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
    
}

function DatosVendedor($id)
{
  $sql = "SELECT * FROM tbl_vendedor WHERE id_vendedor='{$id}'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}
function InsertarVenta($destino,$descripcion,$id_vendedor,$id_empresa,$id_chofer,$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$pasajero,$punto_venta,$num_unidad)
{
  $sql = "INSERT INTO tbl_ventas (destino,descripcion,id_vendedor_fk,id_chofer_fk,id_empresa_fk,total,totalMXN,id_tipo_pago_fk,id_tipo_tarjeta_fk,id_moneda_fk,fecha_venta,NumPasajero,punto_venta,id_unidad_fk) 
  VALUES ('{$destino}','{$descripcion}','{$id_vendedor}','{$id_chofer}','{$id_empresa}','{$total}','{$totalMXN}','{$id_tipo_pago}','{$id_tipo_tarjeta}','{$id_moneda}','{$fecha_venta}','{$pasajero}','{$punto_venta}','{$num_unidad}')";
  $query= $this->db->query($sql);
  
  if($query) 
  {
    return $query;
  }
  else
  {
    return false;
  }

}
function BuscarVenta($fecha_venta,$idempresa)
{
  $sql = "SELECT venta.*,
  (select empresa.NombreCompleto from tbl_empresa as empresa where id_empresa='{$idempresa}') as nomemp,
  (select empresa.Direccion from tbl_empresa as empresa where id_empresa='{$idempresa}') as direcemp,
  (select empresa.RFC from tbl_empresa as empresa where id_empresa='{$idempresa}') as rfcemp,
  (select empresa.Telefono from tbl_empresa as empresa where id_empresa='{$idempresa}') as telefono
   FROM tbl_ventas as venta WHERE fecha_venta='{$fecha_venta}'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}

function InsertarNoTicket($ticket,$id_venta)
{
  $sql = "UPDATE tbl_ventas SET numero_ticket='{$ticket}'
  WHERE id_ventas='{$id_venta}'";
  $query= $this->db->query($sql);
  
  if($query) 
  {
    return $query;
  }
  else
  {
    return false;
  }


}
function BuscarTicketSinChofer($ticket)
{
  $sql = "SELECT venta.*,
  empresa.NombreCompleto as nomem,
  empresa.Direccion as direcem,
  empresa.RFC as rfcem,
  empresa.Telefono as telefono
  FROM tbl_ventas as venta
  INNER JOIN tbl_empresa as empresa ON venta.id_empresa_fk=empresa.id_empresa
  WHERE numero_ticket='{$ticket}' AND id_chofer_fk=0";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}
//actualizacion 20 febrero
function ActualizarChofer2($idchofer,$ticket,$asignador,$fecha)
{
  $sql = "UPDATE tbl_ventas SET id_chofer_fk='{$idchofer}', id_asignador='{$asignador}', Hora_asignado='{$fecha}'
  WHERE numero_ticket='{$ticket}'";
  $query= $this->db->query($sql);
  
  if($query) 
  {
    return $query;
  }
  else
  {
    return false;
  }

}

function ActualizarChofer($idchofer,$ticket)
{
  $sql = "UPDATE tbl_ventas SET id_chofer_fk='{$idchofer}'
  WHERE numero_ticket='{$ticket}'";
  $query= $this->db->query($sql);
  
  if($query) 
  {
    return $query;
  }
  else
  {
    return false;
  }

}

function CorteCajaVendedorDetallado($id_user,$fecha_inicial,$fecha_final)
{
  $sql = "SELECT tbl_ventas.numero_ticket,tbl_ventas.destino,tbl_tipo_pago.Pago,tbl_tipo_moneda.nacionalidad,tbl_ventas.total,tbl_ventas.totalMXN,
  (SELECT CONCAT(nombre,apellidos) FROM tbl_vendedor WHERE id_vendedor='{$id_user}') as NombreVendedor,
  (SELECT (SELECT nombre FROM tbl_empresa WHERE id_empresa=tbl_vendedor.id_empresa_fk) FROM tbl_vendedor WHERE id_vendedor='{$id_user}') as NombreEmpresa
  FROM tbl_ventas
  INNER JOIN tbl_tipo_pago ON tbl_tipo_pago.id_tipo_pago = tbl_ventas.id_tipo_pago_fk
  INNER JOIN tbl_tipo_moneda ON tbl_tipo_moneda.id_moneda =  tbl_ventas.id_moneda_fk
  WHERE tbl_ventas.estatus='VENDIDO' and tbl_ventas.id_vendedor_fk='{$id_user}' AND  fecha_venta BETWEEN '{$fecha_inicial}' AND '{$fecha_final}'";

  $query= $this->db->query($sql);
  
  return $query->getResult();
}

function CorteCajaVendedor($id_user,$fecha_inicial,$fecha_final)
{
  $sql = "SELECT COUNT(ventas.id_ventas) as CantidadVentas,
  SUM(ventas.total) as CantidadTotal,
  (SELECT nombre FROM tbl_vendedor WHERE id_vendedor='{$id_user}') as NombreVendedor,
  (SELECT apellidos FROM tbl_vendedor WHERE id_vendedor='{$id_user}') as ApellidosVendedor,
  (SELECT (SELECT nombre FROM tbl_empresa WHERE id_empresa=tbl_vendedor.id_empresa_fk)  FROM tbl_vendedor WHERE id_vendedor='{$id_user}') as NombreEmpresa,
  (SELECT SUM(total) FROM tbl_ventas WHERE estatus='VENDIDO' and id_vendedor_fk='{$id_user}' AND id_tipo_pago_fk=1 AND id_moneda_fk=1 AND  fecha_venta BETWEEN '{$fecha_inicial}' AND '{$fecha_final}') as CantidadEfectivoP,
  (SELECT SUM(total) FROM tbl_ventas WHERE estatus='VENDIDO' and id_vendedor_fk='{$id_user}' AND id_tipo_pago_fk=1 AND id_moneda_fk=2 AND  fecha_venta BETWEEN '{$fecha_inicial}' AND '{$fecha_final}') as CantidadEfectivoD,
  (SELECT SUM(total) FROM tbl_ventas WHERE estatus='VENDIDO' and id_vendedor_fk='{$id_user}' AND id_tipo_pago_fk=2 AND  fecha_venta BETWEEN '{$fecha_inicial}' AND '{$fecha_final}') as CantidadVoucher
  FROM tbl_ventas as ventas WHERE ventas.estatus='VENDIDO' and id_vendedor_fk='{$id_user}' AND  fecha_venta BETWEEN '{$fecha_inicial}' AND '{$fecha_final}'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}

function cancelar($ticket,$motivo)
{
  $sql = "UPDATE tbl_ventas SET estatus='CANCELADO', motivo_cancelado='{$motivo}'
  WHERE numero_ticket='{$ticket}'";
  $query= $this->db->query($sql);
  
  if($query->getresultArray()) 
  {
    return $query;
  }
  else
  {
    return false;
  }


}
function BuscarTicket($ticket,$vendedor)
{
  $sql = "SELECT *
  FROM tbl_ventas
  WHERE numero_ticket='{$ticket}' AND id_vendedor_fk='{$vendedor}'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}
function TipoCambio(){
  $sql = "SELECT valor FROM tbl_tipo_cambio 
  WHERE id_cambio=1";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}
function Ventarepetida($ticket)
{
  $sql = "SELECT *
  FROM tbl_ventas
  WHERE  id_ventas='{$ticket}'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}
function ultimaventa($vendedor)
{
  $sql = "SELECT MAX(id_ventas) as ultima
  FROM tbl_ventas
  WHERE id_vendedor_fk='{$vendedor}' AND estatus='VENDIDO'";
  $query= $this->db->query($sql);
  
   if($query->getresultArray())
 {
   return $query;
 }
else
 {
   return false;
 }
}



}



?>
