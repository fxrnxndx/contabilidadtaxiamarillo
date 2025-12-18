<?php
namespace App\Controllers;

//use CodeIgniter\Models\Model_home;
//use App\Models\Model_home;


//require '../TaxiContabilidad/vendor/autoload.php';
require './vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;


class Home extends BaseController
{


	/*private function genericResponse($data, $msj, $code){        
	if ($code == 200) {            
		return $this->respond(array(
		"data" => $data,
		"code" => $code      )); //, 404, "No hay nada"   
	} else {
		return $this->respond(array( 
		 "msj" => $msj, "code" => $code ));
	}*/

	public function changeDriver()
	{
		$id_sale = $_POST['id_sale'];
		$id_driver = $_POST['id_driver'];
		$this->model->setDriverToSale($id_sale, $id_driver);
		$driver = $this->model->getDriver($id_driver)[0];
		echo '{"name":"' . $driver["numero_empleado"] . '|' . $driver["nombre"] . ' ' . $driver["apellidos"] . '"}';
	}

	public function changeStatus()
	{
		$id_sale = $_POST['id_ticket'];
		$status = $_POST['ticket_status'];
		$motive = $_POST['motive'];
		$this->model->setStatusToSale($id_sale, $status, $motive);
		echo '{"msg":"ok"}';
		//return redirect()->to(base_url("Home/venta")); 
	}

	function __construct()
	{
		$this->session = session();
		//$this->load->model('Model_home');
		$this->model = new \App\Models\Model_home();
		$this->modelClientes = new \App\Models\Model_Clientes();
		$this->modelReservaciones = new \App\Models\Model_Reservaciones();
	}

	public function prueba()
	{
		return view('welcome_message');
	}


	public function login()
	{

		$data = [
			'notificacion' => 'false'
		];
		return view('login', $data);
	}

