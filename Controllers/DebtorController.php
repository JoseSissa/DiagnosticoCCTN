<?php

namespace Controllers;

use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Debtor;
use Model\CodebtorSummary;
use Model\CreditMailer;
use Model\Database;
use Model\Employee;
use Model\Independent;
use Model\Property;
use Model\Vehicle;
use Views\MainView;
use Views\NewCodebtorView;
use Views\SuccessView;

class DebtorController
{
	private $db;
	
	public function __construct(Database $db, CreditMailer $creditMailer) {
		$this->db = $db;
		$this->creditMailer = $creditMailer;
	}
	
	public function checkHoneypot($input_name): bool {
		$honeypot = Input::Any($input_name);
		if ($honeypot != "")
		{
			return true;
		}
		return false;
	}
	
	public function abrirFormularioDeudor() {

		$listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();
		new MainView($listado_ciudades, $listado_actividades_economicas);
	}

	public function guardarDatosNuevoFormulario() {
		// echo "Hola mundoo";
		// echo $_POST;
		// return $_POST;
	}
	
	public function registrarDatos() {
		$debtor = new Debtor();
		$debtor->fromInput();
		
		$id = $this->db->registerDebtorData($debtor);
		
		if (($id > 0) == false) {
			die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
		}
		
		$numero_identificacion = "";
		if ($debtor->tipo_persona == "natural") {
			$numero_identificacion = $debtor->numero_identificacion;
		}
		else if ($debtor->tipo_persona == "juridica") {
			$numero_identificacion = $debtor->numero_identificacion_representante_legal;
			$nit = $debtor->nit;

			$this->subirEstadosFinancieros($id, $nit);
		}
		$this->subirCedula($numero_identificacion, $id);
		
		$this->registrarAPIMundosoft($debtor);

        $arrayUid = $this->db->getCodebtorsUidsByDebtorId($id);
		if ($id > 0) {
			if ($this->enviarCorreoDeudor($id) > 0) {
				if ($this->enviarCorreoDeudorAdmin($id) > 0) {
					new SuccessView($id, $arrayUid);
				}
				else {
					new SuccessView($id, $arrayUid);
					//die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
				}
			}
			else {
				new SuccessView($id, $arrayUid);
				//die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
			}
		}
		else {
			die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
		}
	}
	
	public function enviarCorreoDeudor($id) {
		$success = 1;
		
		$debtor = $this->db->getDebtorData($id);
		$codebtors_summary = $this->db->getCodebtorsSummary($id);
		
		for ($i = 0; $i < count($codebtors_summary); $i++) {
			
			$res = $this->creditMailer->sendDebtorMailToCodebtor($debtor, $codebtors_summary[$i]);
			if ($res == false) $success = 0;
		}
		$res = $this->creditMailer->sendDebtorMailToDebtor($debtor, $codebtors_summary);
		if ($res == false) $success = 0;
		
		return $success;
	}
	
	public function enviarCorreoDeudorAdmin($id) {
		$success = 1;
		
		$debtor = $this->db->getDebtorData($id);
		$res = $this->creditMailer->sendDebtorMailToAdmin($debtor);
		if ($res == false) $success = 0;
		
		return $success;
	}
	
	public function guardarSesion() {
		$debtor = new Debtor();
		$debtor->guardarSesion();
	}
	
	public function guardarDatosTemporales() {
		$debtor = new Debtor();
		$debtor->fromInput();
		echo $this->db->registerTempDebtorData($debtor);
	}
	
	public function subirCedula($num_documento, $uid) {
		
		$consecutivo = $this->db->getDebtorDocumentConsecutive($num_documento);
		
		//$filename = $_FILES['file']['name'];
		$filename = "documento_" . $num_documento . "_" . $consecutivo . "_" . date("Y_m_d_H_i_s");
		
		/* Location */
		$location = "Uploaded/DocumentoIdentidad/" . $filename;
		$uploadOk = 1;
		$imageFileType = pathinfo($_FILES['adjuntar_cedula']['name'], PATHINFO_EXTENSION);
		$location = $location . "." . $imageFileType;

		/* Valid Extensions */
		$valid_extensions = array("jpg","jpeg","png","pdf");
		/* Check file extension */
		if ( !in_array(strtolower($imageFileType),$valid_extensions) ) {
		   $uploadOk = 0;
		}

		if ($uploadOk == 0){
		   return 0;
		} else {
		   /* Upload file */
		   if (move_uploaded_file($_FILES['adjuntar_cedula']['tmp_name'], $location)){
			  $this->db->registerDebtorDocument($location, $uid);
			  return $location;
		   } else {
			  return 0;
		   }
		}
	}

