<?php namespace App\Controllers;

use CodeIgniter\Model\Model_App;


/*
require '../TaxiContabilidad/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
*/

class AppControll extends BaseController
{
	
    function __construct(){
		
		$this->session=session();
		//$this->load->model('Model_home');
		$this->model = new \App\Models\Model_App();


	}
   
    
	public function login()
	{
		$usuario=$_GET['correo'];
		$contra=$_GET['pass'];
		$idperfil="";
        $tipoperfil="";
		/* obtener choferes */
		$resultado="";
		
		$TodosChofer = array(
			'TodosChofer' => $this->model-> TodosChofer()
			);
		
		foreach ($TodosChofer['TodosChofer'] ->getResult() as $row) { 
				$resultado.="{$row->numero_empleado}'-'{$row->nombre}' '{$row->apellidos}'-'{$row->empresanom}.','";
		   /* if($resultado=="")
			{
				$resultado=$row->nombre.' '.$row->apellidos.'-'.$row->empresanom;
			}
			else
			{
				$resultado=$row->nombre.' '.$row->apellidos.'-'.$row->empresanom.','.$resultado;
			}	*/	
			
		}
		
		/* fin choferes */

		$data = array(
			'perfiles' => $this-> model-> login($usuario,$contra)
			);

		if ($data['perfiles']==false) {
			
				return "0";
		}else
		{
			foreach ($data['perfiles'] ->getResult() as $row) { 
				
				$this->session->set('usuario',$row->usuario);
			  }
			  $data = array(
				'DatosUsuario' => $this-> model-> DatosUsuario($_SESSION['usuario'])
				);
			 foreach ($data['DatosUsuario'] ->getResult() as $row) { 
				
					$tipoperfil=$row->id_tipo_usuario_fk;
					$idperfil=$row->id_perfil;
				}
			if($tipoperfil=="2")
			{
				return $idperfil."*".$resultado;
			}
			else{
				return "9";
			}	  	


		}

		
		
	}

	public function choferes()
	{
		$resultado="";
		
		$TodosChofer = array(
			'TodosChofer' => $this-> model-> TodosChofer()
			);
		
		foreach ($TodosChofer['TodosChofer'] ->getResult() as $row) { 
			$resultado.="{$row->numero_empleado}-{$row->nombre} {$row->apellidos}-{$row->empresanom}.,";
		   /* if($resultado=="")
			{
				$resultado=$row->nombre.' '.$row->apellidos.'-'.$row->empresanom;
			}
			else
			{
				$resultado=$row->nombre.' '.$row->apellidos.'-'.$row->empresanom.','.$resultado;
			}	*/	
			
		}
		return $resultado;


	}

