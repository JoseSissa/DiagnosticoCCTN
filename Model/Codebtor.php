<?php

namespace Model;

use Infinitesimal\Input;

class Codebtor
{
	
	public function __construct() {
	}
	
	public function fromData($id, $id_deudor, $tipo_persona, $primer_apellido, $segundo_apellido, $nombres,
								$tipo_identificacion, $numero_identificacion, $fecha_nacimiento, $ciudad, $barrio, $departamento, $telefono, $celular,
								$correo, $estado_civil, $tipo_vivienda, $estrato, $personas_a_cargo, $nombre_apellido_conyuge, $celular_conyuge,
								$ciudad_conyuge, $nombre_empresa, $nit, $direccion_empresa, $ciudad_empresa, $numero_contacto_empresa,
								$actividad_economica_empresa, $pagina_web_empresa, $redes_sociales_empresa, $antiguedad_empresa, $primer_apellido_representante_legal,
								$segundo_apellido_representante_legal, $nombres_representante_legal, $tipo_identificacion_representante_legal,
								$numero_identificacion_representante_legal, $correo_representante_legal, $ciudad_representante_legal, $departamento_representante_legal, $direccion_representante_legal,
								$celular_representante_legal, $honorarios, $comisiones, $otros_ingresos, $gasto_personal_familiar, $arriendo_vivienda, $cuotas_creditos,
								$conyuge_ingresos_mensuales, $conyuge_gastos_mensuales, $conyuge_obligaciones,
								$informacion_financiera_ingresos, $informacion_financiera_activos, $informacion_financiera_por_cobrar,
								$informacion_financiera_egresos, $informacion_financiera_pasivos, $informacion_financiera_por_pagar,
								$informacion_financiera_utilidad, $informacion_financiera_patrimonio, $informacion_financiera_fecha,
								$vehiculos, $inmuebles, $empleados, $independientes,
								$adjunto_cedula, $estados_financieros) {
		$this->id = $id;
		$this->id_deudor = $id_deudor;
		$this->tipo_persona = $tipo_persona;
		$this->primer_apellido = $primer_apellido;
		$this->segundo_apellido = $segundo_apellido;
		$this->nombres = $nombres;
		$this->tipo_identificacion = $tipo_identificacion;
		$this->numero_identificacion = $numero_identificacion;
		$this->fecha_nacimiento = $fecha_nacimiento;
		$this->ciudad = $ciudad;
		$this->barrio = $barrio;
		$this->departamento = $departamento;
		$this->telefono = $telefono;
		$this->celular = $celular;
		$this->correo = $correo;///
		$this->estado_civil = $estado_civil;///
		$this->tipo_vivienda = $tipo_vivienda;
		$this->estrato = $estrato;
		$this->personas_a_cargo = $personas_a_cargo;
		$this->nombre_apellido_conyuge = $nombre_apellido_conyuge;
		$this->celular_conyuge = $celular_conyuge;
		$this->ciudad_conyuge = $ciudad_conyuge;///
		///
		$this->nombre_empresa = $nombre_empresa;
		$this->nit = $nit;
		$this->direccion_empresa = $direccion_empresa;
		$this->ciudad_empresa = $ciudad_empresa;
		$this->numero_contacto_empresa = $numero_contacto_empresa;
		$this->actividad_economica_empresa = $actividad_economica_empresa;
		$this->pagina_web_empresa = $pagina_web_empresa;
		$this->redes_sociales_empresa = $redes_sociales_empresa;
		$this->antiguedad_empresa = $antiguedad_empresa;
		$this->primer_apellido_representante_legal = $primer_apellido_representante_legal;
		$this->segundo_apellido_representante_legal = $segundo_apellido_representante_legal;
		$this->nombres_representante_legal = $nombres_representante_legal;
		$this->tipo_identificacion_representante_legal = $tipo_identificacion_representante_legal;
		$this->numero_identificacion_representante_legal = $numero_identificacion_representante_legal;
		$this->correo_representante_legal = $correo_representante_legal;
		$this->ciudad_representante_legal = $ciudad_representante_legal;
		$this->departamento_representante_legal = $departamento_representante_legal;
		$this->direccion_representante_legal = $direccion_representante_legal;
		$this->celular_representante_legal = $celular_representante_legal;
		///
		$this->honorarios = $honorarios;
		$this->comisiones = $comisiones;
		$this->otros_ingresos = $otros_ingresos;
		$this->gasto_personal_familiar = $gasto_personal_familiar;
		$this->arriendo_vivienda = $arriendo_vivienda;
		$this->cuotas_creditos = $cuotas_creditos;
		$this->conyuge_ingresos_mensuales = $conyuge_ingresos_mensuales;
		$this->conyuge_gastos_mensuales = $conyuge_gastos_mensuales;
		$this->conyuge_obligaciones = $conyuge_obligaciones;
		$this->informacion_financiera_ingresos = $informacion_financiera_ingresos;
		$this->informacion_financiera_activos = $informacion_financiera_activos;
		$this->informacion_financiera_por_cobrar = $informacion_financiera_por_cobrar;
		$this->informacion_financiera_egresos = $informacion_financiera_egresos;
		$this->informacion_financiera_pasivos = $informacion_financiera_pasivos;
		$this->informacion_financiera_por_pagar = $informacion_financiera_por_pagar;
		$this->informacion_financiera_utilidad = $informacion_financiera_utilidad;
		$this->informacion_financiera_patrimonio = $informacion_financiera_patrimonio;
        $this->informacion_financiera_fecha = $informacion_financiera_fecha;
		$this->vehiculos = $vehiculos;
		$this->inmuebles = $inmuebles;
		$this->empleados = $empleados;
		$this->independientes = $independientes;
		//
		$this->adjunto_cedula = $adjunto_cedula;
		$this->estados_financieros = $estados_financieros;
	}
	
