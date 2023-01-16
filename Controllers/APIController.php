<?php

namespace Controllers;

use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Debtor;
use Model\CreditMailer;
use Model\Database;
use Model\SpreadsheetExporter;
use Views\AdminView;

class APIController
{
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function test() {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/auth");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_POST, TRUE);

		curl_setopt($ch, CURLOPT_POSTFIELDS, "{
		  \"username\": \"aux.contable@cincot.com\",
		  \"access_key\": \"YTQyMDg4MmMtNmVhZC00NzUxLTgyMTktY2EwNjE5ZTQ0ZjJhOjU4OThwNzUsblE=\"
		}");

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json"
		));

		$response = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($response);
		$response = $response->access_token;
		var_dump($response);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/products?created_start=");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  "Content-Type: application/json",
		  "Authorization: " . $response
		));

		$response = curl_exec($ch);
		curl_close($ch);

		var_dump($response);
	}
	
	public function setAPI() {
		//$this->test();
		//die();
		//exit();
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:31272/mundosoft/certificar");
		//curl_setopt($ch, CURLOPT_URL,"http://162.241.2.171:31272/mundosoft/certificar/");
		curl_setopt($ch, CURLOPT_POST, 1);
		/*curl_setopt($ch, CURLOPT_POSTFIELDS,
					"postvar1=value1&postvar2=value2&postvar3=value3");*/
		//curl_setopt($ch, CURLOPT_HEADER, true); 
		//curl_setopt($ch, CURLOPT_VERBOSE, true);

		// In real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS, 
		//          http_build_query(array('postvar1' => 'value1')));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close ($ch);
		
		$decoded_response = json_decode($server_output);
		$token = $decoded_response->data->token;
		$conexion = $decoded_response->data->conexiones[0]->codigo;
		$user = $decoded_response->data->conexiones[0]->descripcion;
		$this->sendPost($token, $conexion, $user);

	}
	
	public function sendPost($token, $conexion, $user) {
		$user = "COMERCIAL";
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
		
		//$data = [ $myJSON ];
		
		//die(var_dump(json_encode($data)));

		//die(var_dump($data));
		
		$payload = json_encode(array("parameters" => $params, "data" => array($asd)));
		
		//die(var_dump($payload));
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		var_dump(json_decode($server_output)->mesagge);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close ($ch);
		
		$token = json_decode($server_output)->data->token;
		//die(var_dump(json_decode($server_output)->data->token));
		$this->sendPost2($token, $conexion, $user);

	}
	
	public function sendPost2($token, $conexion, $user) {
		//die(var_dump($token));
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
		
		$repositorio_old = array(
			'codigo_formulario' => 3,
			'codigo_ruta' => 25,
			'datosgenerales' => array(
				'codigo_bloque' => '1',
				'tipo_identificacion' => 'C',
				'fecha_nacimiento' => '666666546',
				'fecha_exp_doc' => '2009-01-01T05:00:00.000Z',
				'ocupacion' => '0001',
				'personas_a_cargo' => 0,
				'nombres' => 'Pedro',
				'apellidos' => 'Garcia',
				'lugar_nacimiento' => '54003',
				'genero' => 'M',
				'estado_civil' => 'S',
				'lugar_exp_documento' => '05004',
				'profesion' => 'ADMFIN',
				'estrato' => 4,
				//'avatar' => '666666546',
				//'foto_perfil' => 'resources\/img\/perfil.png',
				'peso' => 1,
				'estatura' => 1,
				'nivel_formacion' => 'POS',
				'caja_compensacion' => 'A',
				'persona_expuesta' => 'N',
				'reporta_centrales' => 'N'
			),
			'datosvalorescredito' => array(
				'codigo_bloque' => '16',
				'coleccion' => array(array(
					'tipo_de_radicacion' => '2',
					'codigo_linea' => '10001',
					'valor_a_pagar' => 0,
					'porcentaje_cubrimiento' => 100,
					'saldo' => 0,
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
				'aceptado' => 'S'
			),
		);
		
		$repositorio_old_2 = array(
			'codigo_formulario' => 3,
			'codigo_ruta' => 25,
			'datosgenerales' => array(
				'codigo_bloque' => '1',
				'tipo_identificacion' => 'C',
				'identificacion' => '123456789',
				'fecha_nacimiento' => '666666546',
				'fecha_exp_doc' => '2009-01-01T05:00:00.000Z',
				'ocupacion' => '0001',
				'personas_a_cargo' => 0,
				'nombres' => 'Pedro',
				'apellidos' => 'Garcia',
				'lugar_nacimiento' => '54003',
				'genero' => 'M',
				'estado_civil' => 'S',
				'lugar_exp_documento' => '05004',
				'profesion' => 'ADMFIN',
				'estrato' => 4,
				//'avatar' => '666666546',
				//'foto_perfil' => 'resources\/img\/perfil.png',
				'peso' => 1,
				'estatura' => 1,
				'nivel_formacion' => 'POS',
				'caja_compensacion' => 'A',
				'persona_expuesta' => 'N',
				'reporta_centrales' => 'N'
			),
			'datosdirecciones' => array(
				'codigo_bloque' => '2',
				'coleccion' => array(array(
					'estrato' => '3',
					'direccion' => 'asd',
					'ciudad' => '68001',
					'tipo_vivienda' => '0001',
				)),
			),
			'datostelefonos' => array(
				'codigo_bloque' => '3',
				'coleccion' => array(array(
					'extension' => '1',
					'ciudad' => '68001',
				)),
			),
			'datoscorreos' => array(
				'codigo_bloque' => '4',
				'coleccion' => array(array(
					'correo' => 'a',
				)),
			),
			'datosinformacionlaboral' => array(
				'codigo_bloque' => '5',
				'coleccion' => array(array(
					'empresa' => 'a',
					'tipo_cargo' => 1,
					'cargo' => 1,
					'ciudad' => '68001',
				)),
			),
			'datosinformacionfinanciera' => array(
				'codigo_bloque' => '7',
				'coleccion' => array(array(
					'salarios' => 1,
				)),
			),
			'datosinmuebles' => array(
				'codigo_bloque' => '8',
				'coleccion' => array(array(
					'tipo_inmueble' => 1,
				)),
			),
			/*'datosinformacioncodeudor' => array(
				'codigo_bloque' => '9',
				'coleccion' => array(array(
					'tipo_identificacion' => 1,
					'nombres' => 'daniel',
					'apellidos' => 'diaz',
				)),
			),*/
			'datosmotivosolicitud' => array(
				'codigo_bloque' => '11',
				'motivos_solicitud' => 'a',
				'motivo_solicitud' => 'a',
				'solicitud' => 'a',
			),
			'datosvalorescredito' => array(
				'codigo_bloque' => '16',
				'coleccion' => array(array(
					'tipo_de_radicacion' => '2',
					'codigo_linea' => '10001',
					'valor_a_pagar' => 0,
					'porcentaje_cubrimiento' => 100,
					'saldo' => 0,
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
				'aceptado' => 'S'
			),
		);
		
		$repositorio_old_3 = array(
			'codigo_formulario' => 4,
			'codigo_ruta' => 21,
			'datosgenerales' => array(
				'codigo_bloque' => '1',
				'tipo_identificacion' => 'C',
				'identificacion' => '123456789',
				'fecha_nacimiento' => '666666546',
				'fecha_exp_doc' => '2009-01-01T05:00:00.000Z',
				'ocupacion' => '0001',
				'personas_a_cargo' => 0,
				'nombres' => 'Pedro',
				'apellidos' => 'Garcia',
				'lugar_nacimiento' => '54003',
				'genero' => 'M',
				'estado_civil' => 'S',
				'lugar_exp_documento' => '05004',
				'profesion' => 'ADMFIN',
				'estrato' => 4,
				//'avatar' => '666666546',
				//'foto_perfil' => 'resources\/img\/perfil.png',
				'peso' => 1,
				'estatura' => 1,
				'nivel_formacion' => 'POS',
				'caja_compensacion' => 'A',
				'persona_expuesta' => 'N',
				'reporta_centrales' => 'N'
			),
			'datosdirecciones' => array(
				'codigo_bloque' => '2',
				'coleccion' => array(array(
					'estrato' => '3',
					'direccion' => 'asd',
					'ciudad' => '68001',
					'barrio' => ' ',
					'tipo_vivienda' => '0001',
				)),
			),
			'datostelefonos' => array(
				'codigo_bloque' => '3',
				'coleccion' => array(array(
					'extension' => '1',
					'ciudad' => '68001',
				)),
			),
			'datoscorreos' => array(
				'codigo_bloque' => '4',
				'coleccion' => array(array(
					'correo' => 'a',
				)),
			),
			'datosinformacionlaboral' => array(
				'codigo_bloque' => '5',
				'coleccion' => array(array(
					'empresa' => 'a',
					'tipo_cargo' => 1,
					'cargo' => 1,
					'ciudad' => '68001',
				)),
			),
			'datosinformacionfinanciera' => array(
				'codigo_bloque' => '7',
				'coleccion' => array(array(
					'salarios' => 1,
				)),
			),
			'datosinmuebles' => array(
				'codigo_bloque' => '8',
				'coleccion' => array(array(
					'tipo_inmueble' => 1,
				)),
			),
			/*'datosinformacioncodeudor' => array(
				'codigo_bloque' => '9',
				'coleccion' => array(array(
					'tipo_identificacion' => 1,
					'nombres' => 'daniel',
					'apellidos' => 'diaz',
				)),
			),*/
			'datosmotivosolicitud' => array(
				'codigo_bloque' => '11',
				'motivos_solicitud' => 'a',
				'motivo_solicitud' => 'a',
				'solicitud' => 'a',
			),
			'datosvalorescredito' => array(
				'codigo_bloque' => '16',
				'coleccion' => array(array(
					'tipo_de_radicacion' => '2',
					'codigo_linea' => '10001',
					'valor_a_pagar' => 0,
					'porcentaje_cubrimiento' => 100,
					'saldo' => 0,
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
				'aceptado' => 'S'
			),
		);
		
		$repositorio = array(
			'codigo_formulario' => 3,
			'codigo_ruta' => 21,
			'datosgenerales' => array(
				'codigo_bloque' => '1',
				'tipo_identificacion' => 'C',
				'identificacion' => '123456789',
				'fecha_nacimiento' => '666666546',
				'fecha_exp_doc' => '2009-01-01T05:00:00.000Z',
				'ocupacion' => '0001',
				'personas_a_cargo' => 0,
				'nombres' => 'Pedro',
				'apellidos' => 'Garcia',
				'lugar_nacimiento' => '54003',
				'genero' => 'M',
				'estado_civil' => 'S',
				'lugar_exp_documento' => '05004',
				'profesion' => 'ADMFIN',
				'estrato' => 4,
				//'avatar' => '666666546',
				//'foto_perfil' => 'resources\/img\/perfil.png',
				'peso' => 1,
				'estatura' => 1,
				'nivel_formacion' => 'POS',
				'caja_compensacion' => 'A',
				'persona_expuesta' => 'N',
				'reporta_centrales' => 'N'
			),
			'datosdirecciones' => array(
				'codigo_bloque' => '2',
				'coleccion' => array(array(
					'estrato' => '3',
					'direccion' => 'asd',
					'ciudad' => '68001',
					'barrio' => ' ',
					'tipo_vivienda' => '0001',
				)),
			),
			'datostelefonos' => array(
				'codigo_bloque' => '3',
				'coleccion' => array(array(
					'extension' => '1',
					'ciudad' => '68001',
				)),
			),
			'datoscorreos' => array(
				'codigo_bloque' => '4',
				'coleccion' => array(array(
					'correo' => 'a',
				)),
			),
			'datosinformacionlaboral' => array(
				'codigo_bloque' => '5',
				'coleccion' => array(array(
					'empresa' => 'a',
					'tipo_cargo' => 1,
					'cargo' => 1,
					'ciudad' => '68001',
				)),
			),
			'datosinformacionfinanciera' => array(
				'codigo_bloque' => '7',
				'coleccion' => array(array(
					'salarios' => 1,
				)),
			),
			'datosinmuebles' => array(
				'codigo_bloque' => '8',
				'coleccion' => array(array(
					'tipo_inmueble' => 1,
				)),
			),
			/*'datosinformacioncodeudor' => array(
				'codigo_bloque' => '9',
				'coleccion' => array(array(
					'tipo_identificacion' => 1,
					'nombres' => 'daniel',
					'apellidos' => 'diaz',
				)),
			),*/
			'datosmotivosolicitud' => array(
				'codigo_bloque' => '11',
				'motivos_solicitud' => 'a',
				'motivo_solicitud' => 'a',
				'solicitud' => 'a',
			),
			'datosvalorescredito' => array(
				'codigo_bloque' => '16',
				'coleccion' => array(array(
					'tipo_de_radicacion' => '2',
					'codigo_linea' => '10001',
					'valor_a_pagar' => 0,
					'porcentaje_cubrimiento' => 100,
					'saldo' => 0,
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
				'aceptado' => 'S'
			),
		);
		
		$data = array(
			'numero_solicitud' => 1,
			'repositorio' => $repositorio,
		);

		$payload = json_encode(array("parameters" => $params, "data" => array($data)));
		
		//die(var_dump($payload));
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close ($ch);
		
		if ($token != "" || $token != null)	$tok_out = "true";
		else $tok_out = "false";
		
		echo nl2br("Conexion: " . $conexion . "\r\nUsuario: " . $user . "\r\nToken: " . $tok_out . "\r\n" . $server_output);
		die();

	}
	
	public function sendPost3($token, $conexion, $user) {
		//die(var_dump($token));
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,"https://www.mundosoft.com.co:8080/Mundosoft/backend/public/backend/ws/v1");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$params = array(
			'service' => 'cuentas_integracion',
			'token' => $token,
			'user' => $user,
			'conexion' => $conexion
		);
		
		$repositorio = array(
			'datos' => array(
				'codigo_formulario' => 3,
				'datosterminosaceptacion' => array(array(
					'aceptado' => 'S'
				)),
				'datosgenerales' => array(
					'codigo_bloque' => 5,
					'fecha_nacimiento' => '',
					'fecha_exp_doc' => '',
					'estrato' => '',
					'avatar' => 'Q2FkZW5hIGEgY29kaWZpY2Fy',
					'foto_perfil' => 'mi_foto.jpg'
				),
			));
		
		$data = array(
			'numero_solicitud' => 1,
			'numero_solicitud_padre' => 1,
			'repositorio' => $repositorio,
		);

		$payload = json_encode(array("parameters" => $params, "data" => array($data)));
		
		//die(var_dump($payload));
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close ($ch);
		
		echo nl2br("Conexion: " . $conexion . "\r\nUsuario: " . $user . "\r\nToken: " . $token . "\r\n" . $server_output);
		die();

	}
}
?>