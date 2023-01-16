<?php

namespace Model;

use \mysqli;

class Database
{
	private $db_con = null;
	
	public function __construct() {
		//error_reporting(0);
		try
		{
			if ($this->db_con == null) {
				$this->db_con = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'), getenv('DB_PORT'));
				if ($this->db_con -> connect_errno) {
					error_log($this->db_con -> connect_error, 0);
					die("Error al conectarse con la base de datos. Contáctese con el administrador.");
					//die("Failed to connect to MySQL: " . $this->db_con -> connect_error);
				}
				else {
					$this->db_con -> set_charset("utf8mb4");
				}
			}
		}
		catch (Exception $e)
		{
			error_log($e->getMessage(), 0);
		}
	}
	
	public function close() {
		$this->db_con = null;
	}
	
	public function getConn() {
		return $this->db_con;
	}
	
	public function get($sql, $args, $types): array {
		$sth = $this->db_con->prepare($sql);
		if ($args != null && $types != null)	$sth->bind_param($types, ...$args);
        $sth->execute();
		$res = $sth->get_result();
		$res_arr = $res->fetch_all(MYSQLI_ASSOC);
		$res->free_result();
		$sth->close();
        return $res_arr;
	}
	
	public function put($sql, $args, $types): array {
		$sth = $this->db_con->prepare($sql);
		if ($args != null && $types != null)	$sth->bind_param($types, ...$args);
        return [ $sth->execute(), $sth->affected_rows ];
	}
	
	public function generateUID() {
		$uid = uniqid("codeudor-", true);
		
		$result = $this->get("SELECT uid FROM codeudor WHERE uid = ?", [ $uid ], "s");
		
		if (count($result) > 0) {
			return generateUID();
		}
		else {
			return $uid;
		}
	}
	
	public function getIdDebtor($uid) {
		$result = $this->get("SELECT id_deudor FROM codeudor WHERE uid = ?", [ $uid ], "s");
		
		if ($result == false)
		{
			return -1;
		}
		
		$row = $result[0];
		return $row['id_deudor'];
	}
	
	public function getDebtorsData() {
		$result = $this->get("SELECT * FROM deudor", null, null);
		
		if ($result == false)
		{
			return -1;
		}
		
		$clientsData = array();
		for ($i = 0; $i < count($result); $i++) {
			$row = $result[$i];
			$clientData = new Debtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			if ($objClientData->tipo_persona == "juridica") {
				$result2 = $this->get("SELECT documento_adjunto FROM estados_financieros WHERE tipo_registro = 'deudor' AND id_registro = ?", [ $row['id'] ], "d");
				if (count($result2) > 0)
				{
					for ($j = 0; $j < count($result2); $j++) {
						$row2 = $result2[$j];
						array_push($estadosFinancieros, $row2['documento_adjunto']);
					}
				}
			}
			
			$clientData->fromData($row['id'], $objClientData->tipo_persona, $objClientData->valor_solicitado, $objClientData->plazo,
								$objClientData->destino_credito, $objClientData->referido, $objClientData->codigo_redimir, $objClientData->primer_apellido, $objClientData->segundo_apellido,
								$objClientData->nombres, $objClientData->tipo_identificacion, $objClientData->numero_identificacion,
								$objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono,
								$objClientData->celular, $objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda,
								$objClientData->estrato, $objClientData->personas_a_cargo,
								$objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge, $objClientData->ciudad_conyuge, 
								$objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa,
								$objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa, $objClientData->actividad_economica_empresa, 
								$objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, 
								$objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal, $objClientData->celular_representante_legal,
								$objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, 
								$objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos, 
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles,
								$objClientData->empleados, $objClientData->independientes,
								$objClientData->codeudores,
								$row['documento_adjunto'], $estadosFinancieros);
			
			array_push($clientsData, $clientData);
		}
		return $clientsData;
	}
	