	public function fromInput() {
		$this->tipo_persona = htmlspecialchars(Input::Any('tipo_persona_codeudor'), ENT_QUOTES);
		$this->primer_apellido = htmlspecialchars(Input::Any('primer_apellido_codeudor'), ENT_QUOTES);
		$this->segundo_apellido = htmlspecialchars(Input::Any('segundo_apellido_codeudor'), ENT_QUOTES);
		$this->nombres = htmlspecialchars(Input::Any('nombres_codeudor'), ENT_QUOTES);
		$this->tipo_identificacion = htmlspecialchars(Input::Any('tipo_identificacion_codeudor'), ENT_QUOTES);
		$this->numero_identificacion = htmlspecialchars(Input::Any('numero_identificacion_codeudor'), ENT_QUOTES);
		$this->fecha_nacimiento = htmlspecialchars(Input::Any('fecha_nacimiento_codeudor'), ENT_QUOTES);
		$this->ciudad = htmlspecialchars(Input::Any('ciudad_codeudor'), ENT_QUOTES);
		$this->barrio = htmlspecialchars(Input::Any('barrio_codeudor'), ENT_QUOTES);
		$this->departamento = htmlspecialchars(Input::Any('departamento_codeudor'), ENT_QUOTES);
		$this->telefono = htmlspecialchars(Input::Any('telefono_codeudor'), ENT_QUOTES);
		$this->celular = htmlspecialchars(Input::Any('celular_codeudor'), ENT_QUOTES);
		$this->correo = htmlspecialchars(Input::Any('correo_codeudor'), ENT_QUOTES);
		$this->estado_civil = htmlspecialchars(Input::Any('estado_civil_codeudor'), ENT_QUOTES);
		$this->tipo_vivienda = htmlspecialchars(Input::Any('tipo_vivienda_codeudor'), ENT_QUOTES);
		$this->estrato = htmlspecialchars(Input::Any('estrato_codeudor'), ENT_QUOTES);
		$this->personas_a_cargo = htmlspecialchars(Input::Any('personas_a_cargo_codeudor'), ENT_QUOTES);
		$this->nombre_apellido_conyuge = htmlspecialchars(Input::Any('nombre_apellido_conyuge_codeudor'), ENT_QUOTES);
		$this->celular_conyuge = htmlspecialchars(Input::Any('celular_conyuge_codeudor'), ENT_QUOTES);
		$this->ciudad_conyuge = htmlspecialchars(Input::Any('ciudad_conyuge_codeudor'), ENT_QUOTES);
		$this->nombre_empresa = htmlspecialchars(Input::Any('nombre_empresa_codeudor'), ENT_QUOTES);
		$this->nit = htmlspecialchars(Input::Any('nit_codeudor'), ENT_QUOTES);
		$this->direccion_empresa = htmlspecialchars(Input::Any('direccion_empresa_codeudor'), ENT_QUOTES);
		$this->ciudad_empresa = htmlspecialchars(Input::Any('ciudad_empresa_codeudor'), ENT_QUOTES);
		$this->numero_contacto_empresa = htmlspecialchars(Input::Any('numero_contacto_empresa_codeudor'), ENT_QUOTES);
		$this->actividad_economica_empresa = htmlspecialchars(Input::Any('actividad_economica_empresa_codeudor'), ENT_QUOTES);
		$this->pagina_web_empresa = htmlspecialchars(Input::Any('pagina_web_empresa_codeudor'), ENT_QUOTES);
		$this->redes_sociales_empresa = htmlspecialchars(Input::Any('redes_sociales_empresa_codeudor'), ENT_QUOTES);
		$this->antiguedad_empresa = htmlspecialchars(Input::Any('antiguedad_empresa_codeudor'), ENT_QUOTES);
		$this->primer_apellido_representante_legal = htmlspecialchars(Input::Any('primer_apellido_representante_legal_codeudor'), ENT_QUOTES);
		$this->segundo_apellido_representante_legal = htmlspecialchars(Input::Any('segundo_apellido_representante_legal_codeudor'), ENT_QUOTES);
		$this->nombres_representante_legal = htmlspecialchars(Input::Any('nombres_representante_legal_codeudor'), ENT_QUOTES);
		$this->tipo_identificacion_representante_legal = htmlspecialchars(Input::Any('tipo_identificacion_representante_legal_codeudor'), ENT_QUOTES);
		$this->numero_identificacion_representante_legal = htmlspecialchars(Input::Any('numero_identificacion_representante_legal_codeudor'), ENT_QUOTES);
		$this->correo_representante_legal = htmlspecialchars(Input::Any('correo_representante_legal_codeudor'), ENT_QUOTES);
		$this->ciudad_representante_legal = htmlspecialchars(Input::Any('ciudad_representante_legal_codeudor'), ENT_QUOTES);
		$this->departamento_representante_legal = htmlspecialchars(Input::Any('departamento_representante_legal_codeudor'), ENT_QUOTES);
		$this->direccion_representante_legal = htmlspecialchars(Input::Any('direccion_representante_legal_codeudor'), ENT_QUOTES);
		$this->celular_representante_legal = htmlspecialchars(Input::Any('celular_representante_legal_codeudor'), ENT_QUOTES);
		$this->honorarios = htmlspecialchars(Input::Any('honorarios_codeudor'), ENT_QUOTES);
		$this->comisiones = htmlspecialchars(Input::Any('comisiones_codeudor'), ENT_QUOTES);
		$this->otros_ingresos = htmlspecialchars(Input::Any('otros_ingresos_codeudor'), ENT_QUOTES);
		$this->gasto_personal_familiar = htmlspecialchars(Input::Any('gasto_personal_familiar_codeudor'), ENT_QUOTES);
		$this->arriendo_vivienda = htmlspecialchars(Input::Any('arriendo_vivienda_codeudor'), ENT_QUOTES);
		$this->cuotas_creditos = htmlspecialchars(Input::Any('cuotas_creditos_codeudor'), ENT_QUOTES);
		$this->conyuge_ingresos_mensuales = htmlspecialchars(Input::Any('conyuge_ingresos_mensuales_codeudor'), ENT_QUOTES);
		$this->conyuge_gastos_mensuales = htmlspecialchars(Input::Any('conyuge_gastos_mensuales_codeudor'), ENT_QUOTES);
		$this->conyuge_obligaciones = htmlspecialchars(Input::Any('conyuge_obligaciones_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_ingresos = htmlspecialchars(Input::Any('informacion_financiera_ingresos_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_activos = htmlspecialchars(Input::Any('informacion_financiera_activos_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_por_cobrar = htmlspecialchars(Input::Any('informacion_financiera_por_cobrar_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_egresos = htmlspecialchars(Input::Any('informacion_financiera_egresos_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_pasivos = htmlspecialchars(Input::Any('informacion_financiera_pasivos_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_por_pagar = htmlspecialchars(Input::Any('informacion_financiera_por_pagar_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_utilidad = htmlspecialchars(Input::Any('informacion_financiera_utilidad_codeudor'), ENT_QUOTES);
		$this->informacion_financiera_patrimonio = htmlspecialchars(Input::Any('informacion_financiera_patrimonio_codeudor'), ENT_QUOTES);
        $this->informacion_financiera_fecha = htmlspecialchars(Input::Any('informacion_financiera_fecha_codeudor'), ENT_QUOTES);
		
		$placas_vehiculos_ids = preg_filter('/^placa_vehiculo_codeudor_(.*)/', '$1', array_keys($_POST));
		$vehiculos_arr = array();
		foreach ($placas_vehiculos_ids as $item) {
			$placa = htmlspecialchars(Input::Any('placa_vehiculo_codeudor_' . $item), ENT_QUOTES);
			$valor_comercial = htmlspecialchars(Input::Any('valor_comercial_vehiculo_codeudor_' . $item), ENT_QUOTES);
			$prenda = htmlspecialchars(Input::Any('prenda_vehiculo_codeudor_' . $item), ENT_QUOTES);
			
			$vehiculo = new Vehicle($placa, $valor_comercial, $prenda);
			$vehiculo->id = $item;
			
			array_push($vehiculos_arr, $vehiculo);
		}
		if (sizeof($vehiculos_arr) > 0) {
			$this->vehiculos = json_encode($vehiculos_arr);
		}
		
		$tipo_inmueble_ids = preg_filter('/^tipo_inmueble_codeudor_(.*)/', '$1', array_keys($_POST));
		$inmuebles_arr = array();
		foreach ($tipo_inmueble_ids as $item) {
			$tipo_inmueble = htmlspecialchars(Input::Any('tipo_inmueble_codeudor_' . $item), ENT_QUOTES);
			$valor_comercial = htmlspecialchars(Input::Any('valor_comercial_inmueble_codeudor_' . $item), ENT_QUOTES);
			$hipoteca = htmlspecialchars(Input::Any('hipoteca_inmueble_codeudor_' . $item), ENT_QUOTES);
            $porcentaje_propiedad = htmlspecialchars(Input::Any('porcentaje_propiedad_inmueble_codeudor_' . $item), ENT_QUOTES);
			
			$inmueble = new Property($tipo_inmueble, $valor_comercial, $hipoteca, $porcentaje_propiedad);
			$inmueble->id = $item;
			
			array_push($inmuebles_arr, $inmueble);
		}
		if (sizeof($inmuebles_arr) > 0) {
			$this->inmuebles = json_encode($inmuebles_arr);
		}
		
		$div_empleados_ids = preg_filter('/^empresa_empleado_codeudor_(.*)/', '$1', array_keys($_POST));
		$empleados_arr = array();
		foreach ($div_empleados_ids as $item) {
			$empresa = htmlspecialchars(Input::Any('empresa_empleado_codeudor_' . $item), ENT_QUOTES);
			$sector = htmlspecialchars(Input::Any('sector_empleado_codeudor_' . $item), ENT_QUOTES);
			$antiguedad_empleado = htmlspecialchars(Input::Any('antiguedad_empleado_codeudor_' . $item), ENT_QUOTES);
			$tipo_contrato = htmlspecialchars(Input::Any('tipo_contrato_empleado_codeudor_' . $item), ENT_QUOTES);
			$duracion = htmlspecialchars(Input::Any('duracion_empleado_codeudor_' . $item), ENT_QUOTES);
			$duracion_cantidad = htmlspecialchars(Input::Any('duracion_cantidad_empleado_codeudor_' . $item), ENT_QUOTES);
			$fin_contrato = htmlspecialchars(Input::Any('fin_contrato_empleado_codeudor_' . $item), ENT_QUOTES);
			
			$empleado = new Employee($empresa, $sector, $antiguedad_empleado, $tipo_contrato, $duracion, $duracion_cantidad, $fin_contrato);
			$empleado->id = $item;
			
			array_push($empleados_arr, $empleado);
		}
		if (sizeof($empleados_arr) > 0) {
			$this->empleados = json_encode($empleados_arr);
		}
		
		$div_independientes_ids = preg_filter('/^empresa_independiente_codeudor_(.*)/', '$1', array_keys($_POST));
		$independientes_arr = array();
		foreach ($div_independientes_ids as $item) {
			$empresa = htmlspecialchars(Input::Any('empresa_independiente_codeudor_' . $item), ENT_QUOTES);
			$sector = htmlspecialchars(Input::Any('sector_independiente_codeudor_' . $item), ENT_QUOTES);
			$antiguedad_independiente = htmlspecialchars(Input::Any('antiguedad_independiente_codeudor_' . $item), ENT_QUOTES);
			$ocupacion = htmlspecialchars(Input::Any('ocupacion_independiente_codeudor_' . $item), ENT_QUOTES);
			
			$independiente = new Independent($empresa, $sector, $antiguedad_independiente, $ocupacion);
			$independiente->id = $item;
			
			array_push($independientes_arr, $independiente);
		}
		if (sizeof($independientes_arr) > 0) {
			$this->independientes = json_encode($independientes_arr);
		}
	}
	
	public function guardarSesion() {
		try {
			$_SESSION['tipo_persona_codeudor'] = htmlspecialchars(Input::Any('tipo_persona_codeudor'), ENT_QUOTES);
			$_SESSION['primer_apellido_codeudor'] = htmlspecialchars(Input::Any('primer_apellido_codeudor'), ENT_QUOTES);
			$_SESSION['segundo_apellido_codeudor'] = htmlspecialchars(Input::Any('segundo_apellido_codeudor'), ENT_QUOTES);
			$_SESSION['nombres_codeudor'] = htmlspecialchars(Input::Any('nombres_codeudor'), ENT_QUOTES);
			$_SESSION['tipo_identificacion_codeudor'] = htmlspecialchars(Input::Any('tipo_identificacion_codeudor'), ENT_QUOTES);
			$_SESSION['numero_identificacion_codeudor'] = htmlspecialchars(Input::Any('numero_identificacion_codeudor'), ENT_QUOTES);
			$_SESSION['fecha_nacimiento_codeudor'] = htmlspecialchars(Input::Any('fecha_nacimiento_codeudor'), ENT_QUOTES);
			$_SESSION['ciudad_codeudor'] = htmlspecialchars(Input::Any('ciudad_codeudor'), ENT_QUOTES);
			$_SESSION['barrio_codeudor'] = htmlspecialchars(Input::Any('barrio_codeudor'), ENT_QUOTES);
			$_SESSION['departamento_codeudor'] = htmlspecialchars(Input::Any('departamento_codeudor'), ENT_QUOTES);
			$_SESSION['telefono_codeudor'] = htmlspecialchars(Input::Any('telefono_codeudor'), ENT_QUOTES);
			$_SESSION['celular_codeudor'] = htmlspecialchars(Input::Any('celular_codeudor'), ENT_QUOTES);
			$_SESSION['correo_codeudor'] = htmlspecialchars(Input::Any('correo_codeudor'), ENT_QUOTES);
			$_SESSION['estado_civil_codeudor'] = htmlspecialchars(Input::Any('estado_civil_codeudor'), ENT_QUOTES);
			$_SESSION['tipo_vivienda_codeudor'] = htmlspecialchars(Input::Any('tipo_vivienda_codeudor'), ENT_QUOTES);
			$_SESSION['estrato_codeudor'] = htmlspecialchars(Input::Any('estrato_codeudor'), ENT_QUOTES);
			$_SESSION['personas_a_cargo_codeudor'] = htmlspecialchars(Input::Any('personas_a_cargo_codeudor'), ENT_QUOTES);
			$_SESSION['nombre_apellido_conyuge_codeudor'] = htmlspecialchars(Input::Any('nombre_apellido_conyuge_codeudor'), ENT_QUOTES);
			$_SESSION['celular_conyuge_codeudor'] = htmlspecialchars(Input::Any('celular_conyuge_codeudor'), ENT_QUOTES);
			$_SESSION['ciudad_conyuge_codeudor'] = htmlspecialchars(Input::Any('ciudad_conyuge_codeudor'), ENT_QUOTES);
			$_SESSION['nombre_empresa_codeudor'] = htmlspecialchars(Input::Any('nombre_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['nit_codeudor'] = htmlspecialchars(Input::Any('nit_codeudor'), ENT_QUOTES);
			$_SESSION['direccion_empresa_codeudor'] = htmlspecialchars(Input::Any('direccion_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['ciudad_empresa_codeudor'] = htmlspecialchars(Input::Any('ciudad_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['numero_contacto_empresa_codeudor'] = htmlspecialchars(Input::Any('numero_contacto_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['actividad_economica_empresa_codeudor'] = htmlspecialchars(Input::Any('actividad_economica_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['pagina_web_empresa_codeudor'] = htmlspecialchars(Input::Any('pagina_web_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['redes_sociales_empresa_codeudor'] = htmlspecialchars(Input::Any('redes_sociales_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['antiguedad_empresa_codeudor'] = htmlspecialchars(Input::Any('antiguedad_empresa_codeudor'), ENT_QUOTES);
			$_SESSION['primer_apellido_representante_legal_codeudor'] = htmlspecialchars(Input::Any('primer_apellido_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['segundo_apellido_representante_legal_codeudor'] = htmlspecialchars(Input::Any('segundo_apellido_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['nombres_representante_legal_codeudor'] = htmlspecialchars(Input::Any('nombres_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['tipo_identificacion_representante_legal_codeudor'] = htmlspecialchars(Input::Any('tipo_identificacion_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['numero_identificacion_representante_legal_codeudor'] = htmlspecialchars(Input::Any('numero_identificacion_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['correo_representante_legal_codeudor'] = htmlspecialchars(Input::Any('correo_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['ciudad_representante_legal_codeudor'] = htmlspecialchars(Input::Any('ciudad_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['direccion_representante_legal_codeudor'] = htmlspecialchars(Input::Any('direccion_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['departamento_representante_legal_codeudor'] = htmlspecialchars(Input::Any('departamento_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['celular_representante_legal_codeudor'] = htmlspecialchars(Input::Any('celular_representante_legal_codeudor'), ENT_QUOTES);
			$_SESSION['honorarios_codeudor'] = htmlspecialchars(Input::Any('honorarios_codeudor'), ENT_QUOTES);
			$_SESSION['comisiones_codeudor'] = htmlspecialchars(Input::Any('comisiones_codeudor'), ENT_QUOTES);
			$_SESSION['otros_ingresos_codeudor'] = htmlspecialchars(Input::Any('otros_ingresos_codeudor'), ENT_QUOTES);
			$_SESSION['arriendo_vivienda_codeudor'] = htmlspecialchars(Input::Any('arriendo_vivienda_codeudor'), ENT_QUOTES);
			$_SESSION['gasto_personal_familiar_codeudor'] = htmlspecialchars(Input::Any('gasto_personal_familiar_codeudor'), ENT_QUOTES);
			$_SESSION['cuotas_creditos_codeudor'] = htmlspecialchars(Input::Any('cuotas_creditos_codeudor'), ENT_QUOTES);
			$_SESSION['conyuge_ingresos_mensuales_codeudor'] = htmlspecialchars(Input::Any('conyuge_ingresos_mensuales_codeudor'), ENT_QUOTES);
			$_SESSION['conyuge_gastos_mensuales_codeudor'] = htmlspecialchars(Input::Any('conyuge_gastos_mensuales_codeudor'), ENT_QUOTES);
			$_SESSION['conyuge_obligaciones_codeudor'] = htmlspecialchars(Input::Any('conyuge_obligaciones_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_ingresos_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_ingresos_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_activos_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_activos_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_por_cobrar_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_por_cobrar_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_egresos_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_egresos_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_pasivos_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_pasivos_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_por_pagar_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_por_pagar_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_utilidad_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_utilidad_codeudor'), ENT_QUOTES);
			$_SESSION['informacion_financiera_patrimonio_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_patrimonio_codeudor'), ENT_QUOTES);
            $_SESSION['informacion_financiera_fecha_codeudor'] = htmlspecialchars(Input::Any('informacion_financiera_fecha_codeudor'), ENT_QUOTES);
			
			if (isset($_SESSION['vehiculos_codeudor']) == false) $_SESSION['vehiculos_codeudor'] = "''";
			if (isset($_SESSION['inmuebles_codeudor']) == false) $_SESSION['inmuebles_codeudor'] = "''";
			if (isset($_SESSION['empleados_codeudor']) == false) $_SESSION['empleados_codeudor'] = "''";
			if (isset($_SESSION['independientes_codeudor']) == false) $_SESSION['independientes_codeudor'] = "''";
			
			$placas_vehiculos_ids = preg_filter('/^placa_vehiculo_codeudor_(.*)/', '$1', array_keys($_POST));
			$vehiculos_arr = array();
			foreach ($placas_vehiculos_ids as $item) {
				$placa = htmlspecialchars(Input::Any('placa_vehiculo_codeudor_' . $item), ENT_QUOTES);
				$valor_comercial = htmlspecialchars(Input::Any('valor_comercial_vehiculo_codeudor_' . $item), ENT_QUOTES);
				$prenda = htmlspecialchars(Input::Any('prenda_vehiculo_codeudor_' . $item), ENT_QUOTES);
				
				$vehiculo = new Vehicle($placa, $valor_comercial, $prenda);
				$vehiculo->id = $item;
				
				array_push($vehiculos_arr, $vehiculo);
			}
			if (sizeof($vehiculos_arr) > 0) {
				$_SESSION['vehiculos_codeudor'] = json_encode($vehiculos_arr);
			}
			
			$tipo_inmueble_ids = preg_filter('/^tipo_inmueble_codeudor_(.*)/', '$1', array_keys($_POST));
			$inmuebles_arr = array();
			foreach ($tipo_inmueble_ids as $item) {
				$tipo_inmueble = htmlspecialchars(Input::Any('tipo_inmueble_codeudor_' . $item), ENT_QUOTES);
				$valor_comercial = htmlspecialchars(Input::Any('valor_comercial_inmueble_codeudor_' . $item), ENT_QUOTES);
				$hipoteca = htmlspecialchars(Input::Any('hipoteca_inmueble_codeudor_' . $item), ENT_QUOTES);
                $porcentaje_propiedad = htmlspecialchars(Input::Any('porcentaje_propiedad_inmueble_codeudor_' . $item), ENT_QUOTES);
				
				$inmueble = new Property($tipo_inmueble, $valor_comercial, $hipoteca, $porcentaje_propiedad);
				$inmueble->id = $item;
				
				array_push($inmuebles_arr, $inmueble);
			}
			if (sizeof($inmuebles_arr) > 0) {
				$_SESSION['inmuebles_codeudor'] = json_encode($inmuebles_arr);
			}
			
			$div_empleados_ids = preg_filter('/^empresa_empleado_codeudor_(.*)/', '$1', array_keys($_POST));
			$empleados_arr = array();
			foreach ($div_empleados_ids as $item) {
				$empresa = htmlspecialchars(Input::Any('empresa_empleado_codeudor_' . $item), ENT_QUOTES);
				$sector = htmlspecialchars(Input::Any('sector_empleado_codeudor_' . $item), ENT_QUOTES);
				$antiguedad_empleado = htmlspecialchars(Input::Any('antiguedad_empleado_codeudor_' . $item), ENT_QUOTES);
				$tipo_contrato = htmlspecialchars(Input::Any('tipo_contrato_empleado_codeudor_' . $item), ENT_QUOTES);
				$duracion = htmlspecialchars(Input::Any('duracion_empleado_codeudor_' . $item), ENT_QUOTES);
				$duracion_cantidad = htmlspecialchars(Input::Any('duracion_cantidad_empleado_codeudor_' . $item), ENT_QUOTES);
				$fin_contrato = htmlspecialchars(Input::Any('fin_contrato_empleado_codeudor_' . $item), ENT_QUOTES);
				
				$empleado = new Employee($empresa, $sector, $antiguedad_empleado, $tipo_contrato, $duracion, $duracion_cantidad, $fin_contrato);
				$empleado->id = $item;
				
				array_push($empleados_arr, $empleado);
			}
			if (sizeof($empleados_arr) > 0) {
				$_SESSION['empleados_codeudor'] = json_encode($empleados_arr);
			}
			
			$div_independientes_ids = preg_filter('/^empresa_independiente_codeudor_(.*)/', '$1', array_keys($_POST));
			$independientes_arr = array();
			foreach ($div_independientes_ids as $item) {
				$empresa = htmlspecialchars(Input::Any('empresa_independiente_codeudor_' . $item), ENT_QUOTES);
				$sector = htmlspecialchars(Input::Any('sector_independiente_codeudor_' . $item), ENT_QUOTES);
				$antiguedad_independiente = htmlspecialchars(Input::Any('antiguedad_independiente_codeudor_' . $item), ENT_QUOTES);
				$ocupacion = htmlspecialchars(Input::Any('ocupacion_independiente_codeudor_' . $item), ENT_QUOTES);
				
				$independiente = new Independent($empresa, $sector, $antiguedad_independiente, $ocupacion);
				$independiente->id = $item;
				
				array_push($independientes_arr, $independiente);
			}
			if (sizeof($independientes_arr) > 0) {
				$_SESSION['independientes_codeudor'] = json_encode($independientes_arr);
			}
			
			//die(var_dump($_SESSION));
			echo "success";
		}
		catch (Exception $e) {
			echo $e;
		}
	}
}