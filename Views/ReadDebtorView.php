<?php

namespace Views;

use Model\Debtor;
use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class ReadDebtorView
{
    public function __construct($debtor_data, $listado_ciudades, $listado_actividades_economicas)
    {
		$tipo_persona = $debtor_data->tipo_persona;
		$valor_solicitado = $debtor_data->valor_solicitado;
		$plazo = $debtor_data->plazo;
		$destino_credito = $debtor_data->destino_credito;
		$referido = $debtor_data->referido;
		$codigo_redimir = $debtor_data->codigo_redimir;
		$nombres = $debtor_data->nombres;
		$primer_apellido = $debtor_data->primer_apellido;
		$segundo_apellido = $debtor_data->segundo_apellido;
		$tipo_identificacion = $debtor_data->tipo_identificacion;
		$numero_identificacion = $debtor_data->numero_identificacion;
		$fecha_nacimiento = $debtor_data->fecha_nacimiento;
		$ciudad = $debtor_data->ciudad;
		$barrio = $debtor_data->barrio;
		$telefono = $debtor_data->telefono;
		$celular = $debtor_data->celular;
		$personas_a_cargo = $debtor_data->personas_a_cargo;
		$estado_civil = $debtor_data->estado_civil;
		$tipo_vivienda = $debtor_data->tipo_vivienda;
		$estrato = $debtor_data->estrato;
		$correo = $debtor_data->correo;
		$nombre_apellido_conyuge = $debtor_data->nombre_apellido_conyuge;
		$celular_conyuge = $debtor_data->celular_conyuge;
		$ciudad_conyuge = $debtor_data->ciudad_conyuge;
		
		$nombre_empresa = $debtor_data->nombre_empresa;
		$nit = $debtor_data->nit;
		$direccion_empresa = $debtor_data->direccion_empresa;
		$ciudad_empresa = $debtor_data->ciudad_empresa;
		$numero_contacto_empresa = $debtor_data->numero_contacto_empresa;
		$actividad_economica_empresa = $debtor_data->actividad_economica_empresa;
		$pagina_web_empresa = $debtor_data->pagina_web_empresa;
		$redes_sociales_empresa = $debtor_data->redes_sociales_empresa;
		$antiguedad_empresa = $debtor_data->antiguedad_empresa;
		$nombres_representante_legal = $debtor_data->nombres_representante_legal;
		$primer_apellido_representante_legal = $debtor_data->primer_apellido_representante_legal;
		$segundo_apellido_representante_legal = $debtor_data->segundo_apellido_representante_legal;
		$tipo_identificacion_representante_legal = $debtor_data->tipo_identificacion_representante_legal;
		$numero_identificacion_representante_legal = $debtor_data->numero_identificacion_representante_legal;
		$correo_representante_legal = $debtor_data->correo_representante_legal;
		$ciudad_representante_legal = $debtor_data->ciudad_representante_legal;
		$direccion_representante_legal = $debtor_data->direccion_representante_legal;
		$celular_representante_legal = $debtor_data->celular_representante_legal;
		$honorarios = $debtor_data->honorarios;
		$comisiones = $debtor_data->comisiones;
		$otros_ingresos = $debtor_data->otros_ingresos;
		$gasto_personal_familiar = $debtor_data->gasto_personal_familiar;
		$arriendo_vivienda = $debtor_data->arriendo_vivienda;
		$cuotas_creditos = $debtor_data->cuotas_creditos;
		$conyuge_ingresos_mensuales = $debtor_data->conyuge_ingresos_mensuales;
		$conyuge_gastos_mensuales = $debtor_data->conyuge_gastos_mensuales;
		$conyuge_obligaciones = $debtor_data->conyuge_obligaciones;
		$informacion_financiera_ingresos = $debtor_data->informacion_financiera_ingresos;
		$informacion_financiera_activos = $debtor_data->informacion_financiera_activos;
		$informacion_financiera_por_cobrar = $debtor_data->informacion_financiera_por_cobrar;
		$informacion_financiera_egresos = $debtor_data->informacion_financiera_egresos;
		$informacion_financiera_pasivos = $debtor_data->informacion_financiera_pasivos;
		$informacion_financiera_por_pagar = $debtor_data->informacion_financiera_por_pagar;
		$informacion_financiera_utilidad = $debtor_data->informacion_financiera_utilidad;
		$informacion_financiera_patrimonio = $debtor_data->informacion_financiera_patrimonio;
        $informacion_financiera_fecha = $debtor_data->informacion_financiera_fecha;
		
		if ($debtor_data->vehiculos != null && $debtor_data->vehiculos != "") {
			$vehiculos = $debtor_data->vehiculos;
		}
		else {
			$vehiculos = "''";
		}
		
		if ($debtor_data->inmuebles != null && $debtor_data->inmuebles != "") {
			$inmuebles = $debtor_data->inmuebles;
		}
		else {
			$inmuebles = "''";
		}
		
		if ($debtor_data->empleados != null && $debtor_data->empleados != "") {
			$empleados = $debtor_data->empleados;
		}
		else {
			$empleados = "''";
		}
		
		if ($debtor_data->independientes != null && $debtor_data->independientes != "") {
			$independientes = $debtor_data->independientes;
		}
		else {
			$independientes = "''";
		}
		
		if ($debtor_data->codeudores != null && $debtor_data->codeudores != "") {
			$codeudores = $debtor_data->codeudores;
		}
		else {
			$codeudores = "''";
		}
		//$independientes = '[{"empresa":"1","sector":"1","antiguedad_independiente":"menos_6_meses","ocupacion":"1","id":"0"}]';
		//$codeudores = '[{"uid":null,"id_deudor":null,"nombres":"prueba codeudor","celular":"1234567890","correo":"agiosilysion+2@gmail.com","fue_diligenciado":0,"id":"0"}]';
		
		$adjuntar_cedula = str_replace("Uploaded/", "", "/credito/abrir_documento?filename=" . $debtor_data->adjunto_cedula);
		
		?>
		<style>
            input[type="date"]
            {
                display:block;

                /* Solution 1 */
                 -webkit-appearance: textfield;
                -moz-appearance: textfield;
                min-height: 1.2em;

                /* Solution 2 */
                /* min-width: 96%; */
            }

            @media only screen and (min-width: 768px) and (max-width: 975px) {
                .deudor-control__personas_a_cargo {
                    width: 250px !important;
                }
                .deudor-control__ingreso-principal,
                .deudor-control__comisiones,
                .deudor-control__otros-ingresos
                {
                    width: 150px !important;
                }
                .deudor-control__gastos-generales,
                .deudor-control__arriendo-vivienda
                {
                    width: 160px !important;
                }
                .deudor-control__obligaciones
                {
                    width: 130px !important;
                }
                .deudor-control__conyuge_ingresos_mensuales
                {
                    width: 180px !important;
                }
                .deudor-control__conyuge_gastos_mensuales
                {
                    width: 170px !important;
                }
                .deudor-control__conyuge_obligaciones
                {
                    width: 110px !important;
                }
                .deudor-control__correo_codeudor_deudor
                {
                    margin-left: 70px;
                }
            }
		</style>
		<html lang="es">
			<head>
				<title>Solicitud de crédito - Vanka</title>
				<?php new HtmlHead(); ?>
            </head>
			<body>
				<?php new HeaderRow(); ?>
			
				<div class="contenido-formulario" id="contenido_formulario" name="contenido_formulario" >
			
				<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
				  <h2>Comencemos a impulsar <b>tus sueños</b></h2>
				  <p class="lead">Empecemos por conocerte. Con la información y datos personales que nos brindes podremos darte la respuesta que necesitas para la aprobación de tu crédito. Tus datos estarán seguros.</p>
				</div>
				
				<div class="container">
				
				<div class="deudor-contenedor" id="div_tipo_persona" name="div_tipo_persona" >
					<div class="deudor-caja">
						<div class="deudor-seccion-listo" id="div_persona_icono_pendiente" name="div_persona_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo" id="div_persona_icono_completo" name="div_persona_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
						<div class="row d-flex justify-content-center" style="text-align: center; padding: 0 38px 25px 38px">
							Primero escoge que tipo de persona eres:
						</div>
						<div class="row justify-content-center">
							<input type="hidden" id="tipo_persona" name="tipo_persona" value="<?php echo $tipo_persona; ?>" />
							<div>
								<button id="btnPersonaNatural" name="btnPersonaNatural" class="boton-formulario" type="button" disabled >Persona natural</button>
							</div>
							<div>
								<button id="btnPersonaJuridica" name="btnPersonaJuridica" class="boton-formulario" type="button" disabled >Persona jurídica</button>
							</div>
						</div>
						<div class="row ">
						  <div class="deudor-control deudor-control__valor-solicitado">
							<label for="valor_solicitado">Valor solicitado</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_solicitado" name="valor_solicitado" placeholder="Escribe..." value="<?php echo $valor_solicitado; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control deudor-control__plazo">
							<label for="plazo">Plazo (meses)</label>
							<select class="form-control" id="plazo" name="plazo" disabled >
								<option value="" >-Escoge-</option>
								<option value="6" <?php if ($plazo == "6") { echo " selected "; } ?> >6</option>
								<option value="12" <?php if ($plazo == "12") { echo " selected "; } ?> >12</option>
								<option value="18" <?php if ($plazo == "18") { echo " selected "; } ?> >18</option>
								<option value="24" <?php if ($plazo == "24") { echo " selected "; } ?> >24</option>
								<option value="30" <?php if ($plazo == "30") { echo " selected "; } ?> >30</option>
								<option value="36" <?php if ($plazo == "36") { echo " selected "; } ?> >36</option>
								<option value="42" <?php if ($plazo == "42") { echo " selected "; } ?> >42</option>
								<option value="48" <?php if ($plazo == "48") { echo " selected "; } ?> >48</option>
							</select>
						  </div>
						  <div class="deudor-control deudor-control__destino-credito">
							<label for="destino_credito">¿Qué uso que le darás al dinero?</label>
							<input type="text" class="form-control" id="destino_credito" name="destino_credito" placeholder="Escribe..." value="<?php echo $destino_credito; ?>" disabled >
						  </div>
						</div>
						<div class="row ">
						  	<div class="deudor-control deudor-control__referido">
								<label for="referido">Referido por (opcional)</label>
								<input type="text" class="form-control" id="referido" name="referido" placeholder="Nombres y Apellidos" value="<?php echo $referido; ?>" disabled >
						  	</div>
						  	<div class="deudor-control deudor-control__codigo-redimir">
								<label for="codigo_redimir">Código para redimir (opcional)</label>
								<input type="text" class="form-control" id="codigo_redimir" name="codigo_redimir" onchange="validarDivPersona()" placeholder="Código de 6 dígitos" value="<?php if (isset($_SESSION['codigo_redimir'])) { echo $_SESSION['codigo_redimir']; } ?>" disabled >
							</div>
						</div>
					</div>
				</div>
				  
				<div class="deudor-contenedor" id="div_datos_personales" name="div_datos_personales" >
					<div class="deudor-encabezado">
					  <h4 class="deudor-encabezado__titulo">TUS DATOS PERSONALES</h4>
					  <div class="deudor-seccion-icono">
						<img src="Resources/img/icono-datos-personales.svg" />
					  </div>
					    <div class="deudor-seccion-listo-con-encabezado" id="div_datos_personales_icono_pendiente" name="div_datos_personales_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_datos_personales_icono_completo" name="div_datos_personales_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
					</div>
					<div class="deudor-caja">
							<div class="row">
							  <div class="deudor-control" style="width: 450px;" >
								<label for="nombres">Nombres</label>
								<input type="text" class="form-control" id="nombres" name="nombres" placeholder="Escribe..." value="<?php echo $nombres; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px" >
								<label for="primer_apellido">Primer apellido</label>
								<input type="text" class="form-control" id="primer_apellido" name="primer_apellido" placeholder="Escribe..." value="<?php echo $primer_apellido; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px" >
								<label for="segundo_apellido">Segundo apellido</label>
								<input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Escribe..." value="<?php echo $segundo_apellido; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 120px; padding-right: 10px;">
								<label for="tipo_identificacion">Identificación</label>
								<select class="form-control" id="tipo_identificacion" name="tipo_identificacion" disabled >
									<option value="cedula_ciudadania" <?php if ($tipo_identificacion == "cedula_ciudadania") { echo " selected "; } ?> >C.C.</option>
									<option value="cedula_extranjeria" <?php if ($tipo_identificacion == "cedula_extranjeria") { echo " selected "; } ?> >C.E.</option>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 330px; padding-right: 10px;">
							    <label class="label-invisible" for="numero_identificacion" >-</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_identificacion" name="numero_identificacion" placeholder="Número" value="<?php echo $numero_identificacion; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px; padding-right: 10px;">
								<label for="fecha_nacimiento">Fecha de nacimiento</label>
								<input type="text" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="dd-mm-yyyy" value="<?php echo $fecha_nacimiento; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px; padding-right: 10px;">
								<label for="ciudad">Ciudad</label>
								<select class="form-control" id="ciudad" name="ciudad" onchange="validarDivDatosPersonales()" disabled >
									<?php
										for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
											echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
											if ($ciudad == $listado_ciudades[$i]['codigo']) { echo " selected "; }
											echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
										}
									?>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 250px;">
								<label for="barrio">Dirección</label>
								<input type="text" class="form-control" id="barrio" name="barrio" placeholder="Escribe..." value="<?php echo $barrio; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px; padding-right: 10px;" >
								<label for="telefono">Teléfono</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="telefono" name="telefono" maxlength="10" placeholder="(7) XXX XXXX" value="<?php echo $telefono; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px; padding-right: 10px;">
								<label for="celular">Celular</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular" name="celular" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" placeholder="XXX XXX XXXX" value="<?php echo $celular; ?>" disabled >
							  </div>
							  <div class="deudor-control deudor-control__personas_a_cargo" style="width: 200px; padding-right: 10px;">
								<label for="personas_a_cargo">Personas a cargo</label>
								<input type="number" class="form-control" id="personas_a_cargo" name="personas_a_cargo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" min=0 placeholder="Elige" value="<?php echo $personas_a_cargo; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 150px; padding-right: 10px;">
								<label for="estado_civil">Estado civil</label>
								<select class="form-control" id="estado_civil" name="estado_civil" disabled >
									<option value="" >-Escoge-</option>
									<option value="soltero" <?php if ($estado_civil == "soltero") { echo " selected "; } ?> >Soltero/a</option>
									<option value="casado" <?php if ($estado_civil == "casado") { echo " selected "; } ?> >Casado/a</option>
									<option value="separado" <?php if ($estado_civil == "separado") { echo " selected "; } ?> >Separado/a</option>
									<option value="viudo" <?php if ($estado_civil == "viudo") { echo " selected "; } ?> >Viudo/a</option>
									<option value="union_libre" <?php if ($estado_civil == "union_libre") { echo " selected "; } ?> >Unión libre</option>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 150px; padding-right: 10px;">
								<label for="tipo_vivienda">Vivienda</label>
								<select class="form-control" id="tipo_vivienda" name="tipo_vivienda" disabled >
									<option value="" >-Escoge-</option>
									<option value="arrendada" <?php if ($tipo_vivienda == "arrendada") { echo " selected "; } ?> >Arrendada</option>
									<option value="propia" <?php if ($tipo_vivienda == "propia") { echo " selected "; } ?> >Propia</option>
									<option value="familiar" <?php if ($tipo_vivienda == "familiar") { echo " selected "; } ?> >Familiar</option>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 150px; padding-right: 10px;">
								<label for="estrato">Estrato</label>
								<select class="form-control" id="estrato" name="estrato" disabled >
									<option value="" >-Escoge-</option>
									<option value="1" <?php if ($estrato == "1") { echo " selected "; } ?> >1</option>
									<option value="2" <?php if ($estrato == "2") { echo " selected "; } ?> >2</option>
									<option value="3" <?php if ($estrato == "3") { echo " selected "; } ?> >3</option>
									<option value="4" <?php if ($estrato == "4") { echo " selected "; } ?> >4</option>
									<option value="5" <?php if ($estrato == "5") { echo " selected "; } ?> >5</option>
									<option value="6" <?php if ($estrato == "6") { echo " selected "; } ?> >6</option>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 400px;">
								<label for="correo">Correo electrónico</label>
								<input type="text" class="form-control" id="correo" name="correo" placeholder="nombre@correo.com" value="<?php echo $correo; ?>" disabled >
							  </div>
							</div>
							<div class="row" id="div_datos_conyuge" name="div_datos_conyuge">
							  <div class="deudor-control" style="width: 280px">
								<label for="nombre_apellido_conyuge">Nombre / Apellido Cónyuge</label>
								<input type="text" class="form-control" id="nombre_apellido_conyuge" name="nombre_apellido_conyuge" placeholder="Escribe..." value="<?php echo $nombre_apellido_conyuge; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 170px">
								<label for="celular_conyuge">Celular cónyuge</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_conyuge" name="celular_conyuge" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" placeholder="XXX XXX XXXX" value="<?php echo $celular_conyuge; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 400px">
								<label for="ciudad_conyuge">Ciudad residencia</label>
								<select class="form-control" id="ciudad_conyuge" name="ciudad_conyuge" onchange="validarDivDatosPersonales()" disabled >
									<?php
										for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
											echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
											if ($ciudad_conyuge == $listado_ciudades[$i]['codigo']) { echo " selected "; }
											echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
										}
									?>
								</select>
							  </div>
							</div>
					</div>
				</div>
				
				<div class="deudor-contenedor" id="div_datos_empresariales" name="div_datos_empresariales" >
					<div class="deudor-encabezado">
					  <h4 class="deudor-encabezado__titulo">TUS DATOS EMPRESARIALES</h4>
					  <div class="deudor-seccion-icono">
						<img src="Resources/img/icono-datos-personales.svg" />
					  </div>
					    <div class="deudor-seccion-listo-con-encabezado" id="div_datos_empresariales_icono_pendiente" name="div_datos_empresariales_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_datos_empresariales_icono_completo" name="div_datos_empresariales_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
					</div>
					<div class="deudor-caja">
							<div class="row">
							  <div class="deudor-control" style="width: 330px;" >
								<label for="nombre_empresa">Nombre de la empresa</label>
								<input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Escribe..." value="<?php echo $nombre_empresa; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px;" >
								<label for="nit">NIT</label>
								<input type="text" inputmode="numeric" pattern="[0-9.-]*" class="form-control" id="nit" name="nit" placeholder="Escribe..." value="<?php echo $nit; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 300px;">
								<label for="direccion_empresa">Dirección</label>
								<input type="text" class="form-control" id="direccion_empresa" name="direccion_empresa" placeholder="Escribe..." value="<?php echo $direccion_empresa; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 330px;">
								<label for="ciudad_empresa">Ciudad</label>
								<select class="form-control" id="ciudad_empresa" name="ciudad_empresa" onchange="validarDivDatosEmpresariales()" disabled >
									<?php
										for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
											echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
											if ($ciudad_empresa == $listado_ciudades[$i]['codigo']) { echo " selected "; }
											echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
										}
									?>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 200px;">
								<label for="numero_contacto_empresa">Número de contacto</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_contacto_empresa" name="numero_contacto_empresa" maxlength="15" placeholder="XXX XXX XXXX" value="<?php echo $numero_contacto_empresa; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 300px;" >
								  <label for="actividad_economica_empresa">Actividad económica principal</label>
                                  <select class="form-control" id="actividad_economica_empresa" name="actividad_economica_empresa" disabled >
                                      <?php
                                      for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++) {
                                          echo '<option value="' . $listado_actividades_economicas[$i]['codigo'] . '" ';
                                          if ($actividad_economica_empresa == $listado_actividades_economicas[$i]['codigo']) { echo " selected "; }
                                          echo ' >' . mb_convert_case($listado_actividades_economicas[$i]['nombre'], MB_CASE_TITLE, "UTF-8") . '</option>';
                                      }
                                      ?>
                                  </select>
							  </div>
							  <div class="deudor-control" style="width: 330px;">
								<label for="redes_sociales_empresa">Redes sociales</label>
								<input type="text" class="form-control" id="redes_sociales_empresa" name="redes_sociales_empresa" placeholder="Escribe..." value="<?php echo $redes_sociales_empresa; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px;">
								<label for="antiguedad_empresa">Antigüedad empresa</label>
								<input type="number" class="form-control" id="antiguedad_empresa" name="antiguedad_empresa" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Años..." value="<?php echo $antiguedad_empresa; ?>" disabled >
							  </div>
							</div>
							<div class="row">
								<span style="font-weight: bold; padding-left: 15px; padding-top: 15px" >REPRESENTANTE LEGAL</span>
							</div>
							<div class="row">
							  <div class="deudor-control" style="width: 450px;" >
								<label for="nombres_representante_legal">Nombres</label>
								<input type="text" class="form-control" id="nombres_representante_legal" name="nombres_representante_legal" placeholder="Escribe..." value="<?php echo $nombres_representante_legal; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px;" >
								<label for="primer_apellido_representante_legal">Primer apellido</label>
								<input type="text" class="form-control" id="primer_apellido_representante_legal" name="primer_apellido_representante_legal" placeholder="Escribe..." value="<?php echo $primer_apellido_representante_legal; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 200px;" >
								<label for="segundo_apellido_representante_legal">Segundo apellido</label>
								<input type="text" class="form-control" id="segundo_apellido_representante_legal" name="segundo_apellido_representante_legal" placeholder="Escribe..." value="<?php echo $segundo_apellido_representante_legal; ?>" disabled >
							  </div>
							</div>
							<div class="row">
							  <div class="deudor-control" style="width: 120px; padding-right: 10px;">
								<label for="tipo_identificacion_representante_legal">Identificación</label>
								<select class="form-control" id="tipo_identificacion_representante_legal" name="tipo_identificacion_representante_legal" disabled >
									<option value="cedula_ciudadania" <?php if ($tipo_identificacion_representante_legal == "cedula_ciudadania") { echo " selected "; } ?> >C.C.</option>
									<option value="cedula_extranjeria" <?php if ($tipo_identificacion_representante_legal == "cedula_extranjeria") { echo " selected "; } ?> >C.E.</option>
								</select>
							  </div>
							  <div class="deudor-control" style="width: 150px; padding-right: 10px;">
							    <label class="label-invisible" for="numero_identificacion_representante_legal">-</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_identificacion_representante_legal" name="numero_identificacion_representante_legal" placeholder="Número" value="<?php echo $numero_identificacion_representante_legal; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 380px;">
								<label for="correo_representante_legal">Correo electrónico</label>
								<input type="text" class="form-control" id="correo_representante_legal" name="correo_representante_legal" placeholder="nombre@correo.com" value="<?php echo $correo_representante_legal; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 190px; padding-right: 10px;">
								<label for="ciudad_representante_legal">Ciudad</label>
								<select class="form-control" id="ciudad_representante_legal" name="ciudad_representante_legal" onchange="validarDivDatosEmpresariales()" disabled >
									<?php
										for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
											echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
											if ($ciudad_representante_legal == $listado_ciudades[$i]['codigo']) { echo " selected "; }
											echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
										}
									?>
								</select>
							  </div>
							</div>
							<div class="row">
							  <div class="deudor-control" style="width: 450px; padding-right: 10px;" >
								<label for="direccion_representante_legal">Dirección</label>
								<input type="text" class="form-control" id="direccion_representante_legal" name="direccion_representante_legal" placeholder="Escribe..." value="<?php echo $direccion_representante_legal; ?>" disabled >
							  </div>
							  <div class="deudor-control" style="width: 190px; padding-right: 10px;">
								<label for="celular_representante_legal">Celular</label>
								<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_representante_legal" name="celular_representante_legal" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" placeholder="XXX XXX XXXX" value="<?php echo $celular_representante_legal; ?>" disabled >
							  </div>
							</div>
					</div>
				</div>
				
				<div class="deudor-contenedor" id="div_fuentes_ingreso_persona_natural" name="div_fuentes_ingreso_persona_natural" >
					<div class="deudor-encabezado">
					  <h4 class="deudor-encabezado__titulo">FUENTES DE INGRESO</h4>
					  <div class="deudor-seccion-icono">
						<img src="Resources/img/icono-fuentes-ingreso.svg" />
					  </div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_fuentes_ingreso_persona_natural_icono_pendiente" name="div_fuentes_ingreso_persona_natural_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_fuentes_ingreso_persona_natural_icono_completo" name="div_fuentes_ingreso_persona_natural_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
					</div>
					<div class="deudor-caja" id="div_fuentes_ingreso" name="div_fuentes_ingreso">
						<div class="row d-flex justify-content-center" style="padding: 0 15px 25px 15px">
							Agrega tus fuentes de ingreso, ya seas empleado, independiente, o ambas
						</div>
						<div class="row d-flex justify-content-center">
							<div style="padding: 10px 10px">
								
							</div>
							<div style="padding: 10px 10px">
								
							</div>
						</div>
					</div>
				</div>
				  
				<div class="deudor-contenedor" id="div_informacion_financiera_persona_natural" name="div_informacion_financiera_persona_natural" >
					  <div class="deudor-encabezado">
						  <h4 class="deudor-encabezado__titulo">INFORMACIÓN FINANCIERA</h4>
						  <div class="deudor-seccion-icono">
							<img src="Resources/img/icono-informacion-financiera.svg" />
						  </div>
					    <div class="deudor-seccion-listo-con-encabezado" id="div_informacion_financiera_persona_natural_icono_pendiente" name="div_informacion_financiera_persona_natural_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_informacion_financiera_persona_natural_icono_completo" name="div_informacion_financiera_persona_natural_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
					  </div>
					  <div class="deudor-caja">
							<div class="row">
							  <div class="deudor-control" style="padding-right: 70px" >
								<label><span style="color: white; ">-</span><br><b>Ingreso mensual</b></label>
							  </div>
                              <div class="deudor-control deudor-control__ingreso-principal" style="width:200px">
								<label for="honorarios">Ingreso principal</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="honorarios" name="honorarios" placeholder="Digite una cifra..." value="<?php echo $honorarios; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__comisiones" style="width:200px">
								<label for="comisiones">Comisiones</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="comisiones" name="comisiones" placeholder="Cifra..." value="<?php echo $comisiones; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__otros-ingresos" style="width:200px">
								<label for="otros_ingresos">Otros ingresos</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="otros_ingresos" name="otros_ingresos" placeholder="Cifra..." value="<?php echo $otros_ingresos; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
							</div>
							<div class="row">
							  <div class="deudor-control" style="padding-right: 75px">
								<label><span style="color: white; ">-</span><br><b>Gastos por mes</b></label>
							  </div>
                              <div class="deudor-control deudor-control__gastos-generales" style="width:200px">
								<label for="gasto_personal_familiar">Gastos generales</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="gasto_personal_familiar" name="gasto_personal_familiar" placeholder="Alimentación, educación, ocio..." value="<?php echo $gasto_personal_familiar; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__arriendo-vivienda" id="div_arriendo_vivienda" name="div_arriendo_vivienda" style="width:200px">
								<label for="arriendo_vivienda">Arriendo vivienda</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="arriendo_vivienda" name="arriendo_vivienda" placeholder="Cifra..." value="<?php echo $arriendo_vivienda; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__obligaciones" style="width:200px">
								<label for="cuotas_creditos">Obligaciones</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="cuotas_creditos" name="cuotas_creditos" placeholder="Cuotas préstamos..." value="<?php echo $cuotas_creditos; ?>"disabled  >
								  <i>$</i>
								</div>
							  </div>
							</div>
							<div class="row" id="div_conyuge_informacion_financiera" name="div_conyuge_informacion_financiera">
							  <div class="deudor-control" style="padding-right: 115px">
								<label><br><b>* Cónyuge</b></label>
							  </div>
                              <div class="deudor-control deudor-control__conyuge_ingresos_mensuales" style="width:200px">
								<label for="conyuge_ingresos_mensuales">Ingresos mensuales</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_ingresos_mensuales" name="conyuge_ingresos_mensuales" placeholder="Digite una cifra..." value="<?php echo $conyuge_ingresos_mensuales; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__conyuge_gastos_mensuales" style="width:200px">
								<label for="conyuge_gastos_mensuales">Gastos mensuales</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_gastos_mensuales" name="conyuge_gastos_mensuales" placeholder="Cifra..." value="<?php echo $conyuge_gastos_mensuales; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
                              <div class="deudor-control deudor-control__conyuge_obligaciones" style="width:200px">
								<label for="conyuge_obligaciones">Obligaciones</label>
								<div class="input-icon">
								  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_obligaciones" name="conyuge_obligaciones" placeholder="Cuotas préstamos..." value="<?php echo $conyuge_obligaciones; ?>" disabled >
								  <i>$</i>
								</div>
							  </div>
							</div>
					  </div>
				</div>
				
				<div class="deudor-contenedor" id="div_informacion_financiera_persona_juridica" name="div_informacion_financiera_persona_juridica" >
					  <div class="deudor-encabezado">
						  <h4 class="deudor-encabezado__titulo">INFORMACIÓN FINANCIERA</h4>
						  <div class="deudor-seccion-icono">
							<img src="Resources/img/icono-informacion-financiera.svg" />
						  </div>
						  <div class="deudor-seccion-listo-con-encabezado" id="div_informacion_financiera_persona_juridica_icono_pendiente" name="div_informacion_financiera_persona_juridica_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						  </div>
						  <div class="deudor-seccion-listo-con-encabezado" id="div_informacion_financiera_persona_juridica_icono_completo" name="div_informacion_financiera_persona_juridica_icono_completo">
							<img src="Resources/img/complete.svg" />
						  </div>
					  </div>
					  <div class="deudor-caja">
						<div class="row">
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_ingresos">Ingresos</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_ingresos" name="informacion_financiera_ingresos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_ingresos; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_activos">Activos</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_activos" name="informacion_financiera_activos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_activos; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_por_cobrar">Cuentas por cobrar (deudores)</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_cobrar" name="informacion_financiera_por_cobrar" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_por_cobrar; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_egresos">Egresos</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_egresos" name="informacion_financiera_egresos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_egresos; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_pasivos">Pasivos</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_pasivos" name="informacion_financiera_pasivos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php  echo $informacion_financiera_pasivos; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_por_pagar">Cuentas por pagar</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_pagar" name="informacion_financiera_por_pagar" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_por_pagar; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_utilidad">Utilidad neta</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_utilidad" name="informacion_financiera_utilidad" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_utilidad; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_patrimonio">Patrimonio</label>
							<div class="input-icon">
							  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_patrimonio" name="informacion_financiera_patrimonio" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php echo $informacion_financiera_patrimonio; ?>" disabled >
							  <i>$</i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="deudor-control" style="width:33% !important">
							<label for="informacion_financiera_fecha">Fecha de la información</label>
							<div class="input-icon">
							  <input type="date" onchange="validarDivInformacionFinancieraPersonaJuridica()" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="informacion_financiera_fecha" name="informacion_financiera_fecha" placeholder="dd-mm-yyyy" value="<?php echo $informacion_financiera_fecha; ?>" disabled >
							</div>
						  </div>
						</div>
					  </div>
				</div>
				
				<div class="deudor-contenedor" id="div_activos_persona_natural" name="div_activos_persona_natural" >
					  <div class="deudor-encabezado">
						<h4 class="deudor-encabezado__titulo">ACTIVOS - PROPIEDADES</h4>
						<div class="deudor-seccion-icono">
							<img src="Resources/img/icono-activos.svg" />
						</div>
					  </div>
					  <div class="deudor-caja" id="div_activos" name="div_activos">
						<div class="row d-flex justify-content-center" style="padding: 0 15px 25px 15px">
							Agrega tus propiedades y vehículos, puedes incluir todas las propiedades y vehículos que tengas
						</div>
						<div class="row d-flex justify-content-center">
							<div style="padding: 10px 10px">
								
							</div>
							<div style="padding: 10px 10px">
								
							</div>
						</div>
					  </div>
				</div>
				
				<div class="deudor-contenedor" id="div_codeudor" name="div_codeudor" >
					  <div class="deudor-encabezado">
						<h4 class="deudor-encabezado__titulo">CODEUDOR</h4>
						<div class="deudor-seccion-listo-con-encabezado" id="div_codeudor_icono_pendiente" name="div_codeudor_icono_pendiente" >
							<img src="Resources/img/pending.svg" />
						</div>
						<div class="deudor-seccion-listo-con-encabezado" id="div_codeudor_icono_completo" name="div_codeudor_icono_completo">
							<img src="Resources/img/complete.svg" />
						</div>
					  </div>
					  <div class="deudor-caja" id="div_caja_codeudor" name="div_caja_codeudor" >
						<div class="row d-flex justify-content-center" style="padding: 0px 30px 25px 30px">
							<span>Ahora diligencia los datos de tu codeudor</span>
						</div>
						<div class="row d-flex justify-content-center">
							<div style="padding: 10px 10px">
								
							</div>
						</div>
					  </div>
				</div>
				
			    <div class="deudor-contenedor" id="div_autorizaciones" name="div_autorizaciones" >
				  <div class="deudor-encabezado" style="height: 65px">
					<h4 class="deudor-encabezado__titulo" style="margin: 0" >TÉRMINOS Y CONDICIONES</h4>
					<div class="deudor-seccion-icono">
						<img src="Resources/img/icono-terminos-condiciones.svg" />
					</div>
				  </div>
				  <div class="deudor-caja" style="margin: 20px 0 0 0 !important" >
						<div class="row" style="text-align: justify !important; padding: 0px 30px">
						  <p style="word-break: break-word;">
							Por medio del presente escrito autorizo a Vanka SAS o a quien represente sus derechos, para que adelante las consultas que sean necesarias en 
							relación al comportamiento financiero en las bases o bancos de datos propias o de centrales de riesgo (Datacrédito, Cifin, entre otras y similares).
							<!--<p style="word-break: break-word;">Yo <b><span id="autorizaciones_nombre" name="autorizaciones_nombre">NOMBRE Y</span> <span id="autorizaciones_primer_apellido" name="autorizaciones_primer_apellido">APELLIDO SOLICITANTE</span> <span id="autorizaciones_segundo_apellido" name="autorizaciones_segundo_apellido"></span></b> confirmo haber leído-->
							<!--<span id="costo_consulta" name="costo_consulta"></span>.-->
						  </p>
						</div>
						<div class="row d-flex justify-content-center" style="padding-top: 4px">
							<a onclick="$('#modalTerminosYCondiciones').modal('toggle');"><u>Ver términos y condiciones</u></a>
						</div>
						<div class="row d-flex justify-content-center" style="padding-top: 20px">
							<button id="btnAutorizacion" name="btnAutorizacion" class="boton-formulario" style="margin-bottom: 20px" type="button" disabled >Acepto</button>
						</div>
				  </div>
				</div>
				  
				<div style="text-align: center; padding-top: 30px; padding-bottom: 200px;" id="div_botones" name="div_botones" >
					
					<div style="display: flex; flex-direction: row; align-items: flex-start; justify-content: center; flex-wrap: wrap">
						<div style="display: flex; flex-direction: column">

							<label onclick="window.location.href='<?= $adjuntar_cedula ?>';" class="boton-adjuntar-cedula" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg);" id="adjuntar_cedula_label" name="adjuntar_cedula_label" for="adjuntar_cedula" >
								<span id="texto_adjuntar_cedula" name="texto_adjuntar_cedula">Ver cédula</span>
								<span style="white-space:nowrap;">
									<img class="boton-adjuntar-cedula-camara" id="adjuntar_cedula_camara" name="adjuntar_cedula_camara" src="Resources/img/camera.svg" />
									<img class="boton-adjuntar-cedula-icono-adjuntar" id="adjuntar_cedula_icono_adjuntar" name="adjuntar_cedula_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" />
								</span>
								<img class="boton-adjuntar-cedula-check" id="adjuntar_cedula_check" name="adjuntar_cedula_check" src="Resources/img/check-listo.svg" />
							</label>
							
					
							<label id="label_adjuntar_cedula_representante_legal" name="label_adjuntar_cedula_representante_legal">(Representante legal)</label>
						</div>
					</div>
					
				</div>
				
				</div>

				<div class="row">
					<div class="col-12">
						<?php new Footer(); ?>
					</div>
				</div>
				
				</div>
				
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalSiguiente" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog modal-dialog-scrollable" role="document">
					<div class="modal-content" style="padding: 20px; max-width: 600px !important;">
					  <div class="modal-header" style="border-bottom: 0">
						<h3 class="modal-title" id="modalTitulo">¡Tu información se guardó <b>exitosamente!</b></h3>
						<div class="deudor-seccion-listo" id="div_persona_icono_pendiente" name="div_persona_icono_pendiente" >
							<img src="Resources/img/flag.svg" />
						</div>
					  </div>
					  <div class="modal-body">
						<p>
							<input class="js-copytextarea" type="text" name="Element To Be Copied" id="inputContainingTextToBeCopied" style="display:none; position: relative; left: -10000px;"/>
						</p>
						<p>Tu información ha sido registrada con éxito. Te estaremos informando de los pasos a seguir en tu correo electrónico en un estimado de 1 a 2 días.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
						<hr class="separador-movil">
						<button id="btnContinuar" name="btnContinuar" class="boton-continuar" type="button" onclick="" >finalizar <img src="Resources/img/flecha-siguiente.svg" /></button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValidacionFuentesIngresoYActivos" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Datos incompletos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<!--<p>Debe diligenciar por lo menos una fuente de ingreso y por lo menos un activo - propiedad.</p>-->
						<p>Debe diligenciar por lo menos una fuente de ingreso.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValidacionCodeudores" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Datos incompletos</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<!--<p>Debe diligenciar por lo menos una fuente de ingreso y por lo menos un activo - propiedad.</p>-->
						<p>Debe diligenciar por lo menos un codeudor.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValidacionTerminosYCondiciones" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Aceptar términos y condiciones</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<p>Debe aceptar los términos y condiciones para poder continuar.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValidacionCedula" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Documento sin adjuntar</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<!--<p>Debe diligenciar por lo menos una fuente de ingreso y por lo menos un activo - propiedad.</p>-->
						<p>Para poder continuar, debes adjuntar tu cédula.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValidacionEstadosFinancieros" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Documento sin adjuntar</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<!--<p>Debe diligenciar por lo menos una fuente de ingreso y por lo menos un activo - propiedad.</p>-->
						<p>Para poder continuar, debes adjuntar tus estados financieros.</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalCargando" tabindex="-1" role="dialog" aria-labelledby="modalTituloCargando" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content" style="max-width: 900px !important;" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTituloCargando">Cargando adjuntos</h5>
					  </div>
					  <div class="modal-body">
						<p>Por favor espera mientras los documentos adjuntos son cargados al servidor...</p>
					  </div>
					  <div class="modal-footer">
					  </div>
					</div>
				  </div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" style="overflow-y: scroll; -webkit-overflow-scrolling: touch; " data-backdrop="static" data-keyboard="false" id="modalTerminosYCondiciones" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
				  <div class="modal-dialog" style="max-width: 900px !important" role="document">
					<div class="modal-content" style="max-width: 900px" >
					  <div class="modal-header">
						<h5 class="modal-title" id="modalTitulo">Términos y condiciones</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<p>
						<b>Sarlaft.</b> Yo <b><span id="sarlaft_nombre" name="sarlaft_nombre">NOMBRE Y</span> <span id="sarlaft_primer_apellido" name="sarlaft_primer_apellido">APELLIDO SOLICITANTE</span> <span id="sarlaft_segundo_apellido" name="sarlaft_segundo_apellido"></span></b> 
						declaro bajo la gravedad de juramento: que los recursos y dinero que recibo de Vanka S.A.S., como consecuencia del Contrato de Mutuo suscrito 
						con esta entidad, no van a ser destinados para la financiación del terrorismo o cualquier otra conducta delictiva o ilícita, de acuerdo con las 
						normas penales vigentes en Colombia; así mismo, declaro que en mi actividad no incurro ni incurriré en ninguna actividad ilícita de las 
						contempladas en el Código Penal Colombiano o en cualquier otra norma que lo modifique o adicione. De igual forma, autorizo a Vanka S.A.S. 
						reportar a las autoridades competentes cualquier operación y/o actividad sospechosa. Así mismo, me comprometo a cumplir con los requisitos del 
						Sistema de Autocontrol y Gestión del Riesgo de Lavado de Activos y Financiación del Terrorismo – SARLAFT- implementado por Vanka S.A.S. o que 
						llegaré a implementar o régimen o políticas similares, dentro de los que se encuentran, entregar información veraz y verificable junto con la 
						totalidad de los soportes documentales exigidos y a actualizar su información personal, laboral o institucional, según aplique, así como la 
						información comercial y financiera, cada vez que haya cambios en la misma, y, por lo menos cada vez que así lo solicite Vanka S.A.S.
						</p>
						<p>
						<b>Protección de Datos Personales.</b> Yo <b><span id="proteccion_datos_nombre" name="proteccion_datos_nombre">NOMBRE Y</span> <span id="proteccion_datos_primer_apellido" name="proteccion_datos_primer_apellido">APELLIDO SOLICITANTE</span> <span id="proteccion_datos_segundo_apellido" name="proteccion_datos_segundo_apellido"></span></b> 
						en mi calidad de titular de la información, por medio de la presente, manifiesto mi consentimiento previo, libre, expreso e informado para que 
						Vanka S.A.S. o a quien represente sus derechos para tratar, consultar, solicitar, procesar, reportar y divulgar los datos personales por mi 
						suministrados, conforme su Política de Tratamiento de Datos Personales y finalidades indicadas. De igual forma, manifiesto que Vanka S.A.S., de 
						manera clara y expresa, me informó de lo siguiente: (1) los datos personales que serán recolectados o que han sido recolectados; (2) las 
						finalidades específicas del tratamiento de los datos personales recolectados y para los cuales se obtiene el consentimiento; (3) el tratamiento 
						al cual serán sometidos los datos personales y las Políticas para el Tratamiento de Datos Personales, así como el lugar en donde puedo consultar 
						las Políticas y/o solicitar copia de la misma; (4) el carácter facultativo de la respuesta a las preguntas que le sean hechas, cuando estas 
						versen sobre datos sensibles o sobre los datos de las niñas, niños y adolescentes; (5) los derechos que me asisten como titular y el 
						procedimiento para su ejercicio; (6) la identificación, dirección física o electrónica y teléfono del Responsable del Tratamiento. Lo anterior 
						en base a las leyes 1712 de 2014 y 1377 de 2013.
						</p>
						<p>
						<b>Reporte a centrales de riesgo.</b> Yo <b><span id="consulta_centrales_nombre" name="consulta_centrales_nombre">NOMBRE Y</span> <span id="consulta_centrales_primer_apellido" name="consulta_centrales_primer_apellido">APELLIDO SOLICITANTE</span> <span id="consulta_centrales_segundo_apellido" name="consulta_centrales_segundo_apellido"></span></b> 
						autorizo, de forma expresa, informada y consentida a Vanka S.A.S. o a quien represente sus derechos, para que adelante las consultas que sean 
						necesarias en las bases o bancos de datos propias o de centrales de riesgo (desacredito, cifin, entre otras y similares) relativas a mi 
						comportamiento comercial, crediticio y el manejo de los diferentes productos de las entidades financieras, solidarias, del sector real y 
						similares que tenga y, en general, sobre el cumplimiento de todas las obligaciones de carácter pecuniario a mi cargo. Igualmente, autorizo a 
						Vanka S.A.S. para que haga los reportes pertinentes a las centrales de riesgos existentes o que llegaren a existir, de datos, tratados o sin 
						tratar, tanto sobre el cumplimiento oportuno como sobre el incumplimiento, si lo hubiera, de las obligaciones, o de los deberes legales o 
						contractuales de contenido patrimonial cuando quiera que incurra en mora en el pago de mis obligaciones con Vanka S.A.S.
						</p>
						<p>
						<b>Declaración.</b> Yo <b><span id="declaracion_nombre" name="declaracion_nombre">NOMBRE Y</span> <span id="declaracion_primer_apellido" name="declaracion_primer_apellido">APELLIDO SOLICITANTE</span> <span id="declaracion_segundo_apellido" name="declaracion_segundo_apellido"></span></b> 
						declaro que la información por mí suministrada es veraz, completa y exacta y me obligo a mantenerla actualizada. Declaro que conozco y acepto 
						cumplir el Contrato de Mutuo y Políticas de Vanka S.A.S. y que me han explicado y he aceptado los mismos y los productos y servicios ofrecidos.
						</p>
					  </div>
					  <div class="modal-footer">
						<button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
					  </div>
					</div>
				  </div>
				</div>
			
			</body>
			
			<!-- Encabezados fijos y ajuste de controles en forma inválida  -->
			<script>
				var form = $('#mainForm');
			</script>
			
			<script>
				
				<!-- Evita que el formulario se envíe con Enter -->
				$('body').on('keydown', 'input, select', function(e) {
					if (e.key === "Enter") {
						var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
						focusable = form.find('input,a,select,button,textarea').filter(':visible');
						next = focusable.eq(focusable.index(this)+1);
						if (next.length) {
							next.focus();
						} else {
							form.submit();
						}
						return false;
					}
				});
				
				$(document).ready(function() {
					
					$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
					
					$('#btnSiguiente').mouseenter(function(e) {
						$("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-hover.svg')");
					});
					$('#btnSiguiente').mouseleave(function(e) {
						$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
					});
					
					if ($("#btnPersonaNatural").hasClass("active")) {
						validarBotonPersona(document.getElementById("btnPersonaNatural"));
					}
					else if ($("#btnPersonaJuridica").hasClass("active")) {
						validarBotonPersona(document.getElementById("btnPersonaJuridica"));
					}
					
					$("#valor_solicitado").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#honorarios").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#comisiones").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#otros_ingresos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#gasto_personal_familiar").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#arriendo_vivienda").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#cuotas_creditos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#conyuge_ingresos_mensuales").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#conyuge_gastos_mensuales").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#conyuge_obligaciones").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_ingresos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_activos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_por_cobrar").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_egresos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_pasivos").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_por_pagar").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_utilidad").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#informacion_financiera_patrimonio").on("input", function() {
						formatCurrency($(this));
					});
					
					$("input[name^='valor_comercial_vehiculo_']").on("input", function() {
						formatCurrency($(this));
					});
					
					$("input[name^='valor_comercial_inmueble_']").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#numero_contacto_empresa").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular_conyuge").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular_representante_legal").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular_codeudor_deudor").on("input", function() {
						formatNumber($(this));
					});
					
					$("#telefono").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular").on("input", function() {
						formatNumber($(this));
					});
					
					$("#celular_codeudor_deudor").on("input", function() {
						formatNumber($(this));
					});
					
					$("#nit").on("input", function() {
						formatNumberWithSpecialChars($(this));
					});
					
					$("#numero_identificacion").on("input", function() {
						formatCurrency($(this));
					});
					
					$("#numero_identificacion_representante_legal").on("input", function() {
						formatCurrency($(this));
					});
					
					if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
						$("button[name^='btnEliminarEmpleados']").css("visibility", "hidden");
						$("button[name^='btnEliminarIndependientes']").css("visibility", "hidden");
						$("button[name^='btnEliminarVehiculos']").css("visibility", "hidden");
						$("button[name^='btnEliminarInmuebles']").css("visibility", "hidden");
						$("button[name^='btnEliminarCodeudores']").css("visibility", "hidden");
					}
					
				});

				function validarEstadoBotonSiguiente() {
					if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {
						$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-presionado.svg')");
						$("#btnSiguiente").css("background-image-crossorigin", "anonymous");
						
						setTimeout(function(){ 
							$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
							$("#btnSiguiente").css("background-image-crossorigin", "anonymous");
						}, 1000);
					}
				}
				
				function formatCurrency(element) {
					element.val(element.val().replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')); //Evita caracteres no numéricos
					
					var selection = window.getSelection().toString(); 
					if (selection !== '') {
						return; 
					}
					
					var num = element.val().replace(/,/gi, "");
					var num2 = num.replace(/\d(?=(?:\d{3})+$)/g, '$&.');
					element.val(num2);
				}
				
				function formatNumber(element) {
					element.val(element.val().replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1')); //Evita caracteres no numéricos
					
					var selection = window.getSelection().toString(); 
					if (selection !== '') {
						return; 
					}
				}
				
				function formatNumberWithSpecialChars(element) {
					element.val(element.val().replace(/[^0-9.-]/g, '')); //Evita caracteres no numéricos
					
					var selection = window.getSelection().toString(); 
					if (selection !== '') {
						return; 
					}
				}
				
			</script>
			
			<script>
			
			var cant_div_empleados = 0;
			var cant_div_independientes = 0;
			var cant_div_vehiculos = 0;
			var cant_div_inmuebles = 0;
			var cant_div_codeudores = 0;
			
			$("#div_persona_icono_pendiente").hide();
			$("#div_persona_icono_completo").hide();
			$("#div_datos_personales_icono_pendiente").hide();
			$("#div_datos_personales_icono_completo").hide();
			$("#div_fuentes_ingreso_persona_natural_icono_pendiente").hide();
			$("#div_fuentes_ingreso_persona_natural_icono_completo").hide();
			$("#div_informacion_financiera_persona_natural_icono_pendiente").hide();
			$("#div_informacion_financiera_persona_natural_icono_completo").hide();
			$("#div_datos_empresariales_icono_pendiente").hide();
			$("#div_datos_empresariales_icono_completo").hide();
			$("#div_codeudor_icono_pendiente").hide();
			$("#div_codeudor_icono_completo").hide();
			
			$("#div_datos_personales").hide();
			$("#div_datos_personales *").removeAttr("required");
			$("#fecha_nacimiento").removeAttr("required");
			$("#div_fuentes_ingreso_persona_natural").hide();
			$("#div_fuentes_ingreso_persona_natural *").removeAttr("required");
			$("#div_informacion_financiera_persona_natural").hide();
			$("#div_informacion_financiera_persona_natural *").removeAttr("required");
			$("#div_activos_persona_natural").hide();
			$("#div_activos_persona_natural *").removeAttr("required");
			$("#div_datos_empresariales *").removeAttr("required");
			$("#div_datos_empresariales").hide();
			$("#div_informacion_financiera_persona_juridica *").removeAttr("required"); 
			$("#div_informacion_financiera_persona_juridica").hide();
			$("#div_codeudor").hide();
			$("#div_codeudor *").removeAttr("required");
			$("#div_autorizaciones").hide();
			$("#div_autorizaciones *").removeAttr("required");
			$("#div_botones").hide();
			$("#div_botones *").removeAttr("required");
			
			validarEstadoCivil();
			validarTipoVivienda();
			validacionInicialBotonPersona();
			
			function validacionInicialBotonPersona() {
				
				if ($("#tipo_persona").val() == "natural") {
					validarBotonPersona(document.getElementById("btnPersonaNatural"));
				}
				else if ($("#tipo_persona").val() == "juridica") {
					validarBotonPersona(document.getElementById("btnPersonaJuridica"));
				}
			}
			
			function validarBotonPersona(elem) {
				$("#div_codeudor").show();
				$("#div_autorizaciones").show();
				$("#div_botones").show();
				
				if (elem.name == "btnPersonaNatural") {
					$("#costo_consulta").text('SEIS MIL QUINIENTOS PESOS M/CTE ($6.500.oo) por persona');
					
					$("#btnPersonaNatural").addClass('active');
					$("#btnPersonaJuridica").removeClass('active');
					$("#tipo_persona").val("natural");
					
					$("#div_datos_personales").show();					
					$("#div_fuentes_ingreso_persona_natural").show();
					
					$("#div_informacion_financiera_persona_natural").show();
					
					$("#div_activos_persona_natural").show();
					
					$("#div_datos_empresariales *").removeAttr("required");
					$("#div_datos_empresariales").hide();
					$("#div_informacion_financiera_persona_juridica *").removeAttr("required"); 
					$("#div_informacion_financiera_persona_juridica").hide();
					
					$("#label_adjuntar_cedula_representante_legal").css("visibility", "hidden");
					
					definirNombresMensajes("natural");
				}
				if (elem.name == "btnPersonaJuridica") {
					$("#costo_consulta").text('VEINTISÉIS MIL PESOS M/CTE ($26.000.oo) por persona');
					
					$("#btnPersonaJuridica").addClass('active');
					$("#btnPersonaNatural").removeClass('active');
					$("#tipo_persona").val("juridica");
					
					$("#div_datos_personales").hide();
					$("#div_datos_personales *").removeAttr("required");
					$("#fecha_nacimiento").removeAttr("required");
					$("#div_fuentes_ingreso_persona_natural").hide();
					$("#div_fuentes_ingreso_persona_natural *").removeAttr("required");
					$("#div_informacion_financiera_persona_natural").hide();
					$("#div_informacion_financiera_persona_natural *").removeAttr("required");
					$("#div_activos_persona_natural").hide();
					$("#div_activos_persona_natural *").removeAttr("required");
					
					$("#div_datos_empresariales").show();
					
					$("#div_informacion_financiera_persona_juridica").show();
					
					$("#label_adjuntar_cedula_representante_legal").css("visibility", "visible");
					
					definirNombresMensajes("juridica");
				}
			}
			
			function definirNombresMensajes(tipo_persona) {
				
				if (tipo_persona == "natural") {
			
					$('#autorizaciones_nombre').text($('#nombres').val());
					$('#autorizaciones_primer_apellido').text($('#primer_apellido').val());
					$('#autorizaciones_segundo_apellido').text($('#segundo_apellido').val());
					
					$('#sarlaft_nombre').text($('#nombres').val());
					$('#sarlaft_primer_apellido').text($('#primer_apellido').val());
					$('#sarlaft_segundo_apellido').text($('#segundo_apellido').val());
					
					$('#proteccion_datos_nombre').text($('#nombres').val());
					$('#proteccion_datos_primer_apellido').text($('#primer_apellido').val());
					$('#proteccion_datos_segundo_apellido').text($('#segundo_apellido').val());
					
					$('#consulta_centrales_nombre').text($('#nombres').val());
					$('#consulta_centrales_primer_apellido').text($('#primer_apellido').val());
					$('#consulta_centrales_segundo_apellido').text($('#segundo_apellido').val());
					
					$('#declaracion_nombre').text($('#nombres').val());
					$('#declaracion_primer_apellido').text($('#primer_apellido').val());
					$('#declaracion_segundo_apellido').text($('#segundo_apellido').val());
					
					$('#nombre_empresa').on('input', function() {
					});
					
					$('#nombres').on('input', function() {
					  $('#autorizaciones_nombre').text(this.value);
					  $('#sarlaft_nombre').text(this.value);
					  $('#proteccion_datos_nombre').text(this.value);
					  $('#consulta_centrales_nombre').text(this.value);
					  $('#declaracion_nombre').text(this.value);
					});
					
					$('#primer_apellido').on('input', function() {
					  $('#autorizaciones_primer_apellido').text(this.value);
					  $('#sarlaft_primer_apellido').text(this.value);
					  $('#proteccion_datos_primer_apellido').text(this.value);
					  $('#consulta_centrales_primer_apellido').text(this.value);
					  $('#declaracion_primer_apellido').text(this.value);
					});
					
					$('#segundo_apellido').on('input', function() {
					  $('#autorizaciones_segundo_apellido').text(this.value);
					  $('#sarlaft_segundo_apellido').text(this.value);
					  $('#proteccion_datos_segundo_apellido').text(this.value);
					  $('#consulta_centrales_segundo_apellido').text(this.value);
					  $('#declaracion_segundo_apellido').text(this.value);
					});
				}
				
				else if (tipo_persona == "juridica") {
			
					$('#autorizaciones_nombre').text($('#nombre_empresa').val());
					$('#autorizaciones_primer_apellido').text('');
					$('#autorizaciones_segundo_apellido').text('');
					
					$('#sarlaft_nombre').text($('#nombre_empresa').val());
					$('#sarlaft_primer_apellido').text('');
					$('#sarlaft_segundo_apellido').text('');
					
					$('#proteccion_datos_nombre').text($('#nombre_empresa').val());
					$('#proteccion_datos_primer_apellido').text('');
					$('#proteccion_datos_segundo_apellido').text('');
					
					$('#consulta_centrales_nombre').text($('#nombre_empresa').val());
					$('#consulta_centrales_primer_apellido').text('');
					$('#consulta_centrales_segundo_apellido').text('');
					
					$('#declaracion_nombre').text($('#nombre_empresa').val());
					$('#declaracion_primer_apellido').text('');
					$('#declaracion_segundo_apellido').text('');
					
					$('#nombre_empresa').on('input', function() {
					  $('#autorizaciones_nombre').text(this.value);
					  $('#sarlaft_nombre').text(this.value);
					  $('#proteccion_datos_nombre').text(this.value);
					  $('#consulta_centrales_nombre').text(this.value);
					  $('#declaracion_nombre').text(this.value);
					});
					
					$('#nombres').on('input', function() {
					});
					
					$('#primer_apellido').on('input', function() {
					});
					
					$('#segundo_apellido').on('input', function() {
					});
				}
			}
			
			function validarBotonAutorizacion(elem) {
				if ($("#btnAutorizacion").hasClass("active")) {
					$("#btnAutorizacion").removeClass('active');
				}
				else {
					$("#btnAutorizacion").addClass('active');
				}
			}
						
			function validarEstadoCivil() {
				if ($("#estado_civil").val() == "casado" || $("#estado_civil").val() == "union_libre") {
					$("#div_datos_conyuge").show();
					$("#div_conyuge_informacion_financiera").show();
				}
				else {
					$("#div_datos_conyuge").hide();
					$("#div_conyuge_informacion_financiera").hide();
				}
			}
			
			function validarTipoVivienda() {
				if ($("#tipo_vivienda").val() == "propia" || $("#tipo_vivienda").val() == "familiar") {
					$("#div_arriendo_vivienda *").removeAttr("required"); 
					$("#div_arriendo_vivienda").hide();
				}
				else {
					$("#div_arriendo_vivienda").show();
				}
			}
			
			function validarTipoContrato(id_div) {
                if ($("#tipo_contrato_empleado_" + id_div).val() == "laboral_fijo") {
                    $("#duracion_cantidad_empleado_" + id_div).attr("required", true);
                    $("#div_fin_contrato_" + id_div).show();
                    $("#fin_contrato_empleado_" + id_div).attr("required", true);
                }
                else {
                    $("#duracion_cantidad_empleado_" + id_div).removeAttr("required");
                    $("#div_fin_contrato_" + id_div).hide();
                    $("#fin_contrato_empleado_" + id_div).removeAttr("required");
                }
			}
			
			function animacionBotonAgregarAlPasarMouse(boton, hover) {
				if (hover == 0) {
					boton.attr("src", "Resources/img/boton-agregar.svg");
				}
				else {
					boton.attr("src", "Resources/img/boton-agregar-hover.svg");
				}
			}
			
			function animacionBotonAgregarAlPresionar(boton) {
				boton.attr("src", "Resources/img/boton-agregar-presionado.svg");
				setTimeout(function() {
					boton.attr("src", "Resources/img/boton-agregar.svg");
				}, 200);
			}
			
			function animacionBotonAdjuntarAlPresionar(label) {
				label.addClass("boton-adjuntar-presionado");
				setTimeout(function() {
					label.removeClass("boton-adjuntar-presionado");
				}, 200);
			}
			
			function animacionBotonSiguienteAlPresionar(boton) {
				$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-presionado.svg')");
				$("#btnSiguiente").css("background-image-crossorigin", "anonymous");
				setTimeout(function() {
					$("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
					$("#btnSiguiente").css("background-image-crossorigin", "anonymous");
				}, 200);
			}
			
			let div_vehiculos_inicial = <?php echo $vehiculos; ?>;
			for (i = 0; i < div_vehiculos_inicial.length; i++) {
				crearFilaInicialVehiculo(div_vehiculos_inicial[i].id, div_vehiculos_inicial[i].placa, div_vehiculos_inicial[i].valor_comercial, div_vehiculos_inicial[i].prenda);
				if (parseInt(div_vehiculos_inicial[i].id) >= cant_div_vehiculos) {
					cant_div_vehiculos = parseInt(div_vehiculos_inicial[i].id) + 1;
				}
			}
			
			let div_inmuebles_inicial = <?php echo $inmuebles; ?>;
			for (i = 0; i < div_inmuebles_inicial.length; i++) {
				crearFilaInicialInmueble(div_inmuebles_inicial[i].id, div_inmuebles_inicial[i].tipo_inmueble, div_inmuebles_inicial[i].valor_comercial, div_inmuebles_inicial[i].hipoteca, div_inmuebles_inicial[i].porcentaje_propiedad);
				if (parseInt(div_inmuebles_inicial[i].id) >= cant_div_inmuebles) {
					cant_div_inmuebles = parseInt(div_inmuebles_inicial[i].id) + 1;
				}
			}
			
			let div_empleados_inicial = <?php echo $empleados; ?>;
			for (i = 0; i < div_empleados_inicial.length; i++) {
				crearFilaInicialEmpleado(div_empleados_inicial[i].id, div_empleados_inicial[i].empresa, div_empleados_inicial[i].sector, div_empleados_inicial[i].antiguedad_empleado, div_empleados_inicial[i].tipo_contrato, div_empleados_inicial[i].duracion, div_empleados_inicial[i].duracion_cantidad, div_empleados_inicial[i].fin_contrato);
				if (parseInt(div_empleados_inicial[i].id) >= cant_div_empleados) {
					cant_div_empleados = parseInt(div_empleados_inicial[i].id) + 1;
				}
			}
			
			let div_independientes_inicial = <?php echo $independientes; ?>;
			for (i = 0; i < div_independientes_inicial.length; i++) {
				crearFilaInicialIndependiente(div_independientes_inicial[i].id, div_independientes_inicial[i].empresa, div_independientes_inicial[i].sector, div_independientes_inicial[i].antiguedad_independiente, div_independientes_inicial[i].ocupacion);
				if (parseInt(div_independientes_inicial[i].id) >= cant_div_independientes) {
					cant_div_independientes = parseInt(div_independientes_inicial[i].id) + 1;
				}
			}
			
			let div_codeudores_inicial = <?php echo $codeudores; ?>;
			for (i = 0; i < div_codeudores_inicial.length; i++) {
				crearFilaInicialCodeudor(div_codeudores_inicial[i].id, div_codeudores_inicial[i].nombres, div_codeudores_inicial[i].celular, div_codeudores_inicial[i].correo);
				if (parseInt(div_codeudores_inicial[i].id) >= cant_div_codeudores) {
					cant_div_codeudores = parseInt(div_codeudores_inicial[i].id) + 1;
				}
			}
			
			function crearFilaInicialVehiculo(id, placa, valor_comercial, prenda) {
				let prenda_si = "";
				let prenda_no = "";
				if (prenda == "Si") {
					prenda_si = " selected ";
				}
				else if (prenda == "No") {
					prenda_no = " selected ";
				}
				let div_vehiculos = '<div class="row" id="div_vehiculos_' + id + '" name="div_vehiculos_' + id + '" onmouseenter="$(\'#btnEliminarVehiculos' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarVehiculos' + id + '\').css(\'visibility\', \'hidden\')" >' +
						'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +

						'</div>' +
						'<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
						'	<label><b>Vehículo</b></label>' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control" style="width: 120px;">' +
						'	<label for="placa_vehiculo">Placa</label>' +
						'	<input type="text" class="form-control" id="placa_vehiculo_' + id + '" name="placa_vehiculo_' + id + '" placeholder="Escribe..." maxlength="8" value="' + placa + '" disabled >' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control" style="width: 160px !important;">' +
						'	<label for="valor_comercial_vehiculo">Valor comercial</label>' +
						'	<div class="input-icon">' +
						'	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_vehiculo_' + id + '" name="valor_comercial_vehiculo_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" disabled >' +
						'	  <i>$</i>' +
						'	</div>' +
						'</div>' +
						'<div class="deudor-control" style="width: 150px !important;">' +
						'	<label for="prenda_vehiculo">Pignoración</label>' +
						'	<select class="form-control" id="prenda_vehiculo_' + id + '" name="prenda_vehiculo_' + id + '" disabled >' +
						'		<option value="" >-Escoge-</option>' +
						'  		<option value="Si" ' + prenda_si + '>Sí</option>' +
						'  		<option value="No" ' + prenda_no + '>No</option>' +
						'	</select>' +
						'</div>' +
						'</div>';
				$('#div_activos').append(div_vehiculos);
			}
			
			function crearFilaInicialInmueble(id, tipo_inmueble, valor_comercial, hipoteca, porcentaje_propiedad) {
                let tipo_inmueble_apartamento = "";
                let tipo_inmueble_casa = "";
                let tipo_inmueble_local = "";
                let tipo_inmueble_oficina = "";
                let tipo_inmueble_otro = "";
                let tipo_inmueble_lote = "";

                if (tipo_inmueble == "apartamento") {
                    tipo_inmueble_apartamento = " selected ";
                }
                else if (tipo_inmueble == "casa") {
                    tipo_inmueble_casa = " selected ";
                }
                else if (tipo_inmueble == "local") {
                    tipo_inmueble_local = " selected ";
                }
                else if (tipo_inmueble == "oficina") {
                    tipo_inmueble_oficina = " selected ";
                }
                else if (tipo_inmueble == "otro") {
                    tipo_inmueble_otro = " selected ";
                }
                else if (tipo_inmueble == "lote") {
                    tipo_inmueble_lote = " selected ";
                }
				
				let hipoteca_si = "";
				let hipoteca_no = "";
				if (hipoteca == "Si") {
					hipoteca_si = " selected ";
				}
				else if (hipoteca == "No") {
					hipoteca_no = " selected ";
				}
				
				let div_inmuebles = '<div class="row" id="div_inmuebles_' + id + '" name="div_inmuebles_' + id + '" onmouseenter="$(\'#btnEliminarInmuebles' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarInmuebles' + id + '\').css(\'visibility\', \'hidden\')" >' +
						'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +

						'</div>' +
						'<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
						'	<label><b>Propiedad</b></label>' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control" style="width: 170px;">' +
						'	<label for="tipo_inmueble">Tipo</label>' +
						'	<select class="form-control" id="tipo_inmueble_' + id + '" name="tipo_inmueble_' + id + '" disabled >' +
                        '		<option value="" >-Escoge-</option>' +
                        '  		<option value="apartamento" ' + tipo_inmueble_apartamento + '>Apartamento</option>' +
                        '  		<option value="casa" ' + tipo_inmueble_casa + '>Casa</option>' +
                        '  		<option value="local" ' + tipo_inmueble_local + '>Local</option>' +
                        '  		<option value="oficina" ' + tipo_inmueble_oficina + '>Oficina</option>' +
                        '  		<option value="otro" ' + tipo_inmueble_otro + '>Otro</option>' +
                        '  		<option value="lote" ' + tipo_inmueble_lote + '>Lote</option>' +
						'	</select>' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control" style="width: 160px !important;">' +
						'	<label for="valor_comercial_inmueble">Valor comercial</label>' +
						'	<div class="input-icon">' +
						'	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_inmueble_' + id + '" name="valor_comercial_inmueble_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" disabled >' +
						'	  <i>$</i>' +
						'	</div>' +
						'</div>' +
                        '</div>' +
                        '<div class="row">' +
                        '<div class="deudor-control deudor-div-vacio" style="width: 200px !important;">' +
                        '</div>' +
						'<div class="deudor-control" style="width: 150px !important;">' +
						'	<label for="hipoteca_inmueble">Hipoteca</label>' +
						'	<select class="form-control" id="hipoteca_inmueble_' + id + '" name="hipoteca_inmueble_' + id + '" disabled >' +
						'		<option value="" >-Escoge-</option>' +
						'  		<option value="Si" ' + hipoteca_si + '>Sí</option>' +
						'  		<option value="No" ' + hipoteca_no + '>No</option>' +
						'	</select>' +
                        '</div>' +
                        '<div class="deudor-control" style="width: 300px !important;">' +
                        '	<label for="porcentaje_propiedad_inmueble">Porcentaje propiedad</label>' +
                        '	<input type="number" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="porcentaje_propiedad_inmueble_' + id + '" name="porcentaje_propiedad_inmueble_' + id + '" placeholder="Porcentaje %" value="' + porcentaje_propiedad + '" disabled >' +
                        '</div>' +
						'</div>';
				$('#div_activos').append(div_inmuebles);
			}
			
			function crearFilaInicialEmpleado(id, empresa, sector, antiguedad_empleado, tipo_contrato, duracion, duracion_cantidad, fin_contrato) {
				let antiguedad_empleado_1 = "";
				let antiguedad_empleado_2 = "";
				let antiguedad_empleado_3 = "";
				let antiguedad_empleado_4 = "";
				let antiguedad_empleado_5 = "";
				let antiguedad_empleado_6 = "";
				if (antiguedad_empleado == "menos_6_meses") {
					antiguedad_empleado_1 = " selected ";
				}
				else if (antiguedad_empleado == "mas_6_meses") {
					antiguedad_empleado_2 = " selected ";
				}
				else if (antiguedad_empleado == "mas_1_anho") {
					antiguedad_empleado_3 = " selected ";
				}
				else if (antiguedad_empleado == "mas_2_anhos") {
					antiguedad_empleado_4 = " selected ";
				}
				else if (antiguedad_empleado == "mas_5_anhos") {
					antiguedad_empleado_5 = " selected ";
				}
				else if (antiguedad_empleado == "mas_10_anhos") {
					antiguedad_empleado_6 = " selected ";
				}

                let tipo_contrato_prestacion_servicios = "";
                let tipo_contrato_laboral_fijo = "";
                let tipo_contrato_laboral_indefinido = "";
                let tipo_contrato_obra_labor = "";
                if (tipo_contrato == "prestacion_servicios") {
                    tipo_contrato_prestacion_servicios = " selected ";
                }
                else if (tipo_contrato == "laboral_fijo") {
                    tipo_contrato_laboral_fijo = " selected ";
                }
                else if (tipo_contrato == "laboral_indefinido") {
                    tipo_contrato_laboral_indefinido = " selected ";
                }
                else if (tipo_contrato == "obra_labor") {
                    tipo_contrato_obra_labor = " selected ";
                }
				
				let duracion_fijo = "";
				let duracion_indefinido = "";
				if (duracion == "fijo") {
					duracion_fijo = " selected ";
				}
				else if (duracion == "indefinido") {
					duracion_indefinido = " selected ";
				}
				
				let div_empleados = '<div class="row" id="div_empleados_' + id + '" name="div_empleados_' + id + '" onmouseenter="$(\'#btnEliminarEmpleados' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarEmpleados' + id + '\').css(\'visibility\', \'hidden\')" >' +
						'<div class="row">' +
						'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
						
						'</div>' +
						'<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
						'	<label><b>Empleado</b></label>' +
						'</div>' +
						'<div class="deudor-control" style="width: 210px">' +
						'	<label for="empresa_empleado">Empresa</label>' +
						'	<input type="text" class="form-control" id="empresa_empleado_' + id + '" name="empresa_empleado_' + id + '" placeholder="Escribe..." value="' + empresa + '" disabled >' +
						'</div>' +
						'<div class="deudor-control">' +
						'	<label for="sector_empleado">Cargo</label>' +
						'	<input type="text" class="form-control" id="sector_empleado_' + id + '" name="sector_empleado_' + id + '" placeholder="Tu labor" value="' + sector + '" disabled >' +
						'</div>' +
						'</div>' +
						'<div class="row" style="margin-bottom: 10px">' +
						'<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-label-control-dependiente" style="width: 190px" >' +
						'	<label>Tipo de contrato</label>' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control deudor-control-dependiente" style="width: 170px">' +
						'	<select class="form-control" id="tipo_contrato_empleado_' + id + '" name="tipo_contrato_empleado_' + id + '" onchange="validarTipoContrato(' + id + ')" disabled >' +
						'		<option value="" >-Escoge-</option>' +
						'		<option value="laboral_fijo" ' + tipo_contrato_laboral_fijo + '>Laboral fijo</option>' +
                        '		<option value="laboral_indefinido" ' + tipo_contrato_laboral_indefinido + '>Laboral indefinido</option>' +
						'		<option value="prestacion_servicios" ' + tipo_contrato_prestacion_servicios + '>Prestación de servicios</option>' +
						'		<option value="obra_labor" ' + tipo_contrato_obra_labor + '>Por obra o labor</option>' +
						'	</select>' +
						'</div>' +
                        '</div>' +
                        '<div class="row" style="margin-bottom: 10px">' +
                        '<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
                        '</div>' +
                        '<div class="deudor-label-control-dependiente" style="width: 190px" >' +
                        '	<label>Tiempo laborado</label>' +
                        '</div>' +
                        '<hr class="separador-movil">' +
						'<div class="deudor-control" style="width: 130px">' +
						'	<input type="number" class="form-control" id="duracion_cantidad_empleado_' + id + '" name="duracion_cantidad_empleado_' + id + '" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Meses..." value="' + duracion_cantidad + '" disabled >' +
						'</div>' +
						'</div>' +
						'<div id="div_fin_contrato_' + id + '" class="row" style="margin-bottom: 10px">' +
						'<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-label-control-dependiente" style="width: 190px" >' +
						'	<label>Fin del contrato</label>' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-control deudor-control-dependiente" >' +
						'	<input type="date" class="form-control" id="fin_contrato_empleado_' + id + '" name="fin_contrato_empleado_' + id + '" placeholder="dd-mm-yyyy" value="' + fin_contrato + '" disabled >' +
						'</div>' +
						'</div>' +
						'</div>';
				$('#div_fuentes_ingreso').append(div_empleados);
				validarTipoContrato(id);
			}
			
			function crearFilaInicialIndependiente(id, empresa, sector, antiguedad_independiente, ocupacion) {
				let antiguedad_independiente_1 = "";
				let antiguedad_independiente_2 = "";
				let antiguedad_independiente_3 = "";
				let antiguedad_independiente_4 = "";
				let antiguedad_independiente_5 = "";
				let antiguedad_independiente_6 = "";
				if (antiguedad_independiente == "menos_6_meses") {
					antiguedad_independiente_1 = " selected ";
				}
				else if (antiguedad_independiente == "mas_6_meses") {
					antiguedad_independiente_2 = " selected ";
				}
				else if (antiguedad_independiente == "mas_1_anho") {
					antiguedad_independiente_3 = " selected ";
				}
				else if (antiguedad_independiente == "mas_2_anhos") {
					antiguedad_independiente_4 = " selected ";
				}
				else if (antiguedad_independiente == "mas_5_anhos") {
					antiguedad_independiente_5 = " selected ";
				}
				else if (antiguedad_independiente == "mas_10_anhos") {
					antiguedad_independiente_6 = " selected ";
				}
				
				let div_independientes = '<div class="row" id="div_independientes_' + id + '" name="div_independientes_' + id + '" onmouseenter="$(\'#btnEliminarIndependientes' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarIndependientes' + id + '\').css(\'visibility\', \'hidden\')" >' +
						'<div class="row">' +
						'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +

						'</div>' +
						'<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
						'	<label><b>Independiente</b></label>' +
						'</div>' +
						'<div class="deudor-control" style="width: 200px">' +
						'	<label for="empresa_independiente">Actividad económica</label>' +
						'	<input type="text" class="form-control" id="empresa_independiente_' + id + '" name="empresa_independiente_' + id + '" placeholder="Escribe..." value="' + empresa + '" disabled >' +
						'</div>' +
						'<div class="deudor-control" style="width: 225px">' +
						'	<label for="ocupacion_independiente">Cargo</label>' +
						'	<input type="text" class="form-control" id="ocupacion_independiente_' + id + '" name="ocupacion_independiente_' + id + '" placeholder="Tu labor" value="' + ocupacion + '" disabled >' +
						'</div>' +
						'</div>' +
						'<div class="row">' +
						'<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
						'</div>' +
						'<hr class="separador-movil">' +
						'<div class="deudor-label-control-dependiente" style="width: 190px" >' +
						'	<label >Antigüedad actividad</label>' +
						'</div>' +
						'<div class="deudor-control" >' +
						'	<select class="form-control" id="antiguedad_independiente_' + id + '" name="antiguedad_independiente_' + id + '" disabled >' +
						'		<option value="" >-Escoge-</option>' +
						'		<option value="menos_6_meses" ' + antiguedad_independiente_1 + '>Menos de 6 meses</option>' +
						'		<option value="mas_6_meses" ' + antiguedad_independiente_2 + '>Más de 6 meses</option>' +
						'		<option value="mas_1_anho" ' + antiguedad_independiente_3 + '>Más de 1 año</option>' +
						'		<option value="mas_2_anhos" ' + antiguedad_independiente_4 + '>Más de 2 años</option>' +
						'		<option value="mas_5_anhos" ' + antiguedad_independiente_5 + '>Más de 5 años</option>' +
						'		<option value="mas_10_anhos" ' + antiguedad_independiente_6 + '>Más de 10 años</option>' +
						'	</select>' +
						'</div>' +
						'</div>' +
						'</div>';
				$('#div_fuentes_ingreso').append(div_independientes);
			}
			
			function crearFilaInicialCodeudor(id, nombres, celular, correo) {
				let div_codeudor = '<div class="row" id="div_codeudor_' + id + '" name="div_codeudor_' + id + '" onmouseenter="$(\'#btnEliminarCodeudores' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarCodeudores' + id + '\').css(\'visibility\', \'hidden\')" >' +
							'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
							
							'</div>' +
							'<div class="deudor-control" style="width:405px !important">' +
							'   <label for="nombre_codeudor_deudor_' + id + '">Nombre(s) y apellido(s) persona o Nombre empresa</label>' +
							'	<input type="text" class="form-control" id="nombre_codeudor_deudor_' + id + '" name="nombre_codeudor_deudor_' + id + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + nombres + '" disabled >' +
							'</div>' +
							'<div class="deudor-control" style="width:180px !important">' +
							'	<label for="celular_codeudor_deudor_' + id + '">Celular de contacto</label>' +
							'	<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_codeudor_deudor_' + id + '" name="celular_codeudor_deudor_' + id + '" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + celular + '" disabled >' +
							'</div>' +
                            '<div class="deudor-control deudor-control__correo_codeudor_deudor" style="width:180px !important">' +
							'	<label for="correo_codeudor_deudor_' + id + '">Correo electrónico</label>' +
							'	<input type="email" class="form-control" id="correo_codeudor_deudor_' + id + '" name="correo_codeudor_deudor_' + id + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + correo + '" disabled >' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>';		
				$('#div_caja_codeudor').append(div_codeudor);
			}

			</script>
			
			<script>
				$("#mainForm").submit(function(e){
					e.preventDefault();
				});
			</script>

            <script>
                $(document).ready(function() {
                    $('.js-example-basic-single').select2();
                });
            </script>
		</html>
		<?php
    }
}