	public function getCodebtorsData() {
		$result = $this->get("SELECT * FROM codeudor WHERE eliminado = 0", null, null);
		
		if ($result == false)
		{
			return -1;
		}
		
		$clientsData = array();
		for ($i = 0; $i < count($result); $i++) {
			$row = $result[$i];
			$codebtor = new Codebtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			if ($objClientData->tipo_persona == "juridica") {
				$result2 = $this->get("SELECT documento_adjunto FROM estados_financieros WHERE tipo_registro = 'codeudor' AND id_registro = ?", [ $row['id'] ], "d");
				if (count($result2) > 0)
				{
					for ($j = 0; $j < count($result2); $j++) {
						$row2 = $result2[$j];
						array_push($estadosFinancieros, $row2['documento_adjunto']);
					}
				}
			}
			
			$resumen = $this->getCodebtorSummary($row['uid']);
			
			$codebtor->fromData($row['id'], $row['id_deudor'], $objClientData->tipo_persona, $objClientData->primer_apellido, $objClientData->segundo_apellido, $objClientData->nombres,
								$objClientData->tipo_identificacion, $objClientData->numero_identificacion, $objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono, $objClientData->celular,
								$objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda, $objClientData->estrato, $objClientData->personas_a_cargo, $objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge,
								$objClientData->ciudad_conyuge, $objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa, $objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa,
								$objClientData->actividad_economica_empresa, $objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, $objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal,
								$objClientData->celular_representante_legal, $objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, $objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos,
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles, $objClientData->empleados, $objClientData->independientes,
								$row['documento_adjunto'], $estadosFinancieros);
			$codebtor->resumen = $resumen;
			
			array_push($clientsData, $codebtor);
		}
		return $clientsData;
	}
	