	public function subirEstadosFinancieros($id, $nit) {

		//$cantidad_estados_financieros = $_POST['cantidad_estados_financieros'];
		$cantidad_estados_financieros = count($_FILES['adjuntar_estados_financieros']['name']);

		for ($i = 0; $i < $cantidad_estados_financieros; $i++) {

			//$filename = $_FILES['file']['name'];
			$filename = "estados_financieros_" . $nit . "_" . $i . "_" . date("Y_m_d_H_i_s");

			/* Location */
			$location = "Uploaded/EstadosFinancieros/" . $filename;
			$uploadOk = 1;
			$imageFileType = pathinfo($_FILES['adjuntar_estados_financieros']['name'][$i], PATHINFO_EXTENSION);
			$location = $location . "." . $imageFileType;

			/* Valid Extensions */
			$valid_extensions = array("jpg","jpeg","png","pdf");
			/* Check file extension */
			if ( !in_array(strtolower($imageFileType),$valid_extensions) ) {
			   $uploadOk = 0;
			}

			if ($uploadOk == 0){
			   //return 0;
			} else {
			   /* Upload file */
			   if (move_uploaded_file($_FILES['adjuntar_estados_financieros']['tmp_name'][$i], $location)){
				  $this->db->registerFinancialStatement($location, $id, 0, $nit);
				  //return $location;
			   } else {
				  //return 0;
			   }
			}

		}
	}
	
	public function finalizarRegistro() {
		$id = Input::Any('id');
		$arrayUid = $this->db->getCodebtorsUidsByDebtorId($id);
		new SuccessView($id, $arrayUid);
	}
	
	public function abrirFormularioNuevoCodeudor() {
		$num_radicado = Input::Any('num_radicado');
		
		if (Input::Any('num_radicado') == null || Input::Any('num_radicado') == "") {
			Url::redirect('/error');
		}
		
		$debtorData = $this->db->getDebtorData($num_radicado);
		if ($debtorData == -1) {
			Url::redirect('/error');
		}
		
		if ($debtorData->tipo_persona == "juridica") {
			$nombre_deudor = $debtorData->nombre_empresa;
		}
		else {
			$nombre_deudor = $debtorData->nombres . " " . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido;
		}
		
		$listado_codeudores = $this->db->getCodebtorsSummary($num_radicado);
		new NewCodebtorView($num_radicado, $nombre_deudor, $listado_codeudores);
	}
	
	public function registrarNuevoCodeudor() {
		$id_deudor = Input::Any('id_deudor');
		
		if (Input::Any('id_deudor') == null || Input::Any('id_deudor') == "") {
			Url::redirect('/error');
		}
		
		$div_codeudores_ids = preg_filter('/^nombre_codeudor_deudor_(.*)/', '$1', array_keys($_POST));
		$codeudores_arr = array();
		foreach ($div_codeudores_ids as $item) {
			$nombres = htmlspecialchars(Input::Any('nombre_codeudor_deudor_' . $item), ENT_QUOTES);
			$celular = htmlspecialchars(Input::Any('celular_codeudor_deudor_' . $item), ENT_QUOTES);
			$correo = htmlspecialchars(Input::Any('correo_codeudor_deudor_' . $item), ENT_QUOTES);
			
			$codeudor = new CodebtorSummary(null, null, $nombres, $celular, $correo);
			$codeudor->id = $item;
			
			array_push($codeudores_arr, $codeudor);
		}
		if (sizeof($codeudores_arr) > 0) {
			$result = $this->db->registerCodebtor($id_deudor, json_encode($codeudores_arr));
			if ($result == 1) {
				$res = $this->enviarCorreoNuevoCodeudor($id_deudor, $div_codeudores_ids);
				if ($res == false) die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
				header("Location: " . "registro_finalizado?id=" . $id_deudor);
			}
			else {
				die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
			}
		}
		else {
			die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
		}
	}
	