	public function validacionlogin()
	{
		$idperfil = "";
		$tipoperfil = "";
		$usuario = "";
		$usuario = $_POST['usuario'];
		$contra = $_POST['contra'];

		$data = array(
			'perfiles' => $this->model->login($usuario, $contra)
		);
		if ($data['perfiles'] == false) {
			//echo ("<script>alert('USUARIO O CONTRASEÑA INCORRECTOS');</script>");
			$data = [
				'notificacion' => 'true'
			];
			//return redirect()->to(base_url()); 
			return view('login', $data);
		} else {

			foreach ($data['perfiles']->getResult() as $row) {

				$this->session->set('usuario', $row->usuario);
			}
			//obtener la informacion del usuario
			$data = array(
				'DatosUsuario' => $this->model->DatosUsuario($_SESSION['usuario'])
			);
			foreach ($data['DatosUsuario']->getResult() as $row) {

				$tipoperfil = $row->id_tipo_usuario_fk;
				$idperfil = $row->id_perfil;
			}

			//iniciar sesion de acuerdo al perfil
			if ($tipoperfil == "1") {
				$data1 = array(
					'DatosPerfil' => $this->model->DatosAdministrador($idperfil)
				);

				foreach ($data1['DatosPerfil']->getResult() as $row) {

					$this->session->set('NOTIFICACION', 'true');
					$this->session->set('nombre', $row->nombre);
					$this->session->set('correo', $row->correo);

				}

				/*return view('RedView/header')
				. view('RedView/index',$data)
				. view('RedView/footer');*/
				return redirect()->to(base_url("Home/index"));
			}


		}

	}
	public function validaruser()
	{
		if (isset($_SESSION['usuario'])) {

		} else {
			return redirect()->to(base_url("Home/login"));
		}

	}
	public function index()
	{
		date_default_timezone_set('America/Tijuana');
		$fechaActual = date("Y-m-d");

		if (isset($_SESSION['usuario']) && isset($_SESSION['NOTIFICACION'])) {
			$VentaActual = array(
				'VentaActual' => $this->model->BuscarVentasActual($fechaActual),
				'ViajesIngresosTTE' => $this->model->ViajesIngresosTTE($fechaActual),
				'ViajesIngresosSAAT' => $this->model->ViajesIngresosSAAT($fechaActual),
				'TipoCambio' => $this->model->TipoCambio()
			);

			//$this->session->set('NOTIFICACION','false');

			return view('RedView/header')
				. view('RedView/index', $VentaActual)
				. view('RedView/footer');


		} else {
			echo ("INICIAR SESION DE NUEVO ");
		}



	}
	public function TipoCambio()
	{
		$tipocambio = $_POST['tipocambio'];
		if ($tipocambio > 0) {
			$ActualizarCambio = array(
				'ActualizarCambio' => $this->model->ActualizarCambio($tipocambio)
			);

			$this->session->set('NOTIFICACION', '1');
			return redirect()->to(base_url("Home/index"));
		} else {
			$this->session->set('NOTIFICACION', '2');
			return redirect()->to(base_url("Home/index"));
		}

	}
	public function vendedores()
	{
		$this->validaruser();

		//Extraer todos los vendedores
		$TodosVendedores = array(
			'TodosVendedores' => $this->model->TodosVendedores()
		);
		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/vendedores', $TodosVendedores)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			return view('RedView/header')
				. view('RedView/vendedores', $TodosVendedores)
				. view('RedView/footer');
		}


	}
	public function AgregarVendedor()
	{
		$idvendedor = $_POST['idvendedor'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$telefono = $_POST['telefono'];
		$empresa = $_POST['empresa'];
		$ganancia = $_POST['ganancia'];
		$usuario = $_POST['usuario'];
		$contra = $_POST['contra'];
		$contra2 = $_POST['contra2'];
		if (isset($_POST['estatus'])) {
			$estatus = "ACTIVADO";
		} else {
			$estatus = "DESACTIVADO";
		}

		if ($idvendedor == "0") {  //revisar que el vendedor no exista
			$dataExistencia = array(
				'existencia' => $this->model->ExistenciaUsuarioVendedor($usuario),
				'existenciaTelefono' => $this->model->ExistenciaVendedor($telefono)
			);

			if ($dataExistencia['existencia'] == false && $dataExistencia['existenciaTelefono'] == false) {
				if ($empresa > 0) {
					if ($contra == $contra2) {
						//echo($nombre."-".$apellidos."-".$telefono."-".$empresa."-".$noempleado."-".$ganancia."-".$estatus);
						$data = [
							'nombre' => $nombre,
							'apellidos' => $apellidos,
							'telefono' => $telefono,
							'ganancia' => $ganancia,
							'id_empresa_fk' => $empresa,
							'estatus' => $estatus
						];

						$this->model->AgregarVendedor($nombre, $apellidos, $telefono, $ganancia, $empresa, $estatus);
						//Extraer datos del vendedor creado 
						$dataExtraerVendedor = array(
							'existenciaTelefono' => $this->model->ExistenciaVendedor($telefono)
						);
						foreach ($dataExtraerVendedor['existenciaTelefono']->getResult() as $row) {
							$idvendedor = $row->id_vendedor;
						}
						//crear el usuario
						$this->model->AgregarUsuario($usuario, $contra, 2, $idvendedor, $estatus);


						//notfificacion de insert correcto
						$this->session->set('NOTIFICACION', '2');
						return redirect()->to(base_url("Home/vendedores"));
					} else {   //notificacion la contraseñas no son iguales
						$this->session->set('NOTIFICACION', '5');
						return redirect()->to(base_url("Home/vendedores"));
					}


				} else {    //notificacion de seleccionar una empresa
					$this->session->set('NOTIFICACION', '1');
					return redirect()->to(base_url("Home/vendedores"));

				}
			} else {   //notificacion de que el usuario o vendedor ya esta creado 
				$this->session->set('NOTIFICACION', '3');
				return redirect()->to(base_url("Home/vendedores"));


			}

		} else {//Actualizar datos del vendedor
			if ($contra == $contra2) {
				$this->model->ActualizarVendedor($nombre, $apellidos, $ganancia, $empresa, $estatus, $idvendedor);
				$this->model->ActualizarUsuario($usuario, $contra, $estatus);
				$this->session->set('NOTIFICACION', '4');
				return redirect()->to(base_url("Home/vendedores"));
			} else {
				//notificacion la contraseñas no son iguales
				$this->session->set('NOTIFICACION', '5');
				return redirect()->to(base_url("Home/vendedores"));
			}



		}


		/*
		return view('RedView/header') 
		.view('RedView/chofer')
		. view('RedView/footer');*/
	}
	public function supervisores()
	{

		//Extraer todos los supervisores
		$TodosSupervisores = array(
			'TodosSupervisores' => $this->model->TodosSupervisor()
		);
		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/supervisores', $TodosSupervisores)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/supervisores', $TodosSupervisores)
				. view('RedView/footer');
		}

	}
	public function AgregarSupervisor()
	{
		$idsupervisor = $_POST['idsupervisor'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$telefono = $_POST['telefono'];
		$empresa = $_POST['empresa'];
		$ganancia = $_POST['ganancia'];
		if (isset($_POST['estatus'])) {
			$estatus = "ACTIVADO";
		} else {
			$estatus = "DESACTIVADO";
		}

		if ($idsupervisor == "0") {  //revisar que el supervisor no exista
			$dataExistencia = array(
				'existencia' => $this->model->ExistenciaSupervisor($telefono)
			);
			if ($dataExistencia['existencia'] == false) {
				if ($empresa > 0) {
					//echo($nombre."-".$apellidos."-".$telefono."-".$empresa."-".$noempleado."-".$ganancia."-".$estatus);
					$data = [
						'nombre' => $nombre,
						'apellidos' => $apellidos,
						'telefono' => $telefono,
						'ganancia' => $ganancia,
						'id_empresa_fk' => $empresa,
						'estatus' => $estatus
					];
					$this->model->AgregarSupervisor($nombre, $apellidos, $telefono, $ganancia, $empresa, $estatus);

					$this->session->set('NOTIFICACION', '2');
					return redirect()->to(base_url("Home/supervisores"));

				} else {
					$this->session->set('NOTIFICACION', '1');
					return redirect()->to(base_url("Home/supervisores"));

				}
			} else {
				$this->session->set('NOTIFICACION', '3');
				return redirect()->to(base_url("Home/supervisores"));


			}

		} else {//Actualizar datos del chofer

			$data = [
				'nombre' => $nombre,
				'apellidos' => $apellidos,
				'telefono' => $telefono,
				'ganancia' => $ganancia,
				'id_empresa_fk' => $empresa,
				'estatus' => $estatus,
				'id_supervisor' => $idsupervisor
			];
			$this->model->ActualizarSupervisor($nombre, $apellidos, $telefono, $ganancia, $empresa, $estatus, $idsupervisor);

			$this->session->set('NOTIFICACION', '4');
			return redirect()->to(base_url("Home/supervisores"));


		}


		/*
		return view('RedView/header') 
		.view('RedView/chofer')
		. view('RedView/footer');*/
	}
	public function chofer()
	{
		$this->validaruser();

		//echo ("<script>alert('HOLA');</script>");
		//Extraer todos los choferes
		$TodosChofer = array(
			'TodosChofer' => $this->model->TodosChofer(),
			'TodasUnidades' => $this->model->TodasUnidades(),
			'socios' => $this->model->TodoSocio()
		);

		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/chofer', $TodosChofer)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/chofer', $TodosChofer)
				. view('RedView/footer');
		}



	}
	public function AgregarChofer()
	{
		$idchofer = $_POST['idchofer'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$telefono = $_POST['telefono'];
		$empresa = "1";
		$socio = $_POST['socio'];
		$unidad = $_POST['unidad'];
		$noempleado = $_POST['noempleado'];
		$ganancia = $_POST['ganancia'];
		$usuario = $_POST['usuario'];
		$contra = $_POST['contra'];
		$contra2 = $_POST['contra2'];
		if (isset($_POST['estatus'])) {
			$estatus = "ACTIVADO";
		} else {
			$estatus = "DESACTIVADO";
		}

		if ($idchofer == "0") {  //revisar que el chofer no exista
			$dataExistencia = array(
				'existencia' => $this->model->ExistenciaChofer($noempleado),
				'existenciausuario' => $this->model->ExistenciaUsuarioChofer($usuario),
			);
			if ($dataExistencia['existencia'] == false && $dataExistencia['existenciausuario'] == false) {
				if ($empresa > 0 && $socio > 0 && $unidad > 0) {
					if ($contra2 == $contra) {
						$this->model->AgregarChofer($nombre, $apellidos, $telefono, $ganancia, $empresa, $socio, $estatus, $noempleado, $unidad);

						//crear el usuario
						$this->model->AgregarUsuario($usuario, $contra, 3, $noempleado, $estatus);
						$this->session->set('NOTIFICACION', '2');
						return redirect()->to(base_url("Home/chofer"));
					} else {	//Notificar que las contrasenas no son iguales
						$this->session->set('NOTIFICACION', '5');
						return redirect()->to(base_url("Home/chofer"));
					}

				} else {
					$this->session->set('NOTIFICACION', '1');
					return redirect()->to(base_url("Home/chofer"));

				}
			} else {
				$this->session->set('NOTIFICACION', '3');
				return redirect()->to(base_url("Home/chofer"));


			}

		} else {//Actualizar datos del chofer

			if ($contra == $contra2) {
				$this->model->ActualizarChofer($nombre, $apellidos, $telefono, $ganancia, $empresa, $estatus, $noempleado, $unidad, $socio);
				$this->model->ActualizarUsuarioChofer($usuario, $contra, $estatus, $noempleado);
				$this->session->set('NOTIFICACION', '4');
				return redirect()->to(base_url("Home/chofer"));
			} else {
				//notificacion la contraseñas no son iguales
				$this->session->set('NOTIFICACION', '5');
				return redirect()->to(base_url("Home/chofer"));
			}

		}


		/*
		return view('RedView/header') 
		.view('RedView/chofer')
		. view('RedView/footer');*/
	}
	//bloque inicio unidad
	public function unidad()
	{
		$this->validaruser();

		//echo ("<script>alert('HOLA');</script>");
		//Extraer todas las unidades
		$TodasUnidades = array(
			'TodasUnidades' => $this->model->TodasUnidades(),
			'socios' => $this->model->TodoSocio()
		);

		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/unidad', $TodasUnidades)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/unidad', $TodasUnidades)
				. view('RedView/footer');
		}


	}
	public function AgregarUnidad()
	{
		$idunidad = $_POST['idunidad'];
		$placas = $_POST['placas'];
		$marca = $_POST['marca'];
		$numunidad = $_POST['numunidad'];
		$modelo = $_POST['modelo'];
		$idempresa = "1";
		$idsocio = $_POST['idsocio'];
		$ano = $_POST['ano'];
		if (isset($_POST['estatus'])) {
			$estatus = "ACTIVADO";
		} else {
			$estatus = "DESACTIVADO";
		}

		if ($idunidad == "0") {  //revisar que el chofer no exista
			$dataExistencia = array(
				'existencia' => $this->model->ExistenciaUnidad($placas)
			);
			if ($dataExistencia['existencia'] == false) {
				if ($idempresa > 0 && $idsocio > 0) {

					$this->model->AgregarUnidad($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad);

					$this->session->set('NOTIFICACION', '2');
					return redirect()->to(base_url("Home/unidad"));


				} else {
					$this->session->set('NOTIFICACION', '1');
					return redirect()->to(base_url("Home/unidad"));

				}
			} else {
				$this->session->set('NOTIFICACION', '3');
				return redirect()->to(base_url("Home/chofer"));


			}

		} else {//Actualizar datos del chofer

			if ($idempresa > 0 && $idsocio > 0) {

				$this->model->ActualizarUnidad($placas, $marca, $modelo, $ano, $idsocio, $idempresa, $estatus, $numunidad, $idunidad);

				$this->session->set('NOTIFICACION', '4');
				return redirect()->to(base_url("Home/unidad"));


			} else {
				$this->session->set('NOTIFICACION', '1');
				return redirect()->to(base_url("Home/unidad"));

			}

		}

	}

	// bloque fin unidad


	//bloque inicio socios


	//bloque fin socios	


	public function venta()
	{
		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/ventas')
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/ventas')
				. view('RedView/footer');
		}

	}

	public function BuscarVentaEmpresa()
	{
		$empresa = $_POST['empresa'];
		$fecha = $_POST['fecha'];
		$dataVentaEmpresa = array(
			'dataVentaEmpresa' => $this->model->BuscarVenta($empresa, $fecha),
			'drivers' => $this->model->TodosChofer()
		);
		if ($empresa > 0) {
			if ($dataVentaEmpresa['dataVentaEmpresa'] == false) {

				$this->session->set('NOTIFICACION', '1');
				return redirect()->to(base_url("Home/venta"));


			} else {
				$this->session->set('NOTIFICACION', '2');
				return view('RedView/header')
					. view('RedView/ventas', $dataVentaEmpresa)
					. view('RedView/footer');


			}
		} else {
			$this->session->set('NOTIFICACION', '3');
			return redirect()->to(base_url("Home/venta"));
		}



	}
	public function reporte()
	{

		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/reportes')
				. view('RedView/footer');
		} else {
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/reportes')
				. view('RedView/footer');
		}


	}
	public function BuscarChofer()
	{
		$empresa = $_GET['valor'];
		$idChofer = "";
		$nombre = "";
		$apellidos = "";
		$selector = "";
		$selectorI = ' <label for="input-1">Choferes</label><select class="form-control" aria-label="Default select example" id="chofer" name="chofer" required> <option selected value="0">Todos los choferes</option>';
		$selectorF = "</select>";


		$BuscarChoferEmpresa = array(
			'BuscarChoferEmpresa' => $this->model->BuscarEmpresaChofer($empresa)
		);
		if ($BuscarChoferEmpresa['BuscarChoferEmpresa'] == false) {
			$this->session->set('NOTIFICACION', '2');
			return redirect()->to(base_url("Home/reporte"));
		} else {
			foreach ($BuscarChoferEmpresa['BuscarChoferEmpresa']->getResult() as $row) {
				$idChofer = $row->id_chofer;
				$nombre = $row->nombre;
				$apellidos = $row->apellidos;
				$selector = "<option value=" . $idChofer . ">" . $nombre . " " . $apellidos . "</option>" . $selector;


			}

			echo ($selectorI . $selector . $selectorF);

		}

	}
	public function BuscarReporte()
	{
		$spreadsheet = new Spreadsheet();
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$tipo_busqueda = $_POST['busqueda'];
		$empresa = $_POST['empresa'];
		$fecha_inicial = $_POST['fechainicial'];
		$hora_inicial = $_POST['HoraInicial'];
		$fecha_final = $_POST['fechafinal'];
		$hora_final = $_POST['HoraFinal'];
		if (isset($_POST['chofer'])) {
			$chofer = $_POST['chofer'];
		}


		$fecha_inicial = $fecha_inicial . " " . $hora_inicial . ":" . "00";
		$fecha_final = $fecha_final . " " . $hora_final . ":" . "59";

		if ($empresa > 0 && $tipo_busqueda > 0) {
			if ($tipo_busqueda == 1) {

				$spreadsheet = $reader->load("ReporteEmpresa.xlsx");
				$spreadsheet->setActiveSheetIndex(0);
				$hojaActiva = $spreadsheet->getActiveSheet();

				$filainicial = 8;
				$total = 0;
				$socia = 0;


				$dataBusquedaEmpresa = array(
					'dataBusquedaEmpresa' => $this->model->ReporteVentaEmpresa($empresa, $fecha_inicial, $fecha_final)
				);

				if ($dataBusquedaEmpresa['dataBusquedaEmpresa'] == false) {
					$this->session->set('NOTIFICACION', '2');
					return redirect()->to(base_url("Home/reporte"));
				} else {
					foreach ($dataBusquedaEmpresa['dataBusquedaEmpresa']->getResult() as $row) {


						$hojaActiva->setCellValue('A' . $filainicial, $row->numero_ticket);
						$hojaActiva->setCellValue('B' . $filainicial, $row->fecha_venta);
						$hojaActiva->setCellValue('C' . $filainicial, $row->destino);
						$hojaActiva->setCellValue('D' . $filainicial, $row->vendedornom);
						$hojaActiva->setCellValue('E' . $filainicial, $row->chofernom);
						$hojaActiva->setCellValue('G' . $filainicial, $row->factura);
						/*if($row->id_moneda_fk==2)
						{
							$hojaActiva->setCellValue('F'.$filainicial,'$'.$row->total*$row->cambio);
							$total=($row->total*$row->cambio)+$total;
						}
						else
						{ 
						  $hojaActiva->setCellValue('F'.$filainicial,'$'.$row->total);
						  $total=$row->total+$total;
						}*/
						$hojaActiva->setCellValue('F' . $filainicial, '$' . $row->totalMXN);
						$total = $row->totalMXN + $total;

						$filainicial++;


					}
				}
				if ($empresa == 1) {
					$hojaActiva->setCellValue('A6', 'T.T.E.');
				}
				if ($empresa == 2) {
					$hojaActiva->setCellValue('A6', 'S.A.A.T.');
				}
				$socia = $total / 2;
				$hojaActiva->setCellValue('H6', '$' . $total . 'm.n.');
				$hojaActiva->setCellValue('H14', '$' . $socia);
				$hojaActiva->setCellValue('H22', '$' . $socia);
				$w = new Xlsx($spreadsheet);
				$w->save("R.Empresa.xlsx");
				header("Content-disposition: attachment; filename=R.Empresa.xlsx;Content-type: MIME");
				readfile("R.Empresa.xlsx");



			} else if ($tipo_busqueda == 2) {
				$filainicial = 8;
				$filainicial2 = 8;
				$total = 0;
				$totalgananciaEUAsaat = 0;
				$totalgananciaEUAtte = 0;
				$totalgananciaMXNsaat = 0;
				$totalgananciaMXNtte = 0;
				$totalgananciatte = 0;
				$totalgananciasaat = 0;
				$spreadsheet = $reader->load("ReporteChoferes.xlsx");
				$spreadsheet->setActiveSheetIndex(0);
				$hojaActiva = $spreadsheet->getActiveSheet();
				//Descargar reporte por todos los choferes
				if ($chofer == 0) {
					$dataBusquedaChoferes = array(
						'dataBusquedaChoferes' => $this->model->ReporteVentaChoferes($empresa, $fecha_inicial, $fecha_final)
					);



					if ($dataBusquedaChoferes['dataBusquedaChoferes'] == false) {
						$this->session->set('NOTIFICACION', '2');
						return redirect()->to(base_url("Home/reporte"));
					} else {
						foreach ($dataBusquedaChoferes['dataBusquedaChoferes']->getResult() as $row) {

							$total = $total + $row->total;
							$hojaActiva->setCellValue('A' . $filainicial, $row->numero_ticket);
							$hojaActiva->setCellValue('B' . $filainicial, $row->fecha_venta);
							$hojaActiva->setCellValue('C' . $filainicial, $row->destino);
							$hojaActiva->setCellValue('D' . $filainicial, $row->numempleado);
							$hojaActiva->setCellValue('E' . $filainicial, $row->chofernom);
							$hojaActiva->setCellValue('F' . $filainicial, $row->empresachofernom);
							/*if($row->id_moneda_fk==2)
							{
								$hojaActiva->setCellValue('G'.$filainicial,'$'.$row->total*$row->cambio);
							}
							else{
								$hojaActiva->setCellValue('G'.$filainicial,'$'.$row->total);
							} */
							$hojaActiva->setCellValue('G' . $filainicial, '$' . $row->totalMXN);
							$filainicial++;


						}
						$BuscarEmpresaChofer = array(
							'BuscarEmpresaChofer' => $this->model->BuscarEmpresaChofer($empresa)
						);

						//Recorrer todos los choferes que son de la misma empresa y sacar sus viajes
						foreach ($BuscarEmpresaChofer['BuscarEmpresaChofer']->getResult() as $key) {


							$dataBusquedaChoferGanancia = array(
								'dataBusquedaChoferGanancia' => $this->model->ReporteVentaChoferesGanancia($empresa, $fecha_inicial, $fecha_final, $key->id_chofer)
							);

							$dataBusquedaChoferGanancia1 = array(
								'dataBusquedaChoferGanancia1' => $this->model->ReporteVentaChoferesGanancia1($empresa, $fecha_inicial, $fecha_final, $key->id_chofer)
							);
							$dataBusquedaChoferGanancia2 = array(
								'dataBusquedaChoferGanancia2' => $this->model->ReporteVentaChoferesGanancia2($empresa, $fecha_inicial, $fecha_final, $key->id_chofer)
							);

							if ($dataBusquedaChoferGanancia1['dataBusquedaChoferGanancia1'] != false) {
								foreach ($dataBusquedaChoferGanancia1['dataBusquedaChoferGanancia1']->getResult() as $key1) {
									if ($key1->empresanom == "TTE") {
										$totalgananciaEUAtte = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAtte;
									} else {
										$totalgananciaEUAsaat = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAsaat;
									}


									/*
									$hojaActiva->setCellValue('M'.$filainicial2,'$'.$row2->sumatotal);
									$hojaActiva->setCellValue('I'.$filainicial2,$row2->numempleado);
									$hojaActiva->setCellValue('J'.$filainicial2,$row2->chofernom);
									$hojaActiva->setCellValue('L'.$filainicial2,$row2->choferganancia);
									$hojaActiva->setCellValue('K'.$filainicial2,'$'.$row2->sumatotal);
									$hojaActiva->setCellValue('N'.$filainicial2,$row2->empresanom);
									$filainicial2++;*/

								}
							}
							if ($dataBusquedaChoferGanancia2['dataBusquedaChoferGanancia2'] != false) {
								foreach ($dataBusquedaChoferGanancia2['dataBusquedaChoferGanancia2']->getResult() as $key2) {
									if ($key2->empresanom == "TTE") {
										$totalgananciaMXNtte = $key2->sumatotal + $totalgananciaMXNtte;
									} else {
										$totalgananciaMXNsaat = $key2->sumatotal + $totalgananciaMXNsaat;
									}




								}

							}
							$totalgananciatte = $totalgananciaEUAtte + $totalgananciaMXNtte;
							$totalgananciasaat = $totalgananciaEUAsaat + $totalgananciaMXNsaat;
							if ($dataBusquedaChoferGanancia['dataBusquedaChoferGanancia'] != false) {
								foreach ($dataBusquedaChoferGanancia['dataBusquedaChoferGanancia']->getResult() as $key3) {

									if ($key3->empresanom == "TTE") {
										//$hojaActiva->setCellValue('M'.$filainicial2,'$'.$totalganancia);
										$hojaActiva->setCellValue('I' . $filainicial2, $key3->numempleado);
										$hojaActiva->setCellValue('J' . $filainicial2, $key3->chofernom);
										$hojaActiva->setCellValue('L' . $filainicial2, $key3->choferganancia);
										//$hojaActiva->setCellValue('K'.$filainicial2,'$'.$totalgananciatte);
										$hojaActiva->setCellValue('K' . $filainicial2, '$' . $key3->sumatotal);
										$hojaActiva->setCellValue('N' . $filainicial2, $key3->empresanom);

									} else {
										//$hojaActiva->setCellValue('M'.$filainicial2,'$'.$totalganancia);
										$hojaActiva->setCellValue('I' . $filainicial2, $key3->numempleado);
										$hojaActiva->setCellValue('J' . $filainicial2, $key3->chofernom);
										$hojaActiva->setCellValue('L' . $filainicial2, $key3->choferganancia);
										//$hojaActiva->setCellValue('K'.$filainicial2,'$'.$totalgananciasaat);
										$hojaActiva->setCellValue('K' . $filainicial2, '$' . $key3->sumatotal);
										$hojaActiva->setCellValue('N' . $filainicial2, $key3->empresanom);

									}
									$filainicial2++;

								}
							}
							$totalgananciatte = 0;
							$totalgananciasaat = 0;
							$totalgananciaEUAtte = 0;
							$totalgananciaEUAsaat = 0;
							$totalgananciaMXNtte = 0;
							$totalgananciaMXNsaat = 0;


						}




					}
					if ($empresa == 1) {
						$hojaActiva->setCellValue('A6', 'T.T.E.');
					}
					if ($empresa == 2) {
						$hojaActiva->setCellValue('A6', 'S.A.A.T.');
					}


					$w = new Xlsx($spreadsheet);
					$w->save("R.Choferes.xlsx");
					header("Content-disposition: attachment; filename=R.Choferes.xlsx;Content-type: MIME");
					readfile("R.Choferes.xlsx");
				}
				//Descargar reporte por chofer especifico
				else {
					$totalgananciaEUAsaat = 0;
					$totalgananciaEUAtte = 0;
					$totalgananciaMXNsaat = 0;
					$totalgananciaMXNtte = 0;
					$totalgananciatte = 0;
					$totalgananciasaat = 0;
					$dataBusquedaChofer = array(
						'dataBusquedaChofer' => $this->model->ReporteVentaChofer($empresa, $fecha_inicial, $fecha_final, $chofer)
					);

					$dataBusquedaChoferGanancia = array(
						'dataBusquedaChoferGanancia' => $this->model->ReporteVentaChoferGanancia($empresa, $fecha_inicial, $fecha_final, $chofer)
					);
					$dataBusquedaChoferGanancia1 = array(
						'dataBusquedaChoferGanancia1' => $this->model->ReporteVentaChoferGanancia1($empresa, $fecha_inicial, $fecha_final, $chofer)
					);
					$dataBusquedaChoferGanancia2 = array(
						'dataBusquedaChoferGanancia2' => $this->model->ReporteVentaChoferGanancia2($empresa, $fecha_inicial, $fecha_final, $chofer)
					);

					if ($dataBusquedaChofer['dataBusquedaChofer'] == false && $dataBusquedaChoferGanancia['dataBusquedaChoferGanancia'] == false) {
						$this->session->set('NOTIFICACION', '2');
						return redirect()->to(base_url("Home/reporte"));
					} else {

						foreach ($dataBusquedaChofer['dataBusquedaChofer']->getResult() as $row) {

							$total = $total + $row->total;
							$hojaActiva->setCellValue('A' . $filainicial, $row->numero_ticket);
							$hojaActiva->setCellValue('B' . $filainicial, $row->fecha_venta);
							$hojaActiva->setCellValue('C' . $filainicial, $row->destino);
							$hojaActiva->setCellValue('D' . $filainicial, $row->numempleado);
							$hojaActiva->setCellValue('E' . $filainicial, $row->chofernom);
							$hojaActiva->setCellValue('F' . $filainicial, $row->empresachofernom);
							//$hojaActiva->setCellValue('G'.$filainicial,'$'.$row->total);
							/*if($row->id_moneda_fk==2)
							{
								$hojaActiva->setCellValue('G'.$filainicial,$row->total*$row->cambio);
							}
							else{
								$hojaActiva->setCellValue('G'.$filainicial,$row->total);
							} */
							$hojaActiva->setCellValue('G' . $filainicial, $row->totalMXN);
							$filainicial++;


						}
						$filainicial = 8;
						if ($dataBusquedaChoferGanancia1['dataBusquedaChoferGanancia1'] != false) {
							foreach ($dataBusquedaChoferGanancia1['dataBusquedaChoferGanancia1']->getResult() as $key1) {
								if ($key1->empresanom == "TTE") {
									$totalgananciaEUAtte = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAtte;
								} else {
									$totalgananciaEUAsaat = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAsaat;
								}

							}
						}
						if ($dataBusquedaChoferGanancia2['dataBusquedaChoferGanancia2'] != false) {
							foreach ($dataBusquedaChoferGanancia2['dataBusquedaChoferGanancia2']->getResult() as $key2) {
								if ($key2->empresanom == "TTE") {
									$totalgananciaMXNtte = $key2->sumatotal + $totalgananciaMXNtte;
								} else {
									$totalgananciaMXNsaat = $key2->sumatotal + $totalgananciaMXNsaat;
								}


							}

						}
						$totalgananciatte = $totalgananciaEUAtte + $totalgananciaMXNtte;
						$totalgananciasaat = $totalgananciaEUAsaat + $totalgananciaMXNsaat;
						if ($dataBusquedaChoferGanancia['dataBusquedaChoferGanancia'] != false) {
							foreach ($dataBusquedaChoferGanancia['dataBusquedaChoferGanancia']->getResult() as $row) {



								if ($row->empresanom == "TTE") {
									//$hojaActiva->setCellValue('M'.$filainicial2,'$'.$totalganancia);
									$hojaActiva->setCellValue('I' . $filainicial, $row->numempleado);
									$hojaActiva->setCellValue('J' . $filainicial, $row->chofernom);
									$hojaActiva->setCellValue('L' . $filainicial, $row->choferganancia);
									//$hojaActiva->setCellValue('K'.$filainicial,$totalgananciatte);
									$hojaActiva->setCellValue('K' . $filainicial, $row->sumatotal);
									$hojaActiva->setCellValue('N' . $filainicial, $row->empresanom);

								} else {
									//$hojaActiva->setCellValue('M'.$filainicial2,'$'.$totalganancia);
									$hojaActiva->setCellValue('I' . $filainicial, $row->numempleado);
									$hojaActiva->setCellValue('J' . $filainicial, $row->chofernom);
									$hojaActiva->setCellValue('L' . $filainicial, $row->choferganancia);
									//$hojaActiva->setCellValue('K'.$filainicial,$totalgananciasaat);
									$hojaActiva->setCellValue('K' . $filainicial, $row->sumatotal);
									$hojaActiva->setCellValue('N' . $filainicial, $row->empresanom);

								}


								$filainicial++;

							}
						}
						$totalgananciatte = 0;
						$totalgananciasaat = 0;
						$totalgananciaEUAtte = 0;
						$totalgananciaEUAsaat = 0;
						$totalgananciaMXNtte = 0;
						$totalgananciaMXNsaat = 0;



					}
					if ($empresa == 1) {
						$hojaActiva->setCellValue('A6', 'T.T.E.');
					}
					if ($empresa == 2) {
						$hojaActiva->setCellValue('A6', 'S.A.A.T.');
					}


					$w = new Xlsx($spreadsheet);
					$w->save("R.Choferes.xlsx");
					header("Content-disposition: attachment; filename=R.Choferes.xlsx;Content-type: MIME");
					readfile("R.Choferes.xlsx");

				}


			} else if ($tipo_busqueda == 3) {

				$filainicial = 8;
				$total = 0;
				$totalgananciaEUAsaat = 0;
				$totalgananciaEUAtte = 0;
				$totalgananciaMXNsaat = 0;
				$totalgananciaMXNtte = 0;
				$totalgananciatte = 0;
				$totalgananciasaat = 0;
				$spreadsheet = $reader->load("ReporteVendedores.xlsx");
				$spreadsheet->setActiveSheetIndex(0);
				$hojaActiva = $spreadsheet->getActiveSheet();

				$dataBusquedaVendedores = array(
					'dataBusquedaVendedores' => $this->model->ReporteVentaVendedores($empresa, $fecha_inicial, $fecha_final)
				);

				$dataBusquedaVendedorGanancia = array(
					'dataBusquedaVendedorGanancia' => $this->model->ReporteVentaVendedorGanancia($empresa, $fecha_inicial, $fecha_final)
				);
				$dataBusquedaVendedorGanancia1 = array(
					'dataBusquedaVendedorGanancia1' => $this->model->ReporteVentaVendedorGanancia1($empresa, $fecha_inicial, $fecha_final)
				);
				$dataBusquedaVendedorGanancia2 = array(
					'dataBusquedaVendedorGanancia2' => $this->model->ReporteVentaVendedorGanancia2($empresa, $fecha_inicial, $fecha_final)
				);

				if ($dataBusquedaVendedores['dataBusquedaVendedores'] == false && $dataBusquedaVendedorGanancia['dataBusquedaVendedorGanancia'] == false) {
					$this->session->set('NOTIFICACION', '2');
					return redirect()->to(base_url("Home/reporte"));
				} else {
					foreach ($dataBusquedaVendedores['dataBusquedaVendedores']->getResult() as $row) {

						$total = $total + $row->total;
						$hojaActiva->setCellValue('A' . $filainicial, $row->numero_ticket);
						$hojaActiva->setCellValue('B' . $filainicial, $row->fecha_venta);
						$hojaActiva->setCellValue('C' . $filainicial, $row->destino);
						$hojaActiva->setCellValue('D' . $filainicial, $row->vendedornom);
						//$hojaActiva->setCellValue('E'.$filainicial,'$'.$row->total);
						if ($row->id_moneda_fk == 2) {
							$hojaActiva->setCellValue('E' . $filainicial, '$' . $row->totalMXN . "-" . $row->tipopago);
						} else {
							$hojaActiva->setCellValue('E' . $filainicial, '$' . $row->totalMXN . "-" . $row->tipopago);
						}

						$filainicial++;


					}

					//Recorrer todos los vendedores que son de la misma empresa y sacar sus viajes
					$BuscarEmpresaVendedor = array(
						'BuscarEmpresaVendedor' => $this->model->BuscarEmpresaVendedor($empresa)
					);

					$filainicial = 8;


					if ($dataBusquedaVendedorGanancia1['dataBusquedaVendedorGanancia1'] != false) {
						foreach ($dataBusquedaVendedorGanancia1['dataBusquedaVendedorGanancia1']->getResult() as $key1) {
							if ($key1->empresanom == "TTE") {
								$totalgananciaEUAtte = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAtte;
							} else {
								$totalgananciaEUAsaat = ($key1->sumatotal * $key1->tipocambio) + $totalgananciaEUAsaat;
							}

						}
					}
					if ($dataBusquedaVendedorGanancia2['dataBusquedaVendedorGanancia2'] != false) {
						foreach ($dataBusquedaVendedorGanancia2['dataBusquedaVendedorGanancia2']->getResult() as $key2) {
							if ($key2->empresanom == "TTE") {
								$totalgananciaMXNtte = $key2->sumatotal + $totalgananciaMXNtte;
							} else {
								$totalgananciaMXNsaat = $key2->sumatotal + $totalgananciaMXNsaat;
							}


						}

					}
					$totalgananciatte = $totalgananciaEUAtte + $totalgananciaMXNtte;
					$totalgananciasaat = $totalgananciaEUAsaat + $totalgananciaMXNsaat;

					foreach ($dataBusquedaVendedorGanancia['dataBusquedaVendedorGanancia']->getResult() as $row) {


						if ($row->empresanom == "TTE") {

							// $hojaActiva->setCellValue('H'.$filainicial,$totalgananciatte);
							$hojaActiva->setCellValue('H' . $filainicial, $row->sumatotal);
							$hojaActiva->setCellValue('I' . $filainicial, $row->vendedorganancia);
							// $hojaActiva->setCellValue('J'.$filainicial,'$'.$totalgananciatte);
							$hojaActiva->setCellValue('G' . $filainicial, $row->vendedornom);

						} else {

							//$hojaActiva->setCellValue('H'.$filainicial,$totalgananciasaat);
							$hojaActiva->setCellValue('H' . $filainicial, $row->sumatotal);
							$hojaActiva->setCellValue('I' . $filainicial, $row->vendedorganancia);
							//$hojaActiva->setCellValue('J'.$filainicial,'$'.$totalgananciasaat);
							$hojaActiva->setCellValue('G' . $filainicial, $row->vendedornom);

						}


						$filainicial++;

					}



				}
				if ($empresa == 1) {
					$hojaActiva->setCellValue('A6', 'T.T.E.');
				}
				if ($empresa == 2) {
					$hojaActiva->setCellValue('A6', 'S.A.A.T.');
				}


				$w = new Xlsx($spreadsheet);
				$w->save("R.Vendedores.xlsx");
				header("Content-disposition: attachment; filename=R.Vendedores.xlsx;Content-type: MIME");
				readfile("R.Vendedores.xlsx");
			}






		} else {
			$this->session->set('NOTIFICACION', '1');
			return redirect()->to(base_url("Home/reporte"));
		}


		/*header("Content-disposition: attachment; filename=ReporteEmpresa.xlsx");
		header("Content-type: MIME");
		readfile("ReporteEmpresa.xlsx");*/

	}
	public function logout()
	{
		$this->session->remove('usuario');
		$data = [
			'notificacion' => 'false'
		];
		return view('login', $data);
	}

	//--------------------------------------------------------------------

	//Clientes
	public function Clientes()
	{
		$this->validaruser();
		$Datos = array(
			'Clientes' => $this->modelClientes->obtenerClientes(),
		);
		//revisar si existe notificacion quiere decir si es primera vez en la pagia
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/clientes', $Datos)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/clientes', $Datos)
				. view('RedView/footer');
		}
	}

	//registrar cliente
	public function registrarCliente()
	{
		$this->validaruser();
		$session = session();

		$data = [
			'nombre' => $this->request->getPost('nombre'),
			'apellidos' => $this->request->getPost('apellidos'),
			'correo' => $this->request->getPost('correo'),
			'telefono1' => $this->request->getPost('telefono'),
			'telefono2' => $this->request->getPost('telefono2'),
		];

		if ($data['nombre'] == '' || $data['apellidos'] == '') {
			$this->session->setFlashdata('alerta', 'Debe ingresar nombre y apellidos');
			return redirect()->to(base_url("Home/clientes"));
		} else {
			//VERIFICAR QUE NO EXISTA EL CLIENTE
			try {
				if ($this->modelClientes->obtenerClienteByNombreApellidos($data['nombre'], $data['apellidos'])) {
					$this->session->setFlashdata('alerta', 'El cliente ya existe');
					return redirect()->to(base_url("Home/clientes"));
				}
			} catch (\Throwable $th) {
				$this->session->setFlashdata('alerta', 'Error al registrar el cliente');
				return redirect()->to(base_url("Home/clientes"));
			}
			$this->modelClientes->registrarCliente($data);
			$this->session->setFlashdata('alerta', 'Cliente registrado correctamente');
			return redirect()->to(base_url("Home/clientes"));
		}
	}

	//consultar datos de cliente para editar
	public function consultaCliente()
	{
		$this->validaruser();
		$id_cliente = $this->request->getPost('id_cliente');
		$data = $this->modelClientes->obtenerCliente($id_cliente);
		return json_encode($data);
	}

	//guardar datos del cliente editado
	public function actualizarCliente()
	{
		$this->validaruser();
		$data = [
			'id_cliente' => $this->request->getPost('id_clienteEditar'),
			'nombre' => $this->request->getPost('nombreEditar'),
			'apellidos' => $this->request->getPost('apellidosEditar'),
			'correo' => $this->request->getPost('correoEditar'),
			'telefono1' => $this->request->getPost('telefonoEditar'),
			'telefono2' => $this->request->getPost('telefono2Editar'),
		];
		$this->modelClientes->actualizarCliente($data);
		$this->session->setFlashdata('alerta', 'Cliente editado correctamente');
		return redirect()->to(base_url("Home/clientes"));
	}
	//RESERVACIONES
	public function Reservaciones()
	{
		$this->validaruser();
		$reservaciones = $this->modelReservaciones->obtenerReservacionesPendientesConfirmados();
		//obtener los dias faltante a la fecha actual
		foreach ($reservaciones as $key => $row) {
			//OBTENER LOS DIAS FALTANTES SOLO LOS QUE TENGAN ESTATUS ESPERA Y CONFIRMADO
			if ($row['status'] == 'PENDIENTE' || $row['status'] == 'CONFIRMADO') {
				$reservaciones[$key]['dias_faltantes'] =
					$this->modelReservaciones->obtenerDiasFaltantes($row['fecha_servicio']);
			} else {
				$reservaciones[$key]['dias_faltantes'] = "";
			}
		}
		$Datos = array(
			'Reservaciones' => $reservaciones,
			'Clientes' => $this->modelClientes->obtenerClientes(),
		);
		if (isset($_SESSION['NOTIFICACION'])) {
			return view('RedView/header')
				. view('RedView/reservaciones', $Datos)
				. view('RedView/footer');
		} else {   //Excepcion para cuando notificacion no existe tenga como valor 0
			$this->session->set('NOTIFICACION', '0');
			return view('RedView/header')
				. view('RedView/reservaciones', $Datos)
				. view('RedView/footer');
		}
	}

	//registrar nuevo cliente y obtener id
	public function registrarClienteGETID()
	{
		$this->validaruser();
		$data = [
			'nombre' => $this->request->getPost('nombre'),
			'apellidos' => $this->request->getPost('apellidos'),
			'correo' => $this->request->getPost('correo'),
			'telefono1' => $this->request->getPost('telefono1'),
			'telefono2' => $this->request->getPost('telefono2'),
		];
		if ($data['nombre'] == '' || $data['apellidos'] == '') {
			return json_encode([
				'status' => 'error',
				'message' => 'Debe ingresar nombre y apellidos'
			]);
		} else {
			//VERIFICAR QUE NO EXISTA EL CLIENTE
			try {
				if ($this->modelClientes->obtenerClienteByNombreApellidos($data['nombre'], $data['apellidos'])) {
					return json_encode([
						'status' => 'error',
						'message' => 'El cliente ya existe'
					]);
				}
			} catch (\Throwable $th) {
				//throw $th;
				return json_encode([
					'status' => 'error',
					'message' => 'Error al registrar el cliente'
				]);
			}
			$this->modelClientes->registrarCliente($data);
			$consulta = $this->modelClientes->obtenerClienteByNombreApellidos($data['nombre'], $data['apellidos']);
			return json_encode([
				'status' => 'success',
				'id_cliente' => $consulta['id_cliente'],
				'nombre_apellidos' => $consulta['nombre'] . ' ' . $consulta['apellidos']
			]);
		}
	}

	//registro de reservacion
	public function registrarReservacion()
	{
		$this->validaruser();
		$data = [
			'id_cliente' => $this->request->getPost('id_cliente'),
			'id_usuario_reserva' => $this->session->get('id_usuario'),
			'fecha_servicio' => $this->request->getPost('fecha_servicio'),
			'hora_servicio' => $this->request->getPost('hora_servicio'),
			'num_pasajeros' => $this->request->getPost('num_pasajeros'),
			'domicilio_origen' => $this->request->getPost('domicilio_origen'),
			'domicilio_destino' => $this->request->getPost('domicilio_destino'),
			'costo_servicio' => $this->request->getPost('costo_servicio'),
			'notas' => $this->request->getPost('notas'),
			'status' => $this->request->getPost('status')
		];
		if ($data['id_cliente'] == '' || $data['fecha_servicio'] == '' || $data['hora_servicio'] == '' || $data['num_pasajeros'] == '' || $data['domicilio_origen'] == '' || $data['domicilio_destino'] == '' || $data['costo_servicio'] == '' || $data['status'] == '') {
			$this->session->setFlashdata('alerta', 'Debe ingresar todos los datos');
			return redirect()->to(base_url("Home/reservaciones"));
		}
		if ($this->modelReservaciones->registrarReservacion($data)) {
			//extraer datos del cliente
			$cliente = $this->modelClientes->obtenerCliente($data['id_cliente']);
			$data['correo'] = $cliente['correo'];
			$data['nombre'] = $cliente['nombre'];
			$data['apellidos'] = $cliente['apellidos'];
			$data['telefono'] = $cliente['telefono1'];
			if ($this->enviarCorreoReservacion($data)) {
				$this->session->setFlashdata('alerta', 'Reservacion registrada/enviada por correo correctamente');
				return redirect()->to(base_url("Home/reservaciones"));
			}
			$this->session->setFlashdata('alerta', 'Se registro reservacion pero hubo un error al enviar el correo');
			return redirect()->to(base_url("Home/reservaciones"));
		}
		$this->session->setFlashdata('alerta', 'Error al registrar la reservacion');
		return redirect()->to(base_url("Home/reservaciones"));
	}

	public function enviarCorreoReservacion($data)
	{
		$destinatario = $data['correo'];
		$titulo = "Confirmacion de reservacion";
		// Cuerpo del correo
		$cuerpo = '
        <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
                    <!--[if !mso]--><!-- -->
                    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet">
                    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet">
                    <!-- <![endif]-->

                    <title>SIR B.C.</title>

                    <style type="text/css">
                        body {
                            width: 100%;
                            background-color: #ffffff;
                            margin: 0;
                            padding: 0;
                            -webkit-font-smoothing: antialiased;
                            mso-margin-top-alt: 0px;
                            mso-margin-bottom-alt: 0px;
                            mso-padding-alt: 0px 0px 0px 0px;
                        }
                
                        p,
                        h1,
                        h2,
                        h3,
                        h4 {
                            margin-top: 0;
                            margin-bottom: 0;
                            padding-top: 0;
                            padding-bottom: 0;
                        }
                
                        span.preheader {
                            display: none;
                            font-size: 1px;
                        }
                
                        html {
                            width: 100%;
                        }
                
                        table {
                            font-size: 14px;
                            border: 0;
                        }
                        /* ----------- responsivity ----------- */
                
                        @media only screen and (max-width: 640px) {
                            /*------ top header ------ */
                            .main-header {
                                font-size: 20px !important;
                            }
                            .main-section-header {
                                font-size: 28px !important;
                            }
                            .show {
                                display: block !important;
                            }
                            .hide {
                                display: none !important;
                            }
                            .align-center {
                                text-align: center !important;
                            }
                            .no-bg {
                                background: none !important;
                            }
                            /*----- main image -------*/
                            .main-image img {
                                width: 440px !important;
                                height: auto !important;
                            }
                            /* ====== divider ====== */
                            .divider img {
                                width: 440px !important;
                            }
                            /*-------- container --------*/
                            .container590 {
                                width: 440px !important;
                            }
                            .container580 {
                                width: 400px !important;
                            }
                            .main-button {
                                width: 220px !important;
                            }
                            /*-------- secions ----------*/
                            .section-img img {
                                width: 320px !important;
                                height: auto !important;
                            }
                            .team-img img {
                                width: 100% !important;
                                height: auto !important;
                            }
                        }
                
                        @media only screen and (max-width: 479px) {
                            /*------ top header ------ */
                            .main-header {
                                font-size: 18px !important;
                            }
                            .main-section-header {
                                font-size: 26px !important;
                            }
                            /* ====== divider ====== */
                            .divider img {
                                width: 280px !important;
                            }
                            /*-------- container --------*/
                            .container590 {
                                width: 280px !important;
                            }
                            .container590 {
                                width: 280px !important;
                            }
                            .container580 {
                                width: 260px !important;
                            }
                            /*-------- secions ----------*/
                            .section-img img {
                                width: 280px !important;
                                height: auto !important;
                            }
                        }
                    </style>
                    <!-- [if gte mso 9]><style type=”text/css”>
                        body {
                        font-family: arial, sans-serif!important;
                        }
                        </style>
                    <![endif]-->
                </head>


                <body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                    <!-- pre-header -->
                    <table style="display:none!important;">
                        <tr>
                            <td>
                                <div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
                                    Nuevo mensaje
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- pre-header end -->

                    <!-- big image section -->
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

                        <tr>
                            <td align="center">
                                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                                    <tr>

                                        <td align="center" class="section-img">
                                            <a href="" style=" border-style: none !important; display: block; border: 0 !important;"><img src="https://taxisairport.com/assets/img/tt1_transparent.png" style="display: block; width: 590px;" width="400" border="0" alt="" /></a>




                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                                            <div style="line-height: 35px">

                                                Nuevo <span style="color: #003865;">Reservacion</span>

                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td align="center">
                                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                                <tr>
                                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td align="center">
                                            <table border="0" width="400" align="center" cellpadding="0" cellspacing="0" class="container590">
                                                <tr>
                                                    <td align="left" style="color: #888888; font-size: 16px; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px;">


                                                        <div style="line-height: 24px">
                                                            <h4>Nombre:</h4> <p>' . $data['nombre'] . '</p><br>
                                                            <h4>Apellidos:</h4> <p>' . $data['apellidos'] . '</p><br>
                                                            <h4>Correo:</h4> <p>' . $data['correo'] . '</p><br>
                                                            <h4>Telefono:</h4> <p>' . $data['telefono'] . '</p><br>
                                                            <h4>Fecha de la reservacion:</h4> <p>' . $data['fecha_servicio'] . '</p><br>
                                                            <h4>Hora de la reservacion:</h4> <p>' . $data['hora_servicio'] . '</p><br>
                                                            <h4>Numero de personas:</h4> <p>' . $data['num_pasajeros'] . '</p><br>
                                                            <h4>Domicilio de origen:</h4> <p>' . $data['domicilio_origen'] . '</p><br>
                                                            <h4>Domicilio de destino:</h4> <p>' . $data['domicilio_destino'] . '</p><br>
                                                            <h4>Notas:</h4> <p>' . $data['notas'] . '</p><br>
                                                
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                                    </tr>


                                </table>

                            </td>
                        </tr>

                    </table>
                    <!-- end section -->


                    <!-- footer ====== -->
                    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#d68501">

                        <tr>
                            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="center">

                                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                                    <tr>
                                        <td>
                                            <table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="container590">
                                                <tr>
                                                    <td align="left" style="color: #aaaaaa; font-size: 14px; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px;">
                                                        <div style="line-height: 24px;">

                                                            <span style="color: white;">Diseñado por Tech Hub</span>

                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
                        </tr>

                    </table>
                    <!-- end footer ====== -->
                </body>
        </html>';

		// Cabeceras
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: " . $data['nombre'] . " <" . $data['correo'] . ">\r\n";
		$headers .= "Reply-To: " . $data['correo'] . "\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
		$headers .= "X-Priority: 1\r\n";
		$headers .= "charset: utf-8\r\n";
		return false;
		// Enviar correo
		try {
			if (mail($destinatario, $titulo, $cuerpo, $headers)) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	//consultar datos de reservacion para editar
	public function consultaReservacion()
	{
		$this->validaruser();
		$id_reservacion = $this->request->getPost('id_reservacion');
		$data = $this->modelReservaciones->obtenerReservacion($id_reservacion);
		return json_encode($data);
	}

	//actualizar reservacion
	public function actualizarReservacion()
	{
		$this->validaruser();
		$data = [
			'id_reservacion' => $this->request->getPost('id_reservacionEditar'),
			'fecha_servicio' => $this->request->getPost('fecha_servicioEditar'),
			'hora_servicio' => $this->request->getPost('hora_servicioEditar'),
			'num_pasajeros' => $this->request->getPost('num_pasajerosEditar'),
			'domicilio_origen' => $this->request->getPost('domicilio_origenEditar'),
			'domicilio_destino' => $this->request->getPost('domicilio_destinoEditar'),
			'costo_servicio' => $this->request->getPost('costo_servicioEditar'),
			'notas' => $this->request->getPost('notasEditar'),
			'status' => $this->request->getPost('statusEditar'),
		];
		if ($this->modelReservaciones->actualizarReservacion($data)) {
			$this->session->setFlashdata('alerta', 'Reservacion actualizada correctamente');
			return redirect()->to(base_url("Home/reservaciones"));
		}
		$this->session->setFlashdata('alerta', 'Error al actualizar la reservacion');
		return redirect()->to(base_url("Home/reservaciones"));
	}

	//filtrar reservaciones
	public function filtrarReservaciones()
	{
		$this->validaruser();
		$estatus = $this->request->getPost('estatus');
		if ($estatus == 'PENDIENTE/CONFIRMADO') {
			$data = $this->modelReservaciones->obtenerReservacionesPendientesConfirmados();
		} else {
			$data = $this->modelReservaciones->obtenerReservacionesPorEstatus($estatus);
		}
		foreach ($data as $key => $row) {
			//OBTENER LOS DIAS FALTANTES SOLO LOS QUE TENGAN ESTATUS ESPERA Y CONFIRMADO
			if ($row['status'] == 'PENDIENTE' || $row['status'] == 'CONFIRMADO') {
				$data[$key]['dias_faltantes'] =
					$this->modelReservaciones->obtenerDiasFaltantes($row['fecha_servicio']);
			} else {
				$data[$key]['dias_faltantes'] = "";
			}
		}
		return json_encode($data);
	}

}
