<?php


namespace App\Models;

use CodeIgniter\Model;

class Model_Facturel extends Model
{
    function __construct(){
		parent::__construct();
		$this->db= \Config\Database::connect();
	}

   


function BuscarTicket($ticket,$fecha,$monto)
{
  $sql = "SELECT * FROM tbl_ventas WHERE numero_ticket='{$ticket}' AND fecha_venta='{$fecha}' AND totalMXN='{$monto} 'AND estatus='VENDIDO' AND factura='NO'";
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
function BuscarTicketID($ticket)
{
  $sql = "SELECT * FROM tbl_ventas WHERE numero_ticket='{$ticket}' AND estatus='VENDIDO' AND factura='NO'";
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
function TicketFacturado($ticket,$fecha,$monto)
{
  $sql = "SELECT * FROM tbl_ventas WHERE numero_ticket='{$ticket}' AND fecha_venta='{$fecha}' AND totalMXN='{$monto} 'AND estatus='VENDIDO' AND factura='SI'";
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
function ActualizarTicketFactura($ticket)
{
  $sql = "UPDATE tbl_ventas SET factura='SI' WHERE numero_ticket='{$ticket}'";
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