	public function eliminarCodeudor() {
		$uid = Input::Any('uid');
		
		echo $this->db->deleteCodebtor($uid);
	}
	
	public function enviarCorreoNuevoCodeudor($id_deudor, $div_codeudores_ids) {
		$success = 1;
		
		$debtor = $this->db->getDebtorData($id_deudor);
		$codebtors_summary = $this->db->getCodebtorsSummary($id_deudor);
		
		for ($i = 0; $i < count($codebtors_summary); $i++) {
			foreach ($div_codeudores_ids as $item) {
				$correo = htmlspecialchars(Input::Any('correo_codeudor_deudor_' . $item), ENT_QUOTES);
				if ($correo == $codebtors_summary[$i]->correo) {
					$res = $this->creditMailer->sendDebtorMailToCodebtor($debtor, $codebtors_summary[$i]);
					if ($res == false) $success = 0;
				}
			}
		}
		$res = $this->creditMailer->sendNewCodebtorMailToDebtor($debtor, $codebtors_summary);
		if ($res == false) $success = 0;
		return $success;
	}
	
	public function enviarCorreoNuevoCodeudorAdmin() {
		$id_deudor = Input::Any('id_deudor');
		$debtor = $this->db->getDebtorData($id_deudor);
		$codebtors_summary = $this->db->getCodebtorsSummary($id_deudor);
		
		echo $this->creditMailer->sendNewCodebtorMailToAdmin($debtor, $codebtors_summary);
	}