	public function getDebtorData($id) {
		$result = $this->get("SELECT * FROM deudor WHERE id = ?", [ $id ], "d");
		
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			$clientData = new Debtor();
			$objClientData = json_decode($row['datos']);
			$estadosFinancieros = array();
			if ($objClientData->tipo_persona == "juridica") {
				$result2 = $this->get("SELECT documento_adjunto FROM estados_financieros WHERE tipo_registro = 'deudor' AND id_registro = ?", [ $row['id'] ], "d");
				if (count($result2) > 0)
				{
					for ($j = 0; $j < count($result2); $j++) {
						$row2 = $result2[$j];
						array_push($estadosFinancieros, $row2['documento_adjunto']);
					}
				}
			}
			
			$clientData->fromData($row['id'], $objClientData->tipo_persona, $objClientData->valor_solicitado, $objClientData->plazo,
								$objClientData->destino_credito, $objClientData->referido, $objClientData->codigo_redimir, $objClientData->primer_apellido, $objClientData->segundo_apellido,
								$objClientData->nombres, $objClientData->tipo_identificacion, $objClientData->numero_identificacion,
								$objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono,
								$objClientData->celular, $objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda,
								$objClientData->estrato, $objClientData->personas_a_cargo,
								$objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge, $objClientData->ciudad_conyuge, 
								$objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa,
								$objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa, $objClientData->actividad_economica_empresa, 
								$objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, 
								$objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal, $objClientData->celular_representante_legal,
								$objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, 
								$objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos, 
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles,
								$objClientData->empleados, $objClientData->independientes, 
								$objClientData->codeudores,
								$row['documento_adjunto'], $estadosFinancieros);
			return $clientData;
		}
		else {
			return -1;
		}
	}
	
	public function getCodebtorData($uid) {
		$result = $this->get("SELECT codeudor.id AS id, codeudor.uid AS uid, codeudor.id_deudor AS id_deudor, codeudor.resumen AS resumen, codeudor.datos AS datos, codeudor.documento_adjunto AS documento_adjunto, codeudor.fecha_registro AS fecha_registro, codeudor.fue_diligenciado AS fue_diligenciado, deudor.datos AS datos_deudor FROM codeudor INNER JOIN deudor ON codeudor.id_deudor = deudor.id WHERE uid = ? AND codeudor.eliminado = 0", [ $uid ], "s");
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			$codebtor = new Codebtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			if ($objClientData->tipo_persona == "juridica") {
				$result2 = $this->get("SELECT documento_adjunto FROM estados_financieros WHERE tipo_registro = 'codeudor' AND id_registro = ?", [ $row['id'] ], "d");
				if (count($result2) > 0)
				{
					for ($j = 0; $j < count($result2); $j++) {
						$row2 = $result2[$j];
						array_push($estadosFinancieros, $row2['documento_adjunto']);
					}
				}
			}
			
			$codebtor->fromData($row['id'], $row['id_deudor'], $objClientData->tipo_persona, $objClientData->primer_apellido, $objClientData->segundo_apellido, $objClientData->nombres,
								$objClientData->tipo_identificacion, $objClientData->numero_identificacion, $objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono, $objClientData->celular,
								$objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda, $objClientData->estrato, $objClientData->personas_a_cargo, $objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge,
								$objClientData->ciudad_conyuge, $objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa, $objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa,
								$objClientData->actividad_economica_empresa, $objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, $objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal,
								$objClientData->celular_representante_legal, $objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, $objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos,
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles, $objClientData->empleados, $objClientData->independientes,
								$row['documento_adjunto'], $estadosFinancieros);
			$codebtor->uid = $row['uid'];
			$codebtor->datos_deudor = $row['datos_deudor'];
			return $codebtor;
		}
		else {
			return -1;
		}
	}
	
	public function getTempDebtorsData() {
		$result = $this->get("SELECT * FROM temp_deudor", null, null);
		
		if ($result == false)
		{
			return -1;
		}
		
		$clientsData = array();
		for ($i = 0; $i < count($result); $i++) {
			$row = $result[$i];
			$clientData = new Debtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			
			$clientData->fromData($row['id'], $objClientData->tipo_persona, $objClientData->valor_solicitado, $objClientData->plazo,
								$objClientData->destino_credito, $objClientData->referido, $objClientData->codigo_redimir, $objClientData->primer_apellido, $objClientData->segundo_apellido,
								$objClientData->nombres, $objClientData->tipo_identificacion, $objClientData->numero_identificacion,
								$objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono,
								$objClientData->celular, $objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda,
								$objClientData->estrato, $objClientData->personas_a_cargo,
								$objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge, $objClientData->ciudad_conyuge, 
								$objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa,
								$objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa, $objClientData->actividad_economica_empresa, 
								$objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, 
								$objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal, $objClientData->celular_representante_legal,
								$objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, 
								$objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos, 
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles,
								$objClientData->empleados, $objClientData->independientes,
								$objClientData->codeudores,
								$row['documento_adjunto'], $estadosFinancieros);
			
			array_push($clientsData, $clientData);
		}
		return $clientsData;
	}
	
	public function getTempCodebtorsData() {
		$result = $this->get("SELECT * FROM temp_codeudor", null, null);
		
		if ($result == false)
		{
			return -1;
		}
		
		$clientsData = array();
		for ($i = 0; $i < count($result); $i++) {
			$row = $result[$i];
			$codebtor = new Codebtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			
			$resumen = $this->getCodebtorSummary($row['uid']);
			
			$codebtor->fromData($row['id'], $row['id_deudor'], $objClientData->tipo_persona, $objClientData->primer_apellido, $objClientData->segundo_apellido, $objClientData->nombres,
								$objClientData->tipo_identificacion, $objClientData->numero_identificacion, $objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono, $objClientData->celular,
								$objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda, $objClientData->estrato, $objClientData->personas_a_cargo, $objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge,
								$objClientData->ciudad_conyuge, $objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa, $objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa,
								$objClientData->actividad_economica_empresa, $objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, $objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal,
								$objClientData->celular_representante_legal, $objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, $objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos,
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles, $objClientData->empleados, $objClientData->independientes,
								$row['documento_adjunto'], $estadosFinancieros);
			$codebtor->resumen = $resumen;
			
			array_push($clientsData, $codebtor);
		}
		return $clientsData;
	}
	
	public function getTempDebtorData($id) {
		$result = $this->get("SELECT * FROM temp_deudor WHERE id = ?", [ $id ], "d");
		
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			$clientData = new Debtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			
			$clientData->fromData($row['id'], $objClientData->tipo_persona, $objClientData->valor_solicitado, $objClientData->plazo,
								$objClientData->destino_credito, $objClientData->referido, $objClientData->codigo_redimir, $objClientData->primer_apellido, $objClientData->segundo_apellido,
								$objClientData->nombres, $objClientData->tipo_identificacion, $objClientData->numero_identificacion,
								$objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono,
								$objClientData->celular, $objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda,
								$objClientData->estrato, $objClientData->personas_a_cargo,
								$objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge, $objClientData->ciudad_conyuge, 
								$objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa,
								$objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa, $objClientData->actividad_economica_empresa, 
								$objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, 
								$objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal, $objClientData->celular_representante_legal,
								$objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, 
								$objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos, 
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles,
								$objClientData->empleados, $objClientData->independientes, 
								$objClientData->codeudores,
								$row['documento_adjunto'], $estadosFinancieros);
			return $clientData;
		}
		else {
			return -1;
		}
	}
	
	public function getTempCodebtorData($id) {
		$result = $this->get("SELECT * FROM temp_codeudor WHERE id = ?", [ $id ], "s");
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			$codebtor = new Codebtor();
			$objClientData = json_decode($row['datos']);
			
			$estadosFinancieros = array();
			
			$codebtor->fromData($row['id'], $row['id_deudor'], $objClientData->tipo_persona, $objClientData->primer_apellido, $objClientData->segundo_apellido, $objClientData->nombres,
								$objClientData->tipo_identificacion, $objClientData->numero_identificacion, $objClientData->fecha_nacimiento, $objClientData->ciudad, $objClientData->barrio, $objClientData->departamento, $objClientData->telefono, $objClientData->celular,
								$objClientData->correo, $objClientData->estado_civil, $objClientData->tipo_vivienda, $objClientData->estrato, $objClientData->personas_a_cargo, $objClientData->nombre_apellido_conyuge, $objClientData->celular_conyuge,
								$objClientData->ciudad_conyuge, $objClientData->nombre_empresa, $objClientData->nit, $objClientData->direccion_empresa, $objClientData->ciudad_empresa, $objClientData->numero_contacto_empresa,
								$objClientData->actividad_economica_empresa, $objClientData->pagina_web_empresa, $objClientData->redes_sociales_empresa, $objClientData->antiguedad_empresa, $objClientData->primer_apellido_representante_legal,
								$objClientData->segundo_apellido_representante_legal, $objClientData->nombres_representante_legal, $objClientData->tipo_identificacion_representante_legal,
								$objClientData->numero_identificacion_representante_legal, $objClientData->correo_representante_legal, $objClientData->ciudad_representante_legal, $objClientData->departamento_representante_legal, $objClientData->direccion_representante_legal,
								$objClientData->celular_representante_legal, $objClientData->honorarios, $objClientData->comisiones, $objClientData->otros_ingresos, $objClientData->gasto_personal_familiar, $objClientData->arriendo_vivienda, $objClientData->cuotas_creditos,
								$objClientData->conyuge_ingresos_mensuales, $objClientData->conyuge_gastos_mensuales, $objClientData->conyuge_obligaciones,
								$objClientData->informacion_financiera_ingresos, $objClientData->informacion_financiera_activos, $objClientData->informacion_financiera_por_cobrar,
								$objClientData->informacion_financiera_egresos, $objClientData->informacion_financiera_pasivos, $objClientData->informacion_financiera_por_pagar,
								$objClientData->informacion_financiera_utilidad, $objClientData->informacion_financiera_patrimonio, $objClientData->informacion_financiera_fecha,
								$objClientData->vehiculos, $objClientData->inmuebles, $objClientData->empleados, $objClientData->independientes,
								$row['documento_adjunto'], $estadosFinancieros);
			$codebtor->uid = $row['uid'];
			return $codebtor;
		}
		else {
			return -1;
		}
	}
	
	public function getDebtorDocumentConsecutive($num_documento) {
		$result = $this->get("SELECT COUNT(*) AS c FROM deudor WHERE documento_adjunto LIKE ?", [ "%documento_" . $num_documento . "%" ], "s");
		
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			return sprintf('%04d', $row['c']);
		}
		else {
			return -1;
		}
	}
	
	public function getCodebtorDocumentConsecutive($num_documento) {
		$result = $this->get("SELECT COUNT(*) AS c FROM codeudor WHERE documento_adjunto LIKE ?", [ "%documento_" . $num_documento . "%" ], "s");
		
		if ($result == false)
		{
			return -1;
		}
		
		if (count($result) > 0) {
			$row = $result[0];
			return sprintf('%04d', $row['c']);
		}
		else {
			return -1;
		}
	}
	
	public function getCodebtorSummary($uid) {
		$result = $this->get("SELECT * FROM codeudor WHERE uid = ? AND eliminado = 0", [ $uid ], "s");
		
		if ($result == false)
		{
			return -1;
		}
		
		$row = $result[0];
		$jsonSummary = json_decode($row["resumen"]);
		$codebtor = new CodebtorSummary($row["uid"], $row["id_deudor"], $jsonSummary->nombres, $jsonSummary->celular, $jsonSummary->correo);
		
		if ($row["fue_diligenciado"] == 1) {
			$codebtor->confirmarDiligenciado();
		}
		
		return $codebtor;
	}
	
	public function getCodebtorsSummary($id_deudor) {
		$result = $this->get("SELECT * FROM codeudor WHERE id_deudor = ? AND eliminado = 0", [ $id_deudor ], "d");
		
		if ($result == false)
		{
			return null;
		}
		
		if (count($result) == 0) {
			return null;
		}
		
		
		$codebtors = [];
		for ($i = 0; $i < count($result); $i++) {
			$row = $result[$i];
			$jsonSummary = json_decode($row["resumen"]);
			$codebtor = new CodebtorSummary($row["uid"], $row["id_deudor"], $jsonSummary->nombres, $jsonSummary->celular, $jsonSummary->correo);
			$codebtor->uid = $row["uid"];
			array_push($codebtors, $codebtor);
		}
		return $codebtors;
	}
	
	public function getCities() {
		$result = $this->get("SELECT * FROM ciudades ORDER BY ciudad ASC", null, null);
		
		if ($result == false || count($result) == 0)
		{
			return -1;
		}
		
		return $result;
	}

    public function getEconomicActivities() {
        $result = $this->get("SELECT * FROM actividades_economicas ORDER BY nombre ASC", null, null);

        if ($result == false || count($result) == 0)
        {
            return -1;
        }

        return $result;
    }
	
	public function registerDebtorData(Debtor $clientData): string {
		$jsonClientData = json_encode($clientData);
		$codeudores = json_decode($clientData->codeudores);
		
		$result = $this->get("SELECT MAX(id) AS c FROM deudor WHERE id LIKE '" . date("Ymd") . "%'", null, null);
		
		$consecutivo = 0;
		if (count($result) > 0) {
			$row = $result[0];
			$consecutivo = $row["c"];
			if ($consecutivo == null || $consecutivo == "") {
				$consecutivo = date("Ymd") . "100";
			}
			else {
				$consecutivo = intval($consecutivo) + 1;
			}
		}
		else {
			return -1;
		}
		
		$result = $this->put("INSERT INTO deudor(id, datos, estado, fecha_registro) VALUES(?, ?, ?, ?)", [ $consecutivo, $jsonClientData, "Recibida", date("Y-m-d H:i:s") ], "dsss")[0];
		if ($result == false)
		{
			return -1;
		}
		
		foreach ($codeudores as $codeudor) {
			$uid = $this->generateUID();
			$result = $this->put("INSERT INTO codeudor(uid, id_deudor, resumen) VALUES(?, ?, ?)", [ $uid, $consecutivo, json_encode($codeudor) ], "sds")[0];
			if ($result == false)
			{
				return -1;
			}
		}
		return $consecutivo;
	}
	
	public function registerTempDebtorData(Debtor $clientData): string {
		$jsonClientData = json_encode($clientData);
		
		$result = $this->put("INSERT INTO temp_deudor(datos, fecha_registro) VALUES(?, ?)", [ $jsonClientData, date("Y-m-d H:i:s") ], "ss")[0];
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function registerCodebtor($id_deudor, $codebtorsSummary) {
		$codeudores = json_decode($codebtorsSummary);
		
		foreach ($codeudores as $codeudor) {
			$uid = $this->generateUID();
			$result = $this->put("INSERT INTO codeudor(uid, id_deudor, resumen) VALUES(?, ?, ?)", [ $uid, $id_deudor, json_encode($codeudor) ], "sds")[0];
			if ($result == false)
			{
				return -1;
			}
		}
		
		return 1;
	}
	
	public function registerCodebtorData(string $uid, Codebtor $codebtor): string {
		$jsonCodebtor = json_encode($codebtor);
		
		$result = $this->put("UPDATE codeudor SET datos = ?, fecha_registro = ?, fue_diligenciado = 1 WHERE uid = ?", [ $jsonCodebtor, date("Y-m-d H:i:s"), $uid ], "sss")[0];
		
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function registerTempCodebtorData(string $uid, $id_deudor, Codebtor $codebtor): string {
		$jsonCodebtor = json_encode($codebtor);
		
		$result = $this->put("INSERT INTO temp_codeudor(uid, id_deudor, datos, fecha_registro) VALUES(?, ?, ?, ?)", [ $uid, $id_deudor, $jsonCodebtor, date("Y-m-d H:i:s") ], "sdss")[0];
		
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function registerDebtorDocument($location, $id) {
		$result = $this->put("UPDATE deudor SET documento_adjunto = ? WHERE id = ?", [ $location, $id ], "sd");
		
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function registerCodebtorDocument($location, $uid) {
		$result = $this->put("UPDATE codeudor SET documento_adjunto = ? WHERE uid = ?", [ $location, $uid ], "ss");
		
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function registerFinancialStatement($location, $id, $tipo_registro, $nit) {
		if ($tipo_registro == 0) { $tipo_registro = "deudor"; }
		if ($tipo_registro == 1) { $tipo_registro = "codeudor"; }
		$result = $this->put("INSERT INTO estados_financieros(tipo_registro, id_registro, nit, documento_adjunto) VALUES(?, ?, ?, ?)", [ $tipo_registro, $id, $nit, $location ], "sdss")[0];

		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}
	
	public function deleteCodebtor($uid) {
		$result = $this->put("UPDATE codeudor SET eliminado = 1 WHERE uid = ?", [ $uid ], "s");
		
		if ($result == false)
		{
			return -1;
		}
		
		return 1;
	}

    public function log(string $log) {
        $result = $this->put("INSERT INTO logs(log, date) VALUES(?, ?)", [ $log, date("Y-m-d H:i:s") ], "ss")[0];

        if ($result == false)
        {
            return -1;
        }

        return 1;
    }

    public function getCodebtorsUidsByDebtorId($id) {
        $result = $this->get("SELECT uid FROM codeudor WHERE id_deudor = ?", [ $id ], "s");

        $arrayUids = array();
        if (count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                $row = $result[$i];
                array_push($arrayUids, $row["uid"]);
            }
        }
        else {
            return -1;
        }

        return $arrayUids;
    }
}