	public function venta()
	{
		date_default_timezone_set('America/Tijuana');
		$chofer=$_GET['chofer'];
		$destino=$_GET['destino'];
		$descripcion=$_GET['descripcion'];
		$total=$_GET['total'];
		$id_moneda=$_GET['id_moneda'];
		$id_tipo_pago=$_GET['id_tipo_pago'];
		$id_tipo_tarjeta=$_GET['id_tipo_tarjeta'];
		$id_usuario=$_GET['id_usuario'];
		$keytime=$_GET['keytime'];
        $id_empresa="";
		if($chofer==""){
			$id_chofer=explode("-", "0- ");
		}else
		{ 	$id_chofer=explode("-", $chofer);
			$nombre_chofer=$id_chofer[1];
			
			
		}
		//$id_chofer=explode("-", $chofer);
		//$nombre_chofer=$id_chofer[1];
		$nombre_vendedor="";
		$fecha_venta=date("Y-m-d H:i:s");
        $ticket="";
		$id_venta="";
		$cabeza="";
		$correo="";
		$tipocambio="";
		$totalMXN=$_GET['total'];
        $ticektTotal="\nTotal: $".$total;
		$nom_tipo_pago="";
		$nom_moneda="Pesos MXN";
		$nom_tipo_tarjeta="";
		$nom_empresa="";
		$idmaxventa="";
		$idchoferticket="";
		$fechaticket="";
		$timepotranscurido="";
		$primerafecha="";
		$segundafecha="";



		$ultimaventa = array(
			'ultimaventa' => $this-> model-> ultimaventa($id_usuario)
			);
			foreach ($ultimaventa['ultimaventa'] ->getResult() as $row) { 
				$idmaxventa=$row->ultima;
			
			}
			
		if($idmaxventa!=false)
			{
				foreach ($ultimaventa['ultimaventa'] ->getResult() as $row) { 
					$idmaxventa=$row->ultima;
				
				}
			
				$Ventarepetida = array(
					'Ventarepetida' => $this-> model-> Ventarepetida($idmaxventa)
					);
                 
				if($Ventarepetida['Ventarepetida']!=false)
				{
					foreach ($Ventarepetida['Ventarepetida'] ->getResult() as $row) { 
						$idchoferticket=$row->id_chofer_fk;
						$fechaticket=$row->fecha_venta;
						$idvendedorticket=$row->id_vendedor_fk;
						$destinoticket=$row->destino;
					
					}
					$primerafecha=strtotime($fecha_venta);
					$segundafecha=strtotime($fechaticket);
					$timepotranscurido=$primerafecha-$segundafecha;
					if($id_chofer[0]==$idchoferticket && $timepotranscurido<=180 && $idvendedorticket==$id_usuario && $destinoticket==$destino)
					{
						
					}
					else
					{ // cuando el ticekt no se repite
						$DatosTipoCambio = array(
							'DatosTipoCambio' => $this-> model-> TipoCambio()
							);
						foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
							$tipocambio=$row->valor;
						
						}
						//si pagan en dolares convertimos a pesos
			
						if($id_moneda==2)
						{
							$totalMXN=$total*$tipocambio;
							$ticektTotal="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
							$nom_moneda="Dolares USA";
			
						}
					
			
						$DatosVendedor = array(
							'DatosVendedor' => $this-> model-> DatosVendedor($id_usuario)
							);
						foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
							$id_empresa=$row->id_empresa_fk;
							$nombre_vendedor=$row->nombre;
						
						}
						//insertamos nueva venta
						$this->model->InsertarVenta($destino,$descripcion,$id_usuario,$id_empresa,$id_chofer[0],$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$keytime);
						//Extraemos el id de la venta
						$DatosVenta = array(
							'DatosVenta' => $this-> model-> BuscarVenta($fecha_venta,$id_empresa)
							);
						foreach ($DatosVenta['DatosVenta'] ->getResult() as $row) { 
							$id_venta=$row->id_ventas;
							$cabeza=$row->nomemp."\n".$row->direcemp."\nRFC: ".$row->rfcemp."\nTel: ".$row->telefono;
						}
						//Creamos el ticket
						if($id_empresa==1){
							   $ticket=$id_venta;
							  $correo="taxitte1998@gmail.com";
							  $nom_empresa="TTE";
						}
						else if($id_empresa==2)
						{
							$ticket=$id_venta;
							$correo="saatb1990@gmail.com";
							$nom_empresa="SAAT";
						}
						//Tipo de pago
						if($id_tipo_pago==1)
						{
						   $nom_tipo_pago="EFECTIVO";
						}
						else if($id_tipo_pago==2)
						{
							$nom_tipo_pago="VOUCHER";
						}
						//Tipo tarjeta
						if($id_tipo_tarjeta==1)
						{
							   $nom_tipo_tarjeta="DEBITO";
						}
						else if($id_tipo_tarjeta==2)
						{
							$nom_tipo_tarjeta="CREDITO";
						}
						else if($id_tipo_tarjeta==0)
						{
							$nom_tipo_tarjeta="/";
						}
				
					
			
						//INSERTAMOS EL TICKET
						$this->model->InsertarNoTicket($ticket,$id_venta);
			
						//REGRESAR TICKET LISTO PARA IMPRIMIR
						return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
						.$ticektTotal
						."\nTipo pago: ".$nom_tipo_pago
						."\nTipo moneda: ".$nom_moneda
						."\nTipo tarjeta: ".$nom_tipo_tarjeta
						."\nVendedor: ".$nombre_vendedor."\nChofer: ".$nombre_chofer."\nEmpresa: ".$nom_empresa
						."\nFecha: ".$fecha_venta."\n================================\n"
						."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/O MANDAR UN CORREO A"."\n".$correo."\nSOLICITAR SU FACTURA DENTRO DE LOS 10 DIAS HABILES DESPUES DE SU COMPRA Y RECIBIRA SU FACTURA EN UN LAPSO "."DE 24 A 48 HRS MINIMO"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";
			
					}
				}
					

			}
		else //cuando es la primera venta del vendedor
		{		$DatosTipoCambio = array(
				'DatosTipoCambio' => $this-> model-> TipoCambio()
				);
			foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
				$tipocambio=$row->valor;
		
			}
			//si pagan en dolares convertimos a pesos

			if($id_moneda==2)
			{
				$totalMXN=$total*$tipocambio;
				$ticektTotal="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
				$nom_moneda="Dolares USA";

			}
	

			$DatosVendedor = array(
				'DatosVendedor' => $this-> model-> DatosVendedor($id_usuario)
			);
			foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
				$id_empresa=$row->id_empresa_fk;
				$nombre_vendedor=$row->nombre;
		
			}
			//insertamos nueva venta
			$this->model->InsertarVenta($destino,$descripcion,$id_usuario,$id_empresa,$id_chofer[0],$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$keytime);
			//Extraemos el id de la venta
			$DatosVenta = array(
				'DatosVenta' => $this-> model-> BuscarVenta($fecha_venta,$id_empresa)
				);
			foreach ($DatosVenta['DatosVenta'] ->getResult() as $row) { 
				$id_venta=$row->id_ventas;
				$cabeza=$row->nomemp."\n".$row->direcemp."\nRFC: ".$row->rfcemp."\nTel: ".$row->telefono;
			}
			//Creamos el ticket
			if($id_empresa==1){
				   $ticket=$id_venta;
			  	$correo="taxitte1998@gmail.com";
			  	$nom_empresa="TTE";
			}
			else if($id_empresa==2)
			{
				$ticket=$id_venta;
				$correo="saatb1990@gmail.com";
				$nom_empresa="SAAT";
			}
			//Tipo de pago
			if($id_tipo_pago==1)
			{
		   	$nom_tipo_pago="EFECTIVO";
			}
			else if($id_tipo_pago==2)
			{
				$nom_tipo_pago="VOUCHER";
			}
			//Tipo tarjeta
			if($id_tipo_tarjeta==1)
			{
			   $nom_tipo_tarjeta="DEBITO";
			}
			else if($id_tipo_tarjeta==2)
			{
				$nom_tipo_tarjeta="CREDITO";
			}
			else if($id_tipo_tarjeta==0)
			{
				$nom_tipo_tarjeta="/";
			}

	

			//INSERTAMOS EL TICKET
			$this->model->InsertarNoTicket($ticket,$id_venta);

			//REGRESAR TICKET LISTO PARA IMPRIMIR
			return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
			.$ticektTotal
			."\nTipo pago: ".$nom_tipo_pago
			."\nTipo moneda: ".$nom_moneda
			."\nTipo tarjeta: ".$nom_tipo_tarjeta
			."\nVendedor: ".$nombre_vendedor."\nChofer: ".$nombre_chofer."\nEmpresa: ".$nom_empresa
			."\nFecha: ".$fecha_venta."\n================================\n"
			."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/O MANDAR UN CORREO A"."\n".$correo."\nSOLICITAR SU FACTURA DENTRO DE LOS 10 DIAS HABILES DESPUES DE SU COMPRA Y RECIBIRA SU FACTURA EN UN LAPSO "."DE 24 A 48 HRS MINIMO"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";





		}



	


	  
           /*
			$DatosTipoCambio = array(
				'DatosTipoCambio' => $this-> model-> TipoCambio()
				);
			foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
				$tipocambio=$row->valor;
			
			}
			//si pagan en dolares convertimos a pesos

			if($id_moneda==2)
			{
				$totalMXN=$total*$tipocambio;
				$ticektTotal="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
				$nom_moneda="Dolares USA";

			}
		

			$DatosVendedor = array(
				'DatosVendedor' => $this-> model-> DatosVendedor($id_usuario)
				);
			foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
				$id_empresa=$row->id_empresa_fk;
				$nombre_vendedor=$row->nombre;
			
			}
        	//insertamos nueva venta
			$this->model->InsertarVenta($destino,$descripcion,$id_usuario,$id_empresa,$id_chofer[0],$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$keytime);
			//Extraemos el id de la venta
			$DatosVenta = array(
				'DatosVenta' => $this-> model-> BuscarVenta($fecha_venta,$id_empresa)
				);
			foreach ($DatosVenta['DatosVenta'] ->getResult() as $row) { 
				$id_venta=$row->id_ventas;
				$cabeza=$row->nomemp."\n".$row->direcemp."\nRFC: ".$row->rfcemp."\nTel: ".$row->telefono;
			}
			//Creamos el ticket
        	if($id_empresa==1){
           		$ticket="TTE.".$id_venta;
		  		$correo="transportes.terrestre@hotmail.com";
		  		$nom_empresa="TTE";
			}
			else if($id_empresa==2)
			{
            	$ticket="SAAT.".$id_venta;
				$correo="saat-b@hotmail.com";
				$nom_empresa="SAAT";
			}
			//Tipo de pago
			if($id_tipo_pago==1)
			{
           	$nom_tipo_pago="EFECTIVO";
			}
			else if($id_tipo_pago==2)
			{
				$nom_tipo_pago="VOUCHER";
			}
			//Tipo tarjeta
			if($id_tipo_tarjeta==1)
			{
           		$nom_tipo_tarjeta="DEBITO";
			}
			else if($id_tipo_tarjeta==2)
			{
				$nom_tipo_tarjeta="CREDITO";
			}
			else if($id_tipo_tarjeta==0)
			{
				$nom_tipo_tarjeta="/";
			}
	
		

        	//INSERTAMOS EL TICKET
			$this->model->InsertarNoTicket($ticket,$id_venta);

			//REGRESAR TICKET LISTO PARA IMPRIMIR
			return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
			.$ticektTotal
			."\nTipo pago: ".$nom_tipo_pago
        	."\nTipo moneda: ".$nom_moneda
        	."\nTipo tarjeta: ".$nom_tipo_tarjeta
			."\nVendedor: ".$nombre_vendedor."\nChofer: ".$nombre_chofer."\nEmpresa: ".$nom_empresa
			."\nFecha: ".$fecha_venta."\n================================\n"
			."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/O MANDAR UN CORREO A"."\n".$correo."\nRECIBIRA SU FACTURA EN UN LAPSO "."DE 24 A 48 HRS MINIMO"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";

*/
		
	


	}
	//actualizado el 16 de julio 2024
	public function venta2()
	{
		date_default_timezone_set('America/Tijuana');
		$chofer=$_GET['chofer'];
		$destino=$_GET['destino'];
		$descripcion=$_GET['descripcion'];
		$total=$_GET['total'];
		$id_moneda=$_GET['id_moneda'];
		$id_tipo_pago=$_GET['id_tipo_pago'];
		$id_tipo_tarjeta=$_GET['id_tipo_tarjeta'];
		$id_usuario=$_GET['id_usuario'];
		$keytime=$_GET['keytime'];
		$pasajero=$_GET['pasajeros'];
        $id_empresa="";
		if($chofer==""){
			$id_chofer=explode("-", "0- ");
		}else
		{ 	$id_chofer=explode("-", $chofer);
			$nombre_chofer=$id_chofer[1];
			
			
		}
		//$id_chofer=explode("-", $chofer);
		//$nombre_chofer=$id_chofer[1];
		$nombre_vendedor="";
		$fecha_venta=date("Y-m-d H:i:s");
        $ticket="";
		$id_venta="";
		$cabeza="";
		$correo="";
		$tipocambio="";
		$totalMXN=$_GET['total'];
        $ticektTotal="\nTotal: $".$total;
		$nom_tipo_pago="";
		$nom_moneda="Pesos MXN";
		$nom_tipo_tarjeta="";
		$nom_empresa="";
		$idmaxventa="";
		$idchoferticket="";
		$fechaticket="";
		$timepotranscurido="";
		$primerafecha="";
		$segundafecha="";



		$ultimaventa = array(
			'ultimaventa' => $this-> model-> ultimaventa($id_usuario)
			);
			foreach ($ultimaventa['ultimaventa'] ->getResult() as $row) { 
				$idmaxventa=$row->ultima;
			
			}
			
		if($idmaxventa!=false)
			{
				foreach ($ultimaventa['ultimaventa'] ->getResult() as $row) { 
					$idmaxventa=$row->ultima;
				
				}
			
				$Ventarepetida = array(
					'Ventarepetida' => $this-> model-> Ventarepetida($idmaxventa)
					);
                 
				if($Ventarepetida['Ventarepetida']!=false)
				{
					foreach ($Ventarepetida['Ventarepetida'] ->getResult() as $row) { 
						$idchoferticket=$row->id_chofer_fk;
						$fechaticket=$row->fecha_venta;
						$idvendedorticket=$row->id_vendedor_fk;
						$destinoticket=$row->destino;
					
					}
					$primerafecha=strtotime($fecha_venta);
					$segundafecha=strtotime($fechaticket);
					$timepotranscurido=$primerafecha-$segundafecha;
					if($id_chofer[0]==$idchoferticket && $timepotranscurido<=180 && $idvendedorticket==$id_usuario && $destinoticket==$destino)
					{
						
					}
					else
					{ // cuando el ticekt no se repite
						$DatosTipoCambio = array(
							'DatosTipoCambio' => $this-> model-> TipoCambio()
							);
						foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
							$tipocambio=$row->valor;
						
						}
						//si pagan en dolares convertimos a pesos
			
						if($id_moneda==2)
						{
							$totalMXN=$total*$tipocambio;
							$ticektTotal="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
							$nom_moneda="Dolares USA";
			
						}
					
			
						$DatosVendedor = array(
							'DatosVendedor' => $this-> model-> DatosVendedor($id_usuario)
							);
						foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
							$id_empresa=$row->id_empresa_fk;
							$nombre_vendedor=$row->nombre;
						
						}
						//insertamos nueva venta
						$this->model->InsertarVenta($destino,$descripcion,$id_usuario,$id_empresa,$id_chofer[0],$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$keytime);
						//Extraemos el id de la venta
						$DatosVenta = array(
							'DatosVenta' => $this-> model-> BuscarVenta($fecha_venta,$id_empresa)
							);
						foreach ($DatosVenta['DatosVenta'] ->getResult() as $row) { 
							$id_venta=$row->id_ventas;
							$cabeza=$row->nomemp."\n".$row->direcemp."\nRFC: ".$row->rfcemp."\nTel: ".$row->telefono;
						}
						//Creamos el ticket
						if($id_empresa==1){
							   $ticket=$id_venta;
							  $correo="taxitte1998@gmail.com";
							  $nom_empresa="TTE";
						}
						else if($id_empresa==2)
						{
							$ticket=$id_venta;
							$correo="saatb1990@gmail.com";
							$nom_empresa="SAAT";
						}
						//Tipo de pago
						if($id_tipo_pago==1)
						{
						   $nom_tipo_pago="EFECTIVO";
						}
						else if($id_tipo_pago==2)
						{
							$nom_tipo_pago="VOUCHER";
						}
						//Tipo tarjeta
						if($id_tipo_tarjeta==1)
						{
							   $nom_tipo_tarjeta="DEBITO";
						}
						else if($id_tipo_tarjeta==2)
						{
							$nom_tipo_tarjeta="CREDITO";
						}
						else if($id_tipo_tarjeta==0)
						{
							$nom_tipo_tarjeta="/";
						}
				
					
			
						//INSERTAMOS EL TICKET
						$this->model->InsertarNoTicket($ticket,$id_venta);
			
						//REGRESAR TICKET LISTO PARA IMPRIMIR
						return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
						.$ticektTotal
						."\n#Pasajeros: ".$pasajero
						."\nTipo pago: ".$nom_tipo_pago
						."\nTipo moneda: ".$nom_moneda
						."\nTipo tarjeta: ".$nom_tipo_tarjeta
						."\nVendedor: ".$nombre_vendedor."\nChofer: ".$nombre_chofer."\nEmpresa: ".$nom_empresa
						."\nFecha: ".$fecha_venta."\n================================\n"
						."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/ACLARACIONES AL CORREO "."\n".$correo."\n por motivo de la reforma fiscal 2022, solo se podran emitir facturas CFDI de los tickets de transporte durante el mes en curso y el primer dia natural del siguiente mes"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";
			
					}
				}
					

			}
		else //cuando es la primera venta del vendedor
		{		$DatosTipoCambio = array(
				'DatosTipoCambio' => $this-> model-> TipoCambio()
				);
			foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
				$tipocambio=$row->valor;
		
			}
			//si pagan en dolares convertimos a pesos

			if($id_moneda==2)
			{
				$totalMXN=$total*$tipocambio;
				$ticektTotal="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
				$nom_moneda="Dolares USA";

			}
	

			$DatosVendedor = array(
				'DatosVendedor' => $this-> model-> DatosVendedor($id_usuario)
			);
			foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
				$id_empresa=$row->id_empresa_fk;
				$nombre_vendedor=$row->nombre;
		
			}
			//insertamos nueva venta
			$this->model->InsertarVenta($destino,$descripcion,$id_usuario,$id_empresa,$id_chofer[0],$total,$totalMXN,$fecha_venta,$id_moneda,$id_tipo_pago,$id_tipo_tarjeta,$keytime);
			//Extraemos el id de la venta
			$DatosVenta = array(
				'DatosVenta' => $this-> model-> BuscarVenta($fecha_venta,$id_empresa)
				);
			foreach ($DatosVenta['DatosVenta'] ->getResult() as $row) { 
				$id_venta=$row->id_ventas;
				$cabeza=$row->nomemp."\n".$row->direcemp."\nRFC: ".$row->rfcemp."\nTel: ".$row->telefono;
			}
			//Creamos el ticket
			if($id_empresa==1){
				   $ticket=$id_venta;
			  	$correo="taxitte1998@gmail.com";
			  	$nom_empresa="TTE";
			}
			else if($id_empresa==2)
			{
				$ticket=$id_venta;
				$correo="saatb1990@gmail.com";
				$nom_empresa="SAAT";
			}
			//Tipo de pago
			if($id_tipo_pago==1)
			{
		   	$nom_tipo_pago="EFECTIVO";
			}
			else if($id_tipo_pago==2)
			{
				$nom_tipo_pago="VOUCHER";
			}
			//Tipo tarjeta
			if($id_tipo_tarjeta==1)
			{
			   $nom_tipo_tarjeta="DEBITO";
			}
			else if($id_tipo_tarjeta==2)
			{
				$nom_tipo_tarjeta="CREDITO";
			}
			else if($id_tipo_tarjeta==0)
			{
				$nom_tipo_tarjeta="/";
			}

	

			//INSERTAMOS EL TICKET
			$this->model->InsertarNoTicket($ticket,$id_venta);

			//REGRESAR TICKET LISTO PARA IMPRIMIR
			return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
			.$ticektTotal
			."\n#Pasajeros: ".$pasajero
			."\nTipo pago: ".$nom_tipo_pago
			."\nTipo moneda: ".$nom_moneda
			."\nTipo tarjeta: ".$nom_tipo_tarjeta
			."\nVendedor: ".$nombre_vendedor."\nChofer: ".$nombre_chofer."\nEmpresa: ".$nom_empresa
			."\nFecha: ".$fecha_venta."\n================================\n"
			."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/ACLARACIONES AL CORREO "."\n".$correo."\n por motivo de la reforma fiscal 2022, solo se podran emitir facturas CFDI de los tickets de transporte durante el mes en curso y el primer dia natural del siguiente mes"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";


		}



	}
	//actualizacion 20 febrero
	public function AsociarChofere2()
	{
		date_default_timezone_set('America/Tijuana');
		$fecha_asignado=date("Y-m-d H:i:s");
		$chofer=$_GET['chofer'];
		$id_usuario=$_GET['usuario'];
		$ticket=strtoupper($_GET['ticket']);
		$id_chofer=explode("-", $chofer);
		$nombre_chofer=$id_chofer[1];
		$nombre_vendedor="";
		$destino="";
		$total=0;
		$id_usuarioven=0;
		$id_empresa=0;
		$fecha_venta="";
		$cabeza="";
		$id_venta="";
		$correo="";
		$nom_empresa="";
		$id_tipo_pago="";	
		$nom_tipo_pago="";
		$id_tipo_tarjeta="";
		$nom_tipo_tarjeta="";
		$id_moneda="";
		$tipocambio="";
		$totalMXN="";
		$ticektTotal="";
		$nom_moneda="Pesos MXN";


		$BuscarTicket = array(
			'BuscarTicket' => $this-> model-> BuscarTicketSinChofer($ticket)
			);
		
		if($BuscarTicket['BuscarTicket']==false)
		{
           return "0";
		}
		else
		{
			foreach ($BuscarTicket['BuscarTicket'] ->getResult() as $key) { 
			   $id_venta=$key->id_ventas;
		       $destino=$key->destino;
			   $id_tipo_pago=$key->id_tipo_pago_fk;
			   $id_tipo_tarjeta=$key->id_tipo_tarjeta_fk;
			   $id_moneda=$key->id_moneda_fk;
			   $total=$key->total;
			   $id_usuarioven=$key->id_vendedor_fk;
			   $id_empresa=$key->id_empresa_fk;
			   $fecha_venta=$key->fecha_venta;
			   $cabeza=$key->nomem."\n".$key->direcem."\nRFC: ".$key->rfcem."\nTel: ".$key->telefono;

			}

			$DatosTipoCambio = array(
				'DatosTipoCambio' => $this-> model-> TipoCambio()
				);
			foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
				$tipocambio=$row->valor;
				
			}
			$DatosVendedor = array(
				'DatosVendedor' => $this-> model-> DatosVendedor($id_usuarioven)
				);
			foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
				$nombre_vendedor=$row->nombre;
			
			}
			//Creamos el ticket
			if($id_empresa==1){
				$ticket=$id_venta;
			   $correo="taxitte1998@gmail.com";
			   $nom_empresa="TTE";
			 }
			 else if($id_empresa==2)
			 {
				 $ticket=$id_venta;
				 $correo="saatb1990@gmail.com";
				 $nom_empresa="SAAT";
			 }
			 //Tipo de pago
		     if($id_tipo_pago==1)
		     {
               $nom_tipo_pago="EFECTIVO";
		    }
		 	else if($id_tipo_pago==2)
			{
				$nom_tipo_pago="VOUCHER";
			}
				//Tipo tarjeta
			if($id_tipo_tarjeta==1)
			{
           	$nom_tipo_tarjeta="DEBITO";
			}
			else if($id_tipo_tarjeta==2)
			{
			$nom_tipo_tarjeta="CREDITO";
			}
			else if($id_tipo_tarjeta==0)
			{
			$nom_tipo_tarjeta="/";
			}
				//moneda
		     if($id_moneda==2)
		    {
			$totalMXN=$total*$tipocambio;
			$total="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
			$nom_moneda="Dolares USA";

		    }
		
		
			$this->model->ActualizarChofer2($id_chofer[0],$ticket,$id_usuario,$fecha_asignado);
			//return "1";
			return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
			."\nTotal: $".$total
			."\nTipo pago: ".$nom_tipo_pago
			."\nTipo moneda: ".$nom_moneda
			."\nTipo tarjeta: ".$nom_tipo_tarjeta
			."\nVendedor: ".$nombre_vendedor
			."\nChofer: ".$nombre_chofer
			."\nEmpresa: ".$nom_empresa
			."\nFecha: ".$fecha_venta."\n================================\n"
			."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/O MANDAR UN CORREO A"."\n".$correo."\nSOLICITAR SU FACTURA DENTRO DE LOS 10 DIAS HABILES DESPUES DE SU COMPRA Y RECIBIRA SU FACTURA EN UN LAPSO "."DE 24 A 48 HRS MINIMO"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";
		}


	}

	public function AsociarChofere()
	{
		
		$chofer=$_GET['chofer'];
		
		$ticket=strtoupper($_GET['ticket']);
		$id_chofer=explode("-", $chofer);
		$nombre_chofer=$id_chofer[1];
		$nombre_vendedor="";
		$destino="";
		$total=0;
		$id_usuarioven=0;
		$id_empresa=0;
		$fecha_venta="";
		$cabeza="";
		$id_venta="";
		$correo="";
		$nom_empresa="";
		$id_tipo_pago="";	
		$nom_tipo_pago="";
		$id_tipo_tarjeta="";
		$nom_tipo_tarjeta="";
		$id_moneda="";
		$tipocambio="";
		$totalMXN="";
		$ticektTotal="";
		$nom_moneda="Pesos MXN";


		$BuscarTicket = array(
			'BuscarTicket' => $this-> model-> BuscarTicketSinChofer($ticket)
			);
		
		if($BuscarTicket['BuscarTicket']==false)
		{
           return "0";
		}
		else
		{
			foreach ($BuscarTicket['BuscarTicket'] ->getResult() as $key) { 
			   $id_venta=$key->id_ventas;
		       $destino=$key->destino;
			   $id_tipo_pago=$key->id_tipo_pago_fk;
			   $id_tipo_tarjeta=$key->id_tipo_tarjeta_fk;
			   $id_moneda=$key->id_moneda_fk;
			   $total=$key->total;
			   $id_usuarioven=$key->id_vendedor_fk;
			   $id_empresa=$key->id_empresa_fk;
			   $fecha_venta=$key->fecha_venta;
			   $cabeza=$key->nomem."\n".$key->direcem."\nRFC: ".$key->rfcem."\nTel: ".$key->telefono;

			}

			$DatosTipoCambio = array(
				'DatosTipoCambio' => $this-> model-> TipoCambio()
				);
			foreach ($DatosTipoCambio['DatosTipoCambio'] ->getResult() as $row) { 
				$tipocambio=$row->valor;
				
			}
			$DatosVendedor = array(
				'DatosVendedor' => $this-> model-> DatosVendedor($id_usuarioven)
				);
			foreach ($DatosVendedor['DatosVendedor'] ->getResult() as $row) { 
				$nombre_vendedor=$row->nombre;
			
			}
			//Creamos el ticket
			if($id_empresa==1){
				$ticket=$id_venta;
			   $correo="taxitte1998@gmail.com";
			   $nom_empresa="TTE";
			 }
			 else if($id_empresa==2)
			 {
				 $ticket=$id_venta;
				 $correo="saatb1990@gmail.com";
				 $nom_empresa="SAAT";
			 }
			 //Tipo de pago
		     if($id_tipo_pago==1)
		     {
               $nom_tipo_pago="EFECTIVO";
		    }
		 	else if($id_tipo_pago==2)
			{
				$nom_tipo_pago="VOUCHER";
			}
				//Tipo tarjeta
			if($id_tipo_tarjeta==1)
			{
           	$nom_tipo_tarjeta="DEBITO";
			}
			else if($id_tipo_tarjeta==2)
			{
			$nom_tipo_tarjeta="CREDITO";
			}
			else if($id_tipo_tarjeta==0)
			{
			$nom_tipo_tarjeta="/";
			}
				//moneda
		     if($id_moneda==2)
		    {
			$totalMXN=$total*$tipocambio;
			$total="\nTotal: $".$total." USA-->MXN $".$totalMXN."\nTipo de cambio: ".$tipocambio;
			$nom_moneda="Dolares USA";

		    }
		
		
			$this->model->ActualizarChofer($id_chofer[0],$ticket);
			//return "1";
			return "\n".$cabeza."\n\n================================\n#Ticket: ".$ticket."\nDestino: ".$destino
			."\nTotal: $".$total
			."\nTipo pago: ".$nom_tipo_pago
			."\nTipo moneda: ".$nom_moneda
			."\nTipo tarjeta: ".$nom_tipo_tarjeta
			."\nVendedor: ".$nombre_vendedor
			."\nChofer: ".$nombre_chofer
			."\nEmpresa: ".$nom_empresa
			."\nFecha: ".$fecha_venta."\n================================\n"
			."\nPARA FACTURAR ENTRAR: \nhttps://taxis-aeropuerto-tj.com/O MANDAR UN CORREO A"."\n".$correo."\nSOLICITAR SU FACTURA DENTRO DE LOS 10 DIAS HABILES DESPUES DE SU COMPRA Y RECIBIRA SU FACTURA EN UN LAPSO "."DE 24 A 48 HRS MINIMO"."\nESTE BOLETO AMPARA 3160 DSMGVDF POR PASAJERO, SEGURO DEL VIAJEROAUTORIZADO POR LA LEY DE LA MATERIA   \n\n\n\n";
		}


	}
	public function CorteCaja()
	{
		$id_user=$_GET['id_user'];
		$fecha_inicial=$_GET['fecha_inicial'];
		$hora_inicial=$_GET['hora_inicial'];
		$minuto_inicial=$_GET['minuto_inicial'];
		$fecha_final=$_GET['fecha_final'];
		$hora_final=$_GET['hora_final'];
		$minuto_final=$_GET['minuto_final'];


		$fecha_inicial=$fecha_inicial." ".$hora_inicial.":".$minuto_inicial.":00";
		$fecha_final=$fecha_final." ".$hora_final.":".$minuto_final.":59";
		
		$total_mxn = 0;
		$total_mixin = [];
		

		$data = $this->model->CorteCajaVendedorDetallado($id_user,$fecha_inicial,$fecha_final);
		
		if(!$data){
			return "0";
		}
		
		$data_text = "";$DatosVendedor="";$empresaVendedor="";
		foreach ($data as $row) {
			$short_destino = explode(' ',$row->destino)[0];
			$short_pago = substr($row->Pago,0,3);
			$data_text .= "\n{$row->numero_ticket}  {$short_destino}  {$short_pago}  {$row->nacionalidad}  {$row->total}";
			$DatosVendedor = $row->NombreVendedor;
			$empresaVendedor = $row->NombreEmpresa;
			
			$total_mxn += $row->totalMXN;
			
			$short_pago = substr($row->Pago,0,3);
			
			if(!array_key_exists($row->Pago, $total_mixin)){
			  $total_mixin[$row->Pago] = [];
			}
			if(!array_key_exists($row->nacionalidad, $total_mixin[$row->Pago])){
			  $total_mixin[$row->Pago][$row->nacionalidad] = 0;
			}
			$total_mixin[$row->Pago][$row->nacionalidad] += (int) $row->total;
		}
		
		$mixin_text = "";
		
		foreach ($total_mixin as $pago => $info) {
			foreach ($info as $moneda => $total) {
				$mixin_text .= "\nCantidad en {$pago} de {$moneda}: ${total}";
			}
		}
		$count=count($data);
		return "\n\n\n\n\n***CORTE DE CAJA***"."\nVendedor: {$DatosVendedor}\nEmpresa: {$empresaVendedor}\nRango de fechas seleccionadas \nInicial: {$fecha_inicial}\nFinal:{$fecha_final}\nTickets vendidos: {$count}{$data_text}\nTOTAL:{$total_mxn}{$mixin_text}";


	}
	public function cancelar()
	{
		/*
		$ticket=strtoupper($_GET['ticket']);
		$motivo=$_GET['motivo'];
		$estatus="";
		$vendedor=$_GET['vendedor'];
	
 

		$BuscarTicket = array(
			'BuscarTicket' => $this-> model-> BuscarTicket($ticket,$vendedor)
			);
		
		if($BuscarTicket['BuscarTicket']==false)
		{
           return "0";
		}
		else
		{
			foreach ($BuscarTicket['BuscarTicket'] ->getResult() as $key) { 
		       $estatus=$key->estatus;

			}
			if($estatus!="CANCELADO")
			{
				$this->model->cancelar($ticket,$motivo);
				return "1";

			}
			else{
				return "2";
			}
		
			
			
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