	public function registrarAPIMundosoft($debtor) {
		$tipoPersona = $debtor->tipo_persona;
		if ($tipoPersona == "juridica") {
			switch ($debtor->tipo_identificacion) {
				case "cedula_ciudadania":
					$datosgenerales_tipo_identificacion = 'C';
					break;
				case "cedula_ciudadania":
					$datosgenerales_tipo_identificacion = 'E';
					break;
				default:
					$datosgenerales_tipo_identificacion = 'C';
					break;
			}
			$datosgenerales_identificacion = str_replace(".", "", $debtor->numero_identificacion);
			$datosgenerales_fecha_nacimiento = '1999-01-01';
			$datosgenerales_fecha_exp_doc = date('Y-m-d', strtotime($datosgenerales_fecha_nacimiento . ' +18 years')); //No se pide
			$datosgenerales_ocupacion = '0001'; //No se pide
			$datosgenerales_personas_a_cargo = 0;
			$datosgenerales_nombres = $debtor->nombres;
			$datosgenerales_apellidos = $debtor->primer_apellido . " " . $debtor->segundo_apellido;
			$datosgenerales_lugar_nacimiento = '54003';  //No se pide
			$datosgenerales_genero = 'M'; //No se pide
			switch ($debtor->estado_civil) {
				case "soltero":
					$datosgenerales_estado_civil = 1;
					break;
				case "casado":
					$datosgenerales_estado_civil = 2;
					break;
				case "separado":
					$datosgenerales_estado_civil = 5;
					break;
				case "viudo":
					$datosgenerales_estado_civil = 6;
					break;
				case "union_libre":
					$datosgenerales_estado_civil = 3;
					break;
				default:
					$datosgenerales_estado_civil = 7;
					break;
			}
			$datosgenerales_lugar_exp_documento = '05004'; //No se pide
			$datosgenerales_profesion = 'ADMFIN'; //No se pide
			$datosgenerales_estrato = '1'; //No se pide
			$datosgenerales_peso = 1; //No se pide
			$datosgenerales_estatura = 1; //No se pide
			$datosgenerales_nivel_formacion = 'POS'; //No se pide
			$datosgenerales_caja_compensacion = 'A'; //No se pide
			$datosgenerales_persona_expuesta = 'N'; //No se pide
			$datosgenerales_reporta_centrales = 'N'; //No se pide
			$datosdirecciones_estrato = $debtor->estrato;
			$datosdirecciones_direccion = $debtor->barrio;
			$datosdirecciones_ciudad = $debtor->ciudad;
			switch ($debtor->tipo_vivienda) {
				case "arrendada":
					$datosdirecciones_tipo_vivienda = '0001';
					break;
				case "propia":
					$datosdirecciones_tipo_vivienda = '0003';
					break;
				case "familiar":
					$datosdirecciones_tipo_vivienda = '0002';
					break;
				default:
					$datosdirecciones_tipo_vivienda = '0003';
					break;
			}
			$datosdirecciones_barrio = ' '; //No se pide
			$datostelefonos_numero = $debtor->celular;
			$datostelefonos_extension = '1'; //No se pide
			$datostelefonos_ciudad = '68001'; //No se pide
			$datoscorreos_correo = $debtor->correo;
			$datosinformacionlaboral = array();
			foreach(json_decode($debtor->empleados) as $empleado) {
				array_push($datosinformacionlaboral,
					array(
						'empresa' => $empleado->empresa,
						'tipo_cargo' => 1,
						'ciudad' => '68001', //No se pide
						'tiempo_servicio' => $empleado->duracion_cantidad,
						'fecha_fin' => $empleado->fin_contrato,
						'cargo' => ' ',
					)
				);
			}
			foreach(json_decode($debtor->independientes) as $independiente) {
				$tipo_contrato = '03';
				switch ($debtor->tipo_vivienda) {
					case "laboral_fijo":
						$tipo_contrato = '01';
						break;
					case "laboral_indefinido":
						$tipo_contrato = '02';
						break;
					case "prestacion_servicios":
						$tipo_contrato = '03';
						break;
					case "obra_labor":
						$tipo_contrato = '03';
						break;
					default:
						$tipo_contrato = '03';
						break;
				}
				array_push($datosinformacionlaboral,
					array(
						'empresa' => $independiente->empresa,
						'tipo_cargo' => 1,
						'ciudad' => '68001', //No se pide
						'actividad' => $tipo_contrato,
						'tiempo_servicio' => 0,
						'cargo' => ' ',
					)
				);
			}
			$datosinformacionfinanciera_salarios = 1;
			$datosinformacionfinanciera_otros_ingresos = 1;
			$datosinformacionfinanciera_ing_no_operacionales = 1;
			$datosinformacionfinanciera_arrendamientos = 1;
			$datosinformacionfinanciera_obligaciones = 1;
			$datosinformacionfinanciera_otros_gastos = 1;
			$datosinmuebles_tipo_inmueble = 1;
			$datosinmuebles_valor_comercial_inmueble = 1;
			$datosinmuebles_porcentaje_propiedad_inmueble = 1;
			$datosinmuebles_limitacion_inmueble = 'a';
			$datoscodeudor = array();
			foreach(json_decode($debtor->codeudores) as $codeudor) {
				array_push($datoscodeudor,
					array(
						'tipo_identificacion' => 'C',
						'identificacion' => '12345678901',
						'nombres' => 'invalido',
						'apellidos' => 'invalido',
						'celular' => $codeudor->celular,
						'email' => $codeudor->correo,
					)
				);
			}
			$datosvehiculos = array();
			foreach(json_decode($debtor->vehiculos) as $vehiculo) {
				array_push($datosvehiculos,
					array(
						'placa' => $vehiculo->placa,
						'limitacion' => 'a',
						'valor_comercial' => $codeudor->valor_comercial,
					)
				);
			}
			$datosmotivosolicitud_motivos_solicitud = 'a';
			$datosmotivosolicitud_motivo_solicitud = 'a';
			$datosmotivosolicitud_solicitud = 'a';
			$datosvalorescredito_tipo_de_radicacion = '2';
			$datosvalorescredito_codigo_linea = '10001';
			$datosvalorescredito_valor_a_pagar = $debtor->valor_solicitado;
			$datosvalorescredito_porcentaje_cubrimiento = 100;
			$datosvalorescredito_saldo = 0;
			$datosterminosaceptacion_aceptado = 'S';
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:31272/mundosoft/certificar");
			curl_setopt($ch, CURLOPT_POST, 1);

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			$decoded_response = json_decode($server_output);
			$token = $decoded_response->data->token;
			$conexion = $decoded_response->data->conexiones[0]->codigo;
			$user = $decoded_response->data->conexiones[0]->descripcion;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://www.mundosoft.com.co:8080/Mundosoft/backend/public/login");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$params = array(
				'token' => $token
			);

			$user = "COMERCIAL";
			$password = "ComVanka22";
			$password = hash('sha256', $password);



			$asd = array(
				'user' => $user,
				'password' => $password,
				'from' => 'sistema',
				'conexion' => $conexion
			);

			$myJSON = json_encode($asd);

			$payload = json_encode(array("parameters" => $params, "data" => array($asd)));

			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$log = json_decode($server_output)->mesagge;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			$token = json_decode($server_output)->data->token;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://www.mundosoft.com.co:8080/Mundosoft/backend/public/backend/ws/v1");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$params = array(
				'service' => 'radicacion_fachada_store',
				'token' => $token,
				'user' => $user,
				'conexion' => $conexion
			);


