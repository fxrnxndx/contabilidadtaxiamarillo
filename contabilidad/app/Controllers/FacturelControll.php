<?php namespace App\Controllers;

use CodeIgniter\Model\Model_Facturel;


/*
require '../TaxiContabilidad/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
*/

class FacturelControll extends BaseController
{
	
    function __construct(){
		
		$this->session=session();
		//$this->load->model('Model_home');
		$this->model = new \App\Models\Model_Facturel();


	}
   
    
	

	public function Tickets()
	{
	
		$ticket=$_GET['ticket'];
		$fecha=$_GET['fecha'];
		$monto=$_GET['monto'];
		$BuscarTicket = array(
			'BuscarTicket' => $this-> model-> BuscarTicket($ticket,$fecha,$monto)
			);
		
		if ($BuscarTicket['BuscarTicket']!=false) {
			return "SI";
		}
		else
		{
			return "NO";
		}
		


	}
	public function TicketPorID()
	{
	
		$ticket=$_GET['ticket'];
		$BuscarTicket = array(
			'BuscarTicket' => $this-> model-> BuscarTicketID($ticket)
			);
		
		if ($BuscarTicket['BuscarTicket']!=false) {
			return "SI";
		}
		else
		{
			return "NO";
		}
		

	}
	public function TicketsFacturado()
	{
	
		$ticket=$_GET['ticket'];
		$fecha=$_GET['fecha'];
		$monto=$_GET['monto'];
		$TicketFacturado = array(
			'TicketFacturado' => $this-> model-> TicketFacturado($ticket,$fecha,$monto)
			);
		
		if ($TicketFacturado['TicketFacturado']!=false) {
			return "SI";
		}
		else
		{
			return "NO";
		}
		


	}
	public function ConfirmaFactura()
	{
		$ticket=$_GET['ticket'];
		$ActualizarTicketFactura = array(
			'ActualizarTicketFactura' => $this-> model-> ActualizarTicketFactura($ticket)
			);
		return "SI";
		/*if ($ActualizarTicketFactura['ActualizarTicketFactura']!=false) {
			return "SI";
		}
		else
		{
			return "NO";
		}*/

	}



	
	public function logout()
	{
		$this->session->remove('usuario');
		$data = [
			'notificacion' => 'false'
		];
		return view('login',$data);
	}

	//--------------------------------------------------------------------

}