			$repositorio = array(
				'codigo_formulario' => 4,
				'codigo_ruta' => 24,
				'datosgenerales' => array(
					'codigo_bloque' => '28',
					'identificacion' => '111111111',
					'tipo_identificacion' => 'C',
					'fecha_nacimiento' => $datosgenerales_fecha_nacimiento,
					'fecha_exp_doc' => $datosgenerales_fecha_exp_doc,
					'ocupacion' => $datosgenerales_ocupacion,
					'personas_a_cargo' => $datosgenerales_personas_a_cargo,
					'nombres' => 'invalido',
					'apellidos' => 'invalido',
					'lugar_nacimiento' => $datosgenerales_lugar_nacimiento,
					'genero' => $datosgenerales_genero,
					'estado_civil' => $datosgenerales_estado_civil,
					'lugar_exp_documento' => $datosgenerales_lugar_exp_documento,
					'profesion' => $datosgenerales_profesion,
					'estrato' => $datosgenerales_estrato,
					'identificacion_tributaria' => 'invalido',
					//'razon_social' => 'abcdef',
					//'actividad_economica' => '80',
					//'fecha_constitucion' => '2009-01-01T05:00:00.000Z',
				),
				'datosmotivosolicitud' => array(
					'codigo_bloque' => '11',
					'motivos_solicitud' => $datosmotivosolicitud_motivos_solicitud,
					'motivo_solicitud' => $datosmotivosolicitud_motivo_solicitud,
					'solicitud' => $datosmotivosolicitud_solicitud,
				),
				'datosvalorescredito' => array(
					'codigo_bloque' => '16',
					'coleccion' => array(array(
						'tipo_de_radicacion' => $datosvalorescredito_tipo_de_radicacion,
						'codigo_linea' => 10001,
						'valor_a_pagar' => $datosvalorescredito_valor_a_pagar,
						'porcentaje_cubrimiento' => $datosvalorescredito_porcentaje_cubrimiento,
						'saldo' => $datosvalorescredito_saldo,
					)),
				),
				'datosterminosaceptacion' => array(
					'codigo_bloque' => '13',
					'aceptado' => $datosterminosaceptacion_aceptado,
				),
			);

			$data = array(
				'numero_solicitud' => 1,
				'repositorio' => $repositorio,
			);

			$payload = json_encode(array("parameters" => $params, "data" => array($data)));

			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			if ($token != "" || $token != null)	$tok_out = "true";
			else $tok_out = "false";

			$log = $log . "\r\nConexion: " . $conexion . "\r\nUsuario: " . $user . "\r\nToken: " . $tok_out . "\r\n" . $server_output;
			
			$this->db->log($log);
		}
		else {
			switch ($debtor->tipo_identificacion) {
				case "cedula_ciudadania":
					$datosgenerales_tipo_identificacion = 'C';
					break;
				case "cedula_ciudadania":
					$datosgenerales_tipo_identificacion = 'E';
					break;
				default:
					$datosgenerales_tipo_identificacion = 'C';
					break;
			}
			$datosgenerales_identificacion = str_replace(".", "", $debtor->numero_identificacion);
			$datosgenerales_fecha_nacimiento = $debtor->fecha_nacimiento;
			$datosgenerales_fecha_exp_doc = date('Y-m-d', strtotime($datosgenerales_fecha_nacimiento . ' +18 years')); //No se pide
			$datosgenerales_ocupacion = '0001'; //No se pide
			$datosgenerales_personas_a_cargo = $debtor->personas_a_cargo;
			$datosgenerales_nombres = $debtor->nombres;
			$datosgenerales_apellidos = $debtor->primer_apellido . " " . $debtor->segundo_apellido;
			$datosgenerales_lugar_nacimiento = '54003';  //No se pide
			$datosgenerales_genero = 'M'; //No se pide
			switch ($debtor->estado_civil) {
				case "soltero":
					$datosgenerales_estado_civil = 1;
					break;
				case "casado":
					$datosgenerales_estado_civil = 2;
					break;
				case "separado":
					$datosgenerales_estado_civil = 5;
					break;
				case "viudo":
					$datosgenerales_estado_civil = 6;
					break;
				case "union_libre":
					$datosgenerales_estado_civil = 3;
					break;
				default:
					$datosgenerales_estado_civil = 7;
					break;
			}
			$datosgenerales_lugar_exp_documento = '05004'; //No se pide
			$datosgenerales_profesion = 'ADMFIN'; //No se pide
			$datosgenerales_estrato = $debtor->estrato; //No se pide
			$datosgenerales_peso = 1; //No se pide
			$datosgenerales_estatura = 1; //No se pide
			$datosgenerales_nivel_formacion = 'POS'; //No se pide
			$datosgenerales_caja_compensacion = 'A'; //No se pide
			$datosgenerales_persona_expuesta = 'N'; //No se pide
			$datosgenerales_reporta_centrales = 'N'; //No se pide
			$datosdirecciones_estrato = $debtor->estrato;
			$datosdirecciones_direccion = $debtor->barrio;
			$datosdirecciones_ciudad = $debtor->ciudad;
			switch ($debtor->tipo_vivienda) {
				case "arrendada":
					$datosdirecciones_tipo_vivienda = '0001';
					break;
				case "propia":
					$datosdirecciones_tipo_vivienda = '0003';
					break;
				case "familiar":
					$datosdirecciones_tipo_vivienda = '0002';
					break;
				default:
					$datosdirecciones_tipo_vivienda = '0003';
					break;
			}
			$datosdirecciones_barrio = ' '; //No se pide
			$datostelefonos_numero = $debtor->celular;
			$datostelefonos_extension = '1'; //No se pide
			$datostelefonos_ciudad = '68001'; //No se pide
			$datoscorreos_correo = $debtor->correo;
			$datosinformacionlaboral = array();
			foreach(json_decode($debtor->empleados) as $empleado) {
				array_push($datosinformacionlaboral,
					array(
						'empresa' => $empleado->empresa,
						'tipo_cargo' => 1,
						'ciudad' => '68001', //No se pide
						'tiempo_servicio' => $empleado->duracion_cantidad,
						'fecha_fin' => $empleado->fin_contrato,
						'cargo' => ' ',
					)
				);
			}
			foreach(json_decode($debtor->independientes) as $independiente) {
				$tipo_contrato = '03';
				switch ($debtor->tipo_vivienda) {
					case "laboral_fijo":
						$tipo_contrato = '01';
						break;
					case "laboral_indefinido":
						$tipo_contrato = '02';
						break;
					case "prestacion_servicios":
						$tipo_contrato = '03';
						break;
					case "obra_labor":
						$tipo_contrato = '03';
						break;
					default:
						$tipo_contrato = '03';
						break;
				}
				array_push($datosinformacionlaboral,
					array(
						'empresa' => $independiente->empresa,
						'tipo_cargo' => 1,
						'ciudad' => '68001', //No se pide
						'actividad' => $tipo_contrato,
						'tiempo_servicio' => 0,
						'cargo' => ' ',
					)
				);
			}
			$datosinformacionfinanciera_salarios = 1;
			$datosinformacionfinanciera_otros_ingresos = 1;
			$datosinformacionfinanciera_ing_no_operacionales = 1;
			$datosinformacionfinanciera_arrendamientos = 1;
			$datosinformacionfinanciera_obligaciones = 1;
			$datosinformacionfinanciera_otros_gastos = 1;
			$datosinmuebles_tipo_inmueble = 1;
			$datosinmuebles_valor_comercial_inmueble = 1;
			$datosinmuebles_porcentaje_propiedad_inmueble = 1;
			$datosinmuebles_limitacion_inmueble = 'a';
			$datoscodeudor = array();
			foreach(json_decode($debtor->codeudores) as $codeudor) {
				array_push($datoscodeudor,
					array(
						'nombres' => $codeudor->nombres,
						'apellidos' => $codeudor->nombres,
						'celular' => $codeudor->celular,
						'email' => $codeudor->correo,
					)
				);
			}
			$datosvehiculos = array();
			foreach(json_decode($debtor->vehiculos) as $vehiculo) {
				array_push($datosvehiculos,
					array(
						'placa' => $vehiculo->placa,
						'limitacion' => 'a',
						'valor_comercial' => $codeudor->valor_comercial,
					)
				);
			}
			$datosmotivosolicitud_motivos_solicitud = 'a';
			$datosmotivosolicitud_motivo_solicitud = 'a';
			$datosmotivosolicitud_solicitud = 'a';
			$datosvalorescredito_tipo_de_radicacion = '2';
			$datosvalorescredito_codigo_linea = '10001';
			$datosvalorescredito_valor_a_pagar = $debtor->valor_solicitado;
			$datosvalorescredito_porcentaje_cubrimiento = 100;
			$datosvalorescredito_saldo = 0;
			$datosterminosaceptacion_aceptado = 'S';
			
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:31272/mundosoft/certificar");
			curl_setopt($ch, CURLOPT_POST, 1);

			// Receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			$decoded_response = json_decode($server_output);
			$token = $decoded_response->data->token;
			$conexion = $decoded_response->data->conexiones[0]->codigo;
			$user = $decoded_response->data->conexiones[0]->descripcion;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://www.mundosoft.com.co:8080/Mundosoft/backend/public/login");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$params = array(
				'token' => $token
			);

			$user = "COMERCIAL";
			$password = "ComVanka22";
			$password = hash('sha256', $password);



			$asd = array(
				'user' => $user,
				'password' => $password,
				'from' => 'sistema',
				'conexion' => $conexion
			);

			$myJSON = json_encode($asd);

			$payload = json_encode(array("parameters" => $params, "data" => array($asd)));

			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$log = json_decode($server_output)->mesagge;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			$token = json_decode($server_output)->data->token;

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"https://www.mundosoft.com.co:8080/Mundosoft/backend/public/backend/ws/v1");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$params = array(
				'service' => 'radicacion_fachada_store',
				'token' => $token,
				'user' => $user,
				'conexion' => $conexion
			);

			$repositorio = array(
				'codigo_formulario' => 3,
				'codigo_ruta' => 21,
				'datosgenerales' => array(
					'codigo_bloque' => '1',
					'tipo_identificacion' => $datosgenerales_tipo_identificacion,
					'identificacion' => $datosgenerales_identificacion,
					'fecha_nacimiento' => $datosgenerales_fecha_nacimiento,
					'fecha_exp_doc' => $datosgenerales_fecha_exp_doc,
					'ocupacion' => $datosgenerales_ocupacion,
					'personas_a_cargo' => $datosgenerales_personas_a_cargo,
					'nombres' => $datosgenerales_nombres,
					'apellidos' => $datosgenerales_apellidos,
					'lugar_nacimiento' => $datosgenerales_lugar_nacimiento,
					'genero' => $datosgenerales_genero,
					'estado_civil' => $datosgenerales_estado_civil,
					'lugar_exp_documento' => $datosgenerales_lugar_exp_documento,
					'profesion' => $datosgenerales_profesion,
					'estrato' => $datosgenerales_estrato,
					//'avatar' => '666666546',
					//'foto_perfil' => 'resources\/img\/perfil.png',
					'peso' => $datosgenerales_peso,
					'estatura' => $datosgenerales_estatura,
					'nivel_formacion' => $datosgenerales_nivel_formacion,
					'caja_compensacion' => $datosgenerales_caja_compensacion,
					'persona_expuesta' => $datosgenerales_persona_expuesta,
					'reporta_centrales' => $datosgenerales_reporta_centrales,
				),
				'datosdirecciones' => array(
					'codigo_bloque' => '2',
					'coleccion' => array(array(
						'estrato' => $datosdirecciones_estrato,
						'direccion' => $datosdirecciones_direccion,
						'ciudad' => $datosdirecciones_ciudad,
						'barrio' => $datosdirecciones_barrio,
						'tipo_vivienda' => $datosdirecciones_tipo_vivienda,
					)),
				),
				'datostelefonos' => array(
					'codigo_bloque' => '3',
					'coleccion' => array(array(
						'extension' => $datostelefonos_extension,
						'ciudad' => $datostelefonos_ciudad,
					)),
				),
				'datoscorreos' => array(
					'codigo_bloque' => '4',
					'coleccion' => array(array(
						'correo' => $datoscorreos_correo,
					)),
				),
				'datosinformacionlaboral' => array(
					'codigo_bloque' => '5',
					'coleccion' => $datosinformacionlaboral,
				),
				'datosinformacionfinanciera' => array(
					'codigo_bloque' => '7',
					'coleccion' => array(array(
						'salarios' => $datosinformacionfinanciera_salarios,
						'otros_ingresos' => $datosinformacionfinanciera_otros_ingresos,
						'ing_no_operacionales' => $datosinformacionfinanciera_ing_no_operacionales,
						'arrendamientos' => $datosinformacionfinanciera_arrendamientos,
						'obligaciones' => $datosinformacionfinanciera_obligaciones,
						'otros_gastos' => $datosinformacionfinanciera_otros_gastos,
					)),
				),
				'datosinmuebles' => array(
					'codigo_bloque' => '8',
					'coleccion' => array(array(
						'tipo_inmueble' => $datosinmuebles_tipo_inmueble,
						'valor_comercial_inmueble' => $datosinmuebles_valor_comercial_inmueble,
						'porcentaje_propiedad_inmueble' => $datosinmuebles_porcentaje_propiedad_inmueble,
						'limitacion_inmueble' => $datosinmuebles_limitacion_inmueble,
					)),
				),
				'datosinformacioncodeudor' => array(
					'codigo_bloque' => '9',
					'coleccion' => $datoscodeudor,
				),
				'datosvehiculos' => array(
					'codigo_bloque' => '23',
					'coleccion' => $datosvehiculos,
				),
				'datosmotivosolicitud' => array(
					'codigo_bloque' => '11',
					'motivos_solicitud' => $datosmotivosolicitud_motivos_solicitud,
					'motivo_solicitud' => $datosmotivosolicitud_motivo_solicitud,
					'solicitud' => $datosmotivosolicitud_solicitud,
				),
				'datosvalorescredito' => array(
					'codigo_bloque' => '16',
					'coleccion' => array(array(
						'tipo_de_radicacion' => $datosvalorescredito_tipo_de_radicacion,
						'codigo_linea' => $datosvalorescredito_codigo_linea,
						'valor_a_pagar' => $datosvalorescredito_valor_a_pagar,
						'porcentaje_cubrimiento' => $datosvalorescredito_porcentaje_cubrimiento,
						'saldo' => $datosvalorescredito_saldo,
					)),
					/*'codigo_linea' => '10001',
					'valor_a_pagar' => '',
					'valor_crédito' => '',
					'porcentaje_cubrimiento' => 6,
					'saldo' => '',
					'numero_cuotas' => '',
					'empresa_libranza' => '',
					'aseguradora' => '',
					'corredor' => '',
					'tipo_radicacion' => '',
					'empresa' => '',
					'oficina' => '',*/
				),
				'datosterminosaceptacion' => array(
					'codigo_bloque' => '13',
					'aceptado' => $datosterminosaceptacion_aceptado,
				),
			);

			$data = array(
				'numero_solicitud' => 1,
				'repositorio' => $repositorio,
			);

			$payload = json_encode(array("parameters" => $params, "data" => array($data)));

			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close ($ch);

			if ($token != "" || $token != null)	$tok_out = "true";
			else $tok_out = "false";

			$log = $log . "\r\nConexion: " . $conexion . "\r\nUsuario: " . $user . "\r\nToken: " . $tok_out . "\r\n" . $server_output;
			
			$this->db->log($log);
		}
    }
}