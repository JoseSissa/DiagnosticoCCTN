<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class MainView
{
    public function __construct($listado_ciudades, $listado_actividades_economicas)
    {
        //Campos traídos de la página principal de Vanka
        if (isset($_GET['tipo_persona'])) { $_SESSION['tipo_persona'] = $_GET['tipo_persona']; }
        if (isset($_GET['valor_solicitado'])) { $_SESSION['valor_solicitado'] = $_GET['valor_solicitado']; }
        if (isset($_GET['plazo'])) { $_SESSION['plazo'] = $_GET['plazo']; }
        if (isset($_GET['destino_credito'])) { $_SESSION['destino_credito'] = $_GET['destino_credito']; }
        if (isset($_GET['referido'])) { $_SESSION['referido'] = $_GET['referido']; }
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

            .select2 {
                width: 100% !important;
            }
            .select2-selection {
                padding: .375rem .75rem !important;
                height: calc(1.5em + .75rem + 2px) !important;;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 100% !important;
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
                .deudor-control__celular_codeudor
                {
                    margin-left: 70px;
                }
            }
			/* Chrome, Safari, Edge, Opera */
			.deudor-control__codigo-redimir::-webkit-outer-spin-button,
			.deudor-control__codigo-redimir::-webkit-inner-spin-button {
			  -webkit-appearance: none;
			  margin: 0;
			}

			/* Firefox */
			deudor-control__codigo-redimir {
			  -moz-appearance: textfield;
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
                <h2 class="solo-movil">Comencemos a impulsar <b>tus sueños</b></h2>
            </div>

            <div class="container">
                <form class="needs-validation" id="mainForm" name="mainForm" action="registrar_datos_deudor" method="POST" role="form" enctype="multipart/form-data" autocomplete="off" >

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
                                <input type="hidden" id="tipo_persona" name="tipo_persona" value="<?php if (isset($_SESSION['tipo_persona'])) { echo $_SESSION['tipo_persona']; } ?>" />
                                <div>
                                    <button id="btnPersonaJuridica" name="btnPersonaJuridica" class="boton-formulario" type="button" onclick="validarBotonPersona(this)">Persona jurídica</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control deudor-control__valor-solicitado">
                                    <label for="valor_solicitado">Valor solicitado</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_solicitado" name="valor_solicitado" oninput="validarValorSolicitado(this)" onchange="validarDivPersona()" onfocusout="mensajeValorSolicitado(this)" placeholder="Escribe..." value="<?php if (isset($_SESSION['valor_solicitado'])) { echo $_SESSION['valor_solicitado']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__plazo">
                                    <label for="plazo">Plazo (meses)</label>
                                    <select class="form-control" id="plazo" name="plazo" onchange="validarDivPersona()" required >
                                        <option value="" >-Escoge-</option>
                                        <option value="6" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "6") { echo " selected "; } } ?> >6</option>
                                        <option value="12" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "12") { echo " selected "; } } ?> >12</option>
                                        <option value="18" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "18") { echo " selected "; } } ?> >18</option>
                                        <option value="24" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "24") { echo " selected "; } } ?> >24</option>
                                        <option value="30" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "30") { echo " selected "; } } ?> >30</option>
                                        <option value="36" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "36") { echo " selected "; } } ?> >36</option>
                                        <option value="42" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "42") { echo " selected "; } } ?> >42</option>
                                        <option value="48" <?php if (isset($_SESSION['plazo'])) { if ($_SESSION['plazo'] == "48") { echo " selected "; } } ?> >48</option>
                                    </select>
                                </div>
                                <div class="deudor-control deudor-control__destino-credito">
                                    <label for="destino_credito">Destino del crédito (Por favor describir el rubro del plan de inversión)</label>
                                    <input type="text" class="form-control" id="destino_credito" name="destino_credito" onchange="validarDivPersona()" placeholder="Escribe..." value="<?php if (isset($_SESSION['destino_credito'])) { echo $_SESSION['destino_credito']; } ?>" required >
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
                                    <input type="text" class="form-control" id="nombres" name="nombres" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombres'])) { echo $_SESSION['nombres']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px" >
                                    <label for="primer_apellido">Primer apellido</label>
                                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['primer_apellido'])) { echo $_SESSION['primer_apellido']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px" >
                                    <label for="segundo_apellido">Segundo apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['segundo_apellido'])) { echo $_SESSION['segundo_apellido']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 120px; padding-right: 10px;">
                                    <label for="tipo_identificacion">Identificación</label>
                                    <select class="form-control" id="tipo_identificacion" name="tipo_identificacion" onchange="validarDivDatosPersonales()" required >
                                        <option value="cedula_ciudadania" <?php if (isset($_SESSION['tipo_identificacion'])) { if ($_SESSION['tipo_identificacion'] == "cedula_ciudadania") { echo " selected "; } } ?> >C.C.</option>
                                        <option value="cedula_extranjeria" <?php if (isset($_SESSION['tipo_identificacion'])) { if ($_SESSION['tipo_identificacion'] == "cedula_extranjeria") { echo " selected "; } } ?> >C.E.</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 330px; padding-right: 10px;">
                                    <label class="label-invisible" for="numero_identificacion" >-</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_identificacion" name="numero_identificacion" onchange="validarDivDatosPersonales()" placeholder="Número" value="<?php if (isset($_SESSION['numero_identificacion'])) { echo $_SESSION['numero_identificacion']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;">
                                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                    <input type="text" onchange="validarDivDatosPersonales()" max="<?php echo date("Y-m-d", strtotime("-18 year", strtotime(date("Y-m-d")))); ?>" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="dd-mm-yyyy" value="<?php if (isset($_SESSION['fecha_nacimiento'])) { echo $_SESSION['fecha_nacimiento']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 200px; padding-right: 10px;">
                                    <label for="ciudad">Ciudad</label>
                                    <select class="form-control js-example-basic-single" id="ciudad" name="ciudad" onchange="validarDivDatosPersonales()" required >
                                        <option selected>-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad'])) { if ($_SESSION['ciudad'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
                                            echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 250px;">
                                    <label for="barrio">Dirección</label>
                                    <input type="text" class="form-control" id="barrio" name="barrio" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['barrio'])) { echo $_SESSION['barrio']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;" >
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="telefono" name="telefono" maxlength="10" onchange="validarDivDatosPersonales()" placeholder="Opcional" value="<?php if (isset($_SESSION['telefono'])) { echo $_SESSION['telefono']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;">
                                    <label for="celular">Celular</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular" name="celular" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivDatosPersonales()" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['celular'])) { echo $_SESSION['celular']; } ?>" required >
                                </div>
                                <div class="deudor-control deudor-control__personas_a_cargo" style="width: 200px; padding-right: 10px;">
                                    <label for="personas_a_cargo">Personas a cargo</label>
                                    <select class="form-control" id="personas_a_cargo" name="personas_a_cargo" onchange="validarDivDatosPersonales();" required>
                                        <option value="" >-Escoge-</option>
                                        <option value=0 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "0") { echo " selected "; } } ?> >0</option>
                                        <option value=1 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "1") { echo " selected "; } } ?> >1</option>
                                        <option value=2 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "2") { echo " selected "; } } ?> >2</option>
                                        <option value=3 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "3") { echo " selected "; } } ?> >3</option>
                                        <option value=4 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "4") { echo " selected "; } } ?> >4</option>
                                        <option value=5 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "5") { echo " selected "; } } ?> >5</option>
                                        <option value=6 <?php if (isset($_SESSION['personas_a_cargo'])) { if ($_SESSION['personas_a_cargo'] == "6") { echo " selected "; } } ?> >6</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="estado_civil">Estado civil</label>
                                    <select class="form-control" id="estado_civil" name="estado_civil" onchange="validarDivDatosPersonales(); validarEstadoCivil();" required>
                                        <option value="" >-Escoge-</option>
                                        <option value="soltero" <?php if (isset($_SESSION['estado_civil'])) { if ($_SESSION['estado_civil'] == "soltero") { echo " selected "; } } ?> >Soltero/a</option>
                                        <option value="casado" <?php if (isset($_SESSION['estado_civil'])) { if ($_SESSION['estado_civil'] == "casado") { echo " selected "; } } ?> >Casado/a</option>
                                        <option value="separado" <?php if (isset($_SESSION['estado_civil'])) { if ($_SESSION['estado_civil'] == "separado") { echo " selected "; } } ?> >Separado/a</option>
                                        <option value="viudo" <?php if (isset($_SESSION['estado_civil'])) { if ($_SESSION['estado_civil'] == "viudo") { echo " selected "; } } ?> >Viudo/a</option>
                                        <option value="union_libre" <?php if (isset($_SESSION['estado_civil'])) { if ($_SESSION['estado_civil'] == "union_libre") { echo " selected "; } } ?> >Unión libre</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="tipo_vivienda">Vivienda</label>
                                    <select class="form-control" id="tipo_vivienda" name="tipo_vivienda" onchange="validarDivDatosPersonales(); validarTipoVivienda();" required >
                                        <option value="" >-Escoge-</option>
                                        <option value="arrendada" <?php if (isset($_SESSION['tipo_vivienda'])) { if ($_SESSION['tipo_vivienda'] == "arrendada") { echo " selected "; } } ?> >Arrendada</option>
                                        <option value="propia" <?php if (isset($_SESSION['tipo_vivienda'])) { if ($_SESSION['tipo_vivienda'] == "propia") { echo " selected "; } } ?> >Propia</option>
                                        <option value="familiar" <?php if (isset($_SESSION['tipo_vivienda'])) { if ($_SESSION['tipo_vivienda'] == "familiar") { echo " selected "; } } ?> >Familiar</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="estrato">Estrato</label>
                                    <select class="form-control" id="estrato" name="estrato" onchange="validarDivDatosPersonales()" required>
                                        <option value="" >-Escoge-</option>
                                        <option value="1" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "1") { echo " selected "; } } ?> >1</option>
                                        <option value="2" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "2") { echo " selected "; } } ?> >2</option>
                                        <option value="3" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "3") { echo " selected "; } } ?> >3</option>
                                        <option value="4" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "4") { echo " selected "; } } ?> >4</option>
                                        <option value="5" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "5") { echo " selected "; } } ?> >5</option>
                                        <option value="6" <?php if (isset($_SESSION['estrato'])) { if ($_SESSION['estrato'] == "6") { echo " selected "; } } ?> >6</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 400px;">
                                    <label for="correo">Correo electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" onchange="validarDivDatosPersonales()" placeholder="nombre@correo.com" value="<?php if (isset($_SESSION['correo'])) { echo $_SESSION['correo']; } ?>" required >
                                </div>
                            </div>
                            <div class="row" id="div_datos_conyuge" name="div_datos_conyuge">
                                <div class="deudor-control" style="width: 280px">
                                    <label for="nombre_apellido_conyuge">Nombre / Apellido Cónyuge</label>
                                    <input type="text" class="form-control" id="nombre_apellido_conyuge" name="nombre_apellido_conyuge" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombre_apellido_conyuge'])) { echo $_SESSION['nombre_apellido_conyuge']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 170px">
                                    <label for="celular_conyuge">Celular cónyuge</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_conyuge" name="celular_conyuge" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivDatosPersonales()" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['celular_conyuge'])) { echo $_SESSION['celular_conyuge']; } ?>" >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 400px">
                                    <label for="ciudad_conyuge">Ciudad residencia</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_conyuge" name="ciudad_conyuge" onchange="validarDivDatosPersonales()" required >
                                        <option selected>-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_conyuge'])) { if ($_SESSION['ciudad_conyuge'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
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
                                    <label for="nombre_empresa">Nombre de la empresa (verifique que sea el nombre como registra en certificado de Cámara de Comercio o de Registro único tributario (RUT))</label>
                                    <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombre_empresa'])) { echo $_SESSION['nombre_empresa']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="nit">NIT</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.-]*" class="form-control" id="nit" name="nit" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nit'])) { echo $_SESSION['nit']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 300px;">
                                    <label for="direccion_empresa">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_empresa" name="direccion_empresa" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['direccion_empresa'])) { echo $_SESSION['direccion_empresa']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 330px;">
                                    <label for="ciudad_empresa">Ciudad</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_empresa" name="ciudad_empresa" onchange="validarDivDatosEmpresariales()" required >
                                        <option selected>-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_empresa'])) { if ($_SESSION['ciudad_empresa'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
                                            echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 200px;">
                                    <label for="numero_contacto_empresa">Número de contacto</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_contacto_empresa" name="numero_contacto_empresa" maxlength="15" onchange="validarDivDatosEmpresariales()" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['numero_contacto_empresa'])) { echo $_SESSION['numero_contacto_empresa']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 300px;" >
                                    <label for="actividad_economica_empresa">Actividad económica principal</label>
                                    <select class="form-control js-example-basic-single" id="actividad_economica_empresa" name="actividad_economica_empresa" onchange="validarDivDatosEmpresariales()" required >
                                        <option selected>-Escoge-</option>
                                        <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                                            <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>" <?php if (isset($_SESSION['actividad_economica_empresa'])): ?><?php if ($_SESSION['actividad_economica_empresa'] == $listado_actividades_economicas[$i]['codigo']): ?> selected <?php endif; ?><?php endif; ?> ><?= mb_convert_case($listado_actividades_economicas[$i]['nombre'], MB_CASE_TITLE, "UTF-8"); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 330px;">
                                    <label for="redes_sociales_empresa">Redes sociales</label>
                                    <input type="text" class="form-control" id="redes_sociales_empresa" name="redes_sociales_empresa" onchange="validarDivDatosEmpresariales()" placeholder="Opcional" value="<?php if (isset($_SESSION['redes_sociales_empresa'])) { echo $_SESSION['redes_sociales_empresa']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 230px;">
                                    <label for="antiguedad_empresa">Antigüedad empresa</label>
                                    <input type="number" class="form-control" id="antiguedad_empresa" name="antiguedad_empresa" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="validarDivDatosEmpresariales()" placeholder="Años..." value="<?php if (isset($_SESSION['antiguedad_empresa'])) { echo $_SESSION['antiguedad_empresa']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 270px">
                                    <label for="migrante-retornado">¿Alguno de los socios o accionistas de la empresa es migrante venezolano o colombiano retornado?</label>
                                    <select class="form-control" id="migrante-retornado" name="migrante-retornado" onchange="validarDivPersona()" required >
                                        <option value="" >-Escoge-</option>
                                        <option value="si" <?php if (isset($_SESSION['migrante-retornado'])) { if ($_SESSION['migrante-retornado'] == "6") { echo " selected "; } } ?> >Si</option>
                                        <option value="no" <?php if (isset($_SESSION['migrante-retornado'])) { if ($_SESSION['migrante-retornado'] == "12") { echo " selected "; } } ?> >No</option>
                                    </select>
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
                                    <img src="Resources/img/boton-agregar.svg" style="cursor: pointer;" onmouseenter="animacionBotonAgregarAlPasarMouse($(this), 1);" onmouseleave="animacionBotonAgregarAlPasarMouse($(this), 0);" onclick="animacionBotonAgregarAlPresionar($(this)); crearFilaEmpleado(); validarDivFuentesIngresoPersonaNatural(); " />
                                    <span style="vertical-align: middle; padding-left: 5px"><b>Empleado</b></span>
                                </div>
                                <div style="padding: 10px 10px">
                                    <img src="Resources/img/boton-agregar.svg" style="cursor: pointer;" onmouseenter="animacionBotonAgregarAlPasarMouse($(this), 1);" onmouseleave="animacionBotonAgregarAlPasarMouse($(this), 0);" onclick="animacionBotonAgregarAlPresionar($(this)); crearFilaIndependiente(); validarDivFuentesIngresoPersonaNatural(); " />
                                    <span style="vertical-align: middle; padding-left: 5px"><b>Independiente</b></span>
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
                                <div class="deudor-control" style="width: 230px; padding-right: 70px" >
                                    <label><span style="color: white; ">-</span><br><b>Ingreso mensual</b></label>
                                </div>
                                <div class="deudor-control deudor-control__ingreso-principal" style="width:200px">
                                    <label for="honorarios">Ingreso principal</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="honorarios" name="honorarios" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['honorarios'])) { echo $_SESSION['honorarios']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__comisiones" style="width:200px">
                                    <label for="comisiones">Comisiones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="comisiones" name="comisiones" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Opcional..." value="<?php if (isset($_SESSION['comisiones'])) { echo $_SESSION['comisiones']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__otros-ingresos" style="width:200px">
                                    <label for="otros_ingresos">Otros ingresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="otros_ingresos" name="otros_ingresos" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Opcional..." value="<?php if (isset($_SESSION['otros_ingresos'])) { echo $_SESSION['otros_ingresos']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width: 230px; padding-right: 75px">
                                    <label><span style="color: white; ">-</span><br><b>Gastos por mes</b></label>
                                </div>
                                <div class="deudor-control deudor-control__gastos-generales" style="width:200px">
                                    <label for="gasto_personal_familiar">Gastos generales</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="gasto_personal_familiar" name="gasto_personal_familiar" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Alimentación, educación, ocio..." value="<?php if (isset($_SESSION['gasto_personal_familiar'])) { echo $_SESSION['gasto_personal_familiar']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__arriendo-vivienda" id="div_arriendo_vivienda" name="div_arriendo_vivienda" style="width:200px">
                                    <label for="arriendo_vivienda">Arriendo vivienda</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="arriendo_vivienda" name="arriendo_vivienda" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cifra..." value="<?php if (isset($_SESSION['arriendo_vivienda'])) { echo $_SESSION['arriendo_vivienda']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__obligaciones" style="width:200px">
                                    <label for="cuotas_creditos">Obligaciones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="cuotas_creditos" name="cuotas_creditos" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cuotas préstamos..." value="<?php if (isset($_SESSION['cuotas_creditos'])) { echo $_SESSION['cuotas_creditos']; } ?>" >
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
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_ingresos_mensuales" name="conyuge_ingresos_mensuales" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['conyuge_ingresos_mensuales'])) { echo $_SESSION['conyuge_ingresos_mensuales']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__conyuge_gastos_mensuales" style="width:200px">
                                    <label for="conyuge_gastos_mensuales">Gastos mensuales</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_gastos_mensuales" name="conyuge_gastos_mensuales" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cifra..." value="<?php if (isset($_SESSION['conyuge_gastos_mensuales'])) { echo $_SESSION['conyuge_gastos_mensuales']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__conyuge_obligaciones" style="width:200px">
                                    <label for="conyuge_obligaciones">Obligaciones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_obligaciones" name="conyuge_obligaciones" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cuotas préstamos..." value="<?php if (isset($_SESSION['conyuge_obligaciones'])) { echo $_SESSION['conyuge_obligaciones']; } ?>" >
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
                            <div class="row d-flex justify-content-center" style="padding-top: 25px; padding: 25px 30px 0 30px">
                                <span>Adjunta los siguientes documentos:</span>
                            </div>
                            <div class="row d-flex" style="padding-top: 25px; justify-content: space-evenly;">
                                <div style="display: flex; flex-direction: column; justify-content: space-between; max-width: 250px;">
                                    <p>Balance general (del año 2022 o del último año que se tenga)</p>
                                    <label class="boton-adjuntar-cedula boton-adjuntar-estados-financieros" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg)" id="adjuntar_estados_financieros_label" name="adjuntar_estados_financieros_label" for="adjuntar_estados_financieros" ><p>Balance general</p><img class="boton-adjuntar-cedula-icono-adjuntar" style="height: 70% !important; " id="adjuntar_estados_financieros_icono_adjuntar" name="adjuntar_estados_financieros_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" /></label>
                                    <input id="adjuntar_estados_financieros" name="adjuntar_estados_financieros[]" type="file" accept="image/*, application/pdf" onclick="animacionBotonAdjuntarAlPresionar($('#adjuntar_estados_financieros_label'));" onchange="validarEstadosFinancieros(); if( $(this).is(':invalid') == false ){ $('*').unbind('invalid'); } " oninvalid="$('*').on('invalid', function(e) { return false }); $('#modalValidacionEstadosFinancieros').modal('show'); document.getElementById('div_informacion_financiera_persona_juridica').scrollIntoView(); " required multiple >
                                </div>
                                <div style="display: flex; flex-direction: column; justify-content: space-between; max-width: 250px;">
                                    <p>Estado de resultados (del año 2022 o del último año que se tenga)</p>
                                    <label class="boton-adjuntar-cedula boton-adjuntar-estados-financieros" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg)" id="adjuntar_estados_financieros_label" name="adjuntar_estados_financieros_label" for="adjuntar_estados_financieros" ><p>Estado de resultados</p><img class="boton-adjuntar-cedula-icono-adjuntar" style="height: 70% !important; " id="adjuntar_estados_financieros_icono_adjuntar" name="adjuntar_estados_financieros_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" /></label>
                                    <input id="adjuntar_estados_financieros" name="adjuntar_estados_financieros[]" type="file" accept="image/*, application/pdf" onclick="animacionBotonAdjuntarAlPresionar($('#adjuntar_estados_financieros_label'));" onchange="validarEstadosFinancieros(); if( $(this).is(':invalid') == false ){ $('*').unbind('invalid'); } " oninvalid="$('*').on('invalid', function(e) { return false }); $('#modalValidacionEstadosFinancieros').modal('show'); document.getElementById('div_informacion_financiera_persona_juridica').scrollIntoView(); " required multiple >
                                </div>
                                <div style="display: flex; flex-direction: column; justify-content: space-between; max-width: 250px;">
                                    <p>Declaración de renta (del año 2022 o del último año que se tenga)</p>
                                    <label class="boton-adjuntar-cedula boton-adjuntar-estados-financieros" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg)" id="adjuntar_estados_financieros_label" name="adjuntar_estados_financieros_label" for="adjuntar_estados_financieros" ><p>Declaración de renta</p><img class="boton-adjuntar-cedula-icono-adjuntar" style="height: 70% !important; " id="adjuntar_estados_financieros_icono_adjuntar" name="adjuntar_estados_financieros_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" /></label>
                                    <input id="adjuntar_estados_financieros" name="adjuntar_estados_financieros[]" type="file" accept="image/*, application/pdf" onclick="animacionBotonAdjuntarAlPresionar($('#adjuntar_estados_financieros_label'));" onchange="validarEstadosFinancieros(); if( $(this).is(':invalid') == false ){ $('*').unbind('invalid'); } " oninvalid="$('*').on('invalid', function(e) { return false }); $('#modalValidacionEstadosFinancieros').modal('show'); document.getElementById('div_informacion_financiera_persona_juridica').scrollIntoView(); " required multiple >
                                </div>
                            </div>
                        </div>
                        <div class="deudor-caja">
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_ingresos">Ingresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_ingresos" name="informacion_financiera_ingresos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_ingresos'])) { echo $_SESSION['informacion_financiera_ingresos']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_activos">Activos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_activos" name="informacion_financiera_activos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_activos'])) { echo $_SESSION['informacion_financiera_activos']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_por_cobrar">Cuentas por cobrar</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_cobrar" name="informacion_financiera_por_cobrar" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_por_cobrar'])) { echo $_SESSION['informacion_financiera_por_cobrar']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_egresos">Egresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_egresos" name="informacion_financiera_egresos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_egresos'])) { echo $_SESSION['informacion_financiera_egresos']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_pasivos">Pasivos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_pasivos" name="informacion_financiera_pasivos" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_pasivos'])) { echo $_SESSION['informacion_financiera_pasivos']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_por_pagar">Cuentas por pagar</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_pagar" name="informacion_financiera_por_pagar" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_por_pagar'])) { echo $_SESSION['informacion_financiera_por_pagar']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_patrimonio">Patrimonio</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_patrimonio" name="informacion_financiera_patrimonio" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_patrimonio'])) { echo $_SESSION['informacion_financiera_patrimonio']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_fecha">Fecha de la información</label>
                                    <div class="input-icon">
                                        <input type="date" onchange="validarDivInformacionFinancieraPersonaJuridica()" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="informacion_financiera_fecha" name="informacion_financiera_fecha" placeholder="dd-mm-yyyy" value="<?php if (isset($_SESSION['informacion_financiera_fecha'])) { echo $_SESSION['informacion_financiera_fecha']; } ?>" required >
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
                                    <img src="Resources/img/boton-agregar.svg" style="cursor: pointer;" onmouseenter="animacionBotonAgregarAlPasarMouse($(this), 1);" onmouseleave="animacionBotonAgregarAlPasarMouse($(this), 0);" onclick="animacionBotonAgregarAlPresionar($(this)); crearFilaVehiculo()" />
                                    <span style="vertical-align: middle; padding-left: 5px"><b>Vehículo</b></span>
                                </div>
                                <div style="padding: 10px 10px">
                                    <img src="Resources/img/boton-agregar.svg" style="cursor: pointer;" onmouseenter="animacionBotonAgregarAlPasarMouse($(this), 1);" onmouseleave="animacionBotonAgregarAlPasarMouse($(this), 0);" onclick="animacionBotonAgregarAlPresionar($(this)); crearFilaInmueble()" />
                                    <span style="vertical-align: middle; padding-left: 5px"><b>Propiedad</b></span>
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
                            <div class="deudor-seccion-listo-con-encabezado" id="div_terminos_y_condiciones_icono_pendiente" name="div_terminos_y_condiciones_icono_pendiente" >
                                <img src="Resources/img/pending.svg" />
                            </div>
                            <div class="deudor-seccion-listo-con-encabezado" id="div_terminos_y_condiciones_icono_completo" name="div_terminos_y_condiciones_icono_completo">
                                <img src="Resources/img/complete.svg" />
                            </div>
                        </div>
                        <div class="deudor-caja" style="margin: 20px 0 0 0 !important" >
                            <div class="row" style="text-align: justify !important; padding: 0px 30px">
                                <p style="word-break: break-word;">
                                Por medio del presente escrito autorizo a Vanka SAS (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio) o a quien represente sus derechos, para que adelante la consulta en relación al comportamiento financiero en las bases de datos propias o de centrales de riesgo (Datacrédito, Cifin, entre otras similares).
                                    <!--<p style="word-break: break-word;">Yo <b><span id="autorizaciones_nombre" name="autorizaciones_nombre">NOMBRE Y</span> <span id="autorizaciones_primer_apellido" name="autorizaciones_primer_apellido">APELLIDO SOLICITANTE</span> <span id="autorizaciones_segundo_apellido" name="autorizaciones_segundo_apellido"></span></b> confirmo haber leído-->
                                    <!--<span id="costo_consulta" name="costo_consulta"></span>.-->
                                </p>
                            </div>
                            <div class="row d-flex justify-content-center" style="padding-top: 4px">
                                <a onclick="$('#modalTerminosYCondiciones').modal('toggle');"><u>Ver términos y condiciones</u></a>
                            </div>
                            <div class="row d-flex justify-content-center" style="padding-top: 20px">
                                <button id="btnAutorizacion" name="btnAutorizacion" class="boton-formulario" style="margin-bottom: 20px" type="button" onclick="validarBotonAutorizacion(this)" >Acepto</button>
                            </div>
                        </div>
                    </div>

                    <div class="deudor-contenedor" id="div_autorizaciones_consulta_centrales" name="div_autorizaciones_consulta_centrales" >
                        <div class="deudor-encabezado" style="height: 65px">
                            <h4 class="deudor-encabezado__titulo" style="margin: 0" >CONSULTA EN CENTRALES DE RIESGO</h4>
                            <div class="deudor-seccion-icono">
                                <img src="Resources/img/icono-terminos-condiciones.svg" />
                            </div>
                            <div class="deudor-seccion-listo-con-encabezado" id="div_terminos_y_condiciones_icono_pendiente" name="div_terminos_y_condiciones_icono_pendiente" >
                                <img src="Resources/img/pending.svg" />
                            </div>
                            <div class="deudor-seccion-listo-con-encabezado" id="div_terminos_y_condiciones_icono_completo" name="div_terminos_y_condiciones_icono_completo">
                                <img src="Resources/img/complete.svg" />
                            </div>
                        </div>
                        <div class="deudor-caja" style="margin: 20px 0 0 0 !important" >
                            <div class="row" style="text-align: justify !important; padding: 0px 30px">
                                <p style="word-break: break-word;">
                                Por medio del presente escrito autorizo a Vanka SAS (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio) o a quien represente sus derechos, para que adelante la consulta en relación al comportamiento financiero en las bases de datos propias o de centrales de riesgo (Datacrédito, Cifin, entre otras similares).
                                    <!--<p style="word-break: break-word;">Yo <b><span id="autorizaciones_nombre" name="autorizaciones_nombre">NOMBRE Y</span> <span id="autorizaciones_primer_apellido" name="autorizaciones_primer_apellido">APELLIDO SOLICITANTE</span> <span id="autorizaciones_segundo_apellido" name="autorizaciones_segundo_apellido"></span></b> confirmo haber leído-->
                                    <!--<span id="costo_consulta" name="costo_consulta"></span>.-->
                                </p>
                            </div>
                            <div class="row d-flex justify-content-center" style="padding-top: 4px">
                                <a onclick="$('#modalConsultaCentrales').modal('toggle');"><u>Ver términos y condiciones</u></a>
                            </div>
                            <div class="row d-flex justify-content-center" style="padding-top: 20px">
                                <button id="btnAutorizacion" name="btnAutorizacion" class="boton-formulario" style="margin-bottom: 20px" type="button" onclick="validarBotonAutorizacion(this)" >Acepto</button>
                                <button id="btnAutorizacion" name="btnAutorizacion" class="boton-formulario" style="margin-bottom: 20px" type="button" onclick="validarBotonAutorizacion(this)" >No acepto</button>
                            </div>
                        </div>
                    </div>

                    <div style="text-align: center; padding-top: 30px; padding-bottom: 200px;" id="div_botones" name="div_botones" >

                        <div style="display: flex; flex-direction: row; align-items: flex-start; justify-content: center; flex-wrap: wrap">
                            <button id="btnSiguiente" name="btnSiguiente" class="boton-siguiente" type="submit" onclick="animacionBotonSiguienteAlPresionar($(this)); validarEstadoBotonSiguiente(); enviarInformacionDeudor();" >Siguiente</button>
                            <!--<button id="btnSiguiente" name="btnSiguiente" class="boton-siguiente" type="submit" >Siguiente</button>-->
                        </div>

                    </div>

                </form>
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

        <!-- Modal para los términos y condiciones -->
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
                            <b>Protección de Datos Personales.</b> Yo <b><span id="proteccion_datos_nombre" name="proteccion_datos_nombre">NOMBRE Y</span> <span id="proteccion_datos_primer_apellido" name="proteccion_datos_primer_apellido">APELLIDO SOLICITANTE</span> <span id="proteccion_datos_segundo_apellido" name="proteccion_datos_segundo_apellido"></span></b>
                            en mi calidad de titular de la información, por medio de la presente, manifiesto mi consentimiento previo, libre, expreso e informado para que
                            Vanka S.A.S. (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio) o a quien represente sus derechos para tratar, consultar, solicitar, procesar, reportar y divulgar los datos personales por mi
                            suministrados, conforme su Política de Tratamiento de Datos Personales y finalidades indicadas. De igual forma, manifiesto que Vanka S.A.S. (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio), de
                            manera clara y expresa, me informó de lo siguiente: (1) los datos personales que serán recolectados o que han sido recolectados; (2) las
                            finalidades específicas del tratamiento de los datos personales recolectados y para los cuales se obtiene el consentimiento; (3) el tratamiento
                            al cual serán sometidos los datos personales y las Políticas para el Tratamiento de Datos Personales, así como el lugar en donde puedo consultar
                            las Políticas y/o solicitar copia de la misma; (4) el carácter facultativo de la respuesta a las preguntas que le sean hechas, cuando estas
                            versen sobre datos sensibles o sobre los datos de las niñas, niños y adolescentes; (5) los derechos que me asisten como titular y el
                            procedimiento para su ejercicio; (6) la identificación, dirección física o electrónica y teléfono del Responsable del Tratamiento. Lo anterior
                            en base a las leyes 1712 de 2014 y 1377 de 2013.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Consulta en centrales de riesgo -->
        <div class="modal fade" style="overflow-y: scroll; -webkit-overflow-scrolling: touch; " data-backdrop="static" data-keyboard="false" id="modalConsultaCentrales" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 900px !important" role="document">
                <div class="modal-content" style="max-width: 900px" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitulo">Consulta en centrales de riesgo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <b>Consulta en centrales de riesgo.</b> Yo <b><span id="consulta_centrales_nombre" name="consulta_centrales_nombre">NOMBRE Y</span> <span id="consulta_centrales_primer_apellido" name="consulta_centrales_primer_apellido">APELLIDO SOLICITANTE</span> <span id="consulta_centrales_segundo_apellido" name="consulta_centrales_segundo_apellido"></span></b>
                            autorizo, de forma expresa, informada y consentida a Vanka S.A.S. (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio) o a quien represente sus derechos, para que adelante las consultas que sean
                            necesarias en las bases o bancos de datos propias o de centrales de riesgo (desacredito, cifin, entre otras y similares) relativas a mi
                            comportamiento comercial, crediticio y el manejo de los diferentes productos de las entidades financieras, solidarias, del sector real y
                            similares que tenga y, en general, sobre el cumplimiento de todas las obligaciones de carácter pecuniario a mi cargo. Igualmente, autorizo a
                            Vanka S.A.S. (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio) para que haga los reportes pertinentes a las centrales de riesgos existentes o que llegaren a existir, de datos, tratados o sin
                            tratar, tanto sobre el cumplimiento oportuno como sobre el incumplimiento, si lo hubiera, de las obligaciones, o de los deberes legales o
                            contractuales de contenido patrimonial cuando quiera que incurra en mora en el pago de mis obligaciones con Vanka S.A.S. (aliado de 5T SAS y Cámara de Comercio de Bucaramanga para el programa Creciendo con tu Negocio).
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="boton-formulario active" type="button" data-dismiss="modal" >Regresar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" style="overflow-y: scroll; -webkit-overflow-scrolling: touch; " data-backdrop="static" data-keyboard="false" id="modalSenhal" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 900px !important" role="document">
                <div class="modal-content" style="max-width: 900px" >
                    <div class="modal-header">
                        <img class="modal-icon" height=38 src="Resources/img/internet_icon.svg" />
                        <h5 class="modal-title" id="modalTitulo">Aviso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Asegúrate de tener una señal estable y fuerte para el registro correcto del formulario.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="boton-formulario active" type="button" data-dismiss="modal" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalValorSolicitado" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 500px !important;" role="document">
                <div class="modal-content" style="max-width: 500px" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitulo">Aviso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-valor-solicitado-body" style="overflow-y: hidden; padding: 8px 16px">
                        <p style="margin: 0">
                            Monto mínimo de 3'000.000 COP
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="boton-formulario active" type="button" data-dismiss="modal" >Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        </body>

        <!-- Encabezados fijos y ajuste de controles en forma inválida  -->
        <script>
            window.addEventListener('load', () => {
                document.getElementById('btnPersonaJuridica').click()
            })

            var form = $('#mainForm');
            //var navbar = $('#div_datos_personales .deudor-encabezado')

            form.find(':input').on('invalid', function (event) {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {
                    var input = $(this)

                    //Primer elemento inválido
                    var first = form.find(':invalid').first()

                    //Solo se ejecuta si es el primer elemento inválido
                    if (input[0] === first[0]) {

                        //var navbarHeight = navbar.height() + 50
                        var navbarHeight = 55 + 50
                        var elementOffset = input.offset().top - navbarHeight
                        var pageOffset = window.pageYOffset - navbarHeight

                        //No hacer scroll si el elemento está actualmente en vista
                        if (elementOffset > pageOffset && elementOffset < pageOffset + window.innerHeight) {
                            return true
                        }

                        $('html,body').scrollTop(elementOffset)
                    }
                }
            })

            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {

                $("#modalSenhal").modal('toggle');

                $("#div_datos_personales").focusin(function() {
                    $("#div_datos_personales .deudor-encabezado").addClass("fijo");
                });
                $("#div_datos_personales").focusout(function() {
                    $("#div_datos_personales .deudor-encabezado").removeClass("fijo");
                });

                $("#div_fuentes_ingreso_persona_natural").focusin(function() {
                    $("#div_fuentes_ingreso_persona_natural .deudor-encabezado").addClass("fijo");
                });
                $("#div_fuentes_ingreso_persona_natural").focusout(function() {
                    $("#div_fuentes_ingreso_persona_natural .deudor-encabezado").removeClass("fijo");
                });

                $("#div_informacion_financiera_persona_natural").focusin(function() {
                    $("#div_informacion_financiera_persona_natural .deudor-encabezado").addClass("fijo");
                });
                $("#div_informacion_financiera_persona_natural").focusout(function() {
                    $("#div_informacion_financiera_persona_natural .deudor-encabezado").removeClass("fijo");
                });

                $("#div_datos_empresariales").focusin(function() {
                    $("#div_datos_empresariales .deudor-encabezado").addClass("fijo");
                });
                $("#div_datos_empresariales").focusout(function() {
                    $("#div_datos_empresariales .deudor-encabezado").removeClass("fijo");
                });

                $("#div_activos_persona_natural").focusin(function() {
                    $("#div_activos_persona_natural .deudor-encabezado").addClass("fijo");
                });
                $("#div_activos_persona_natural").focusout(function() {
                    $("#div_activos_persona_natural .deudor-encabezado").removeClass("fijo");
                });

                $("#div_codeudor").focusin(function() {
                    $("#div_codeudor .deudor-encabezado").addClass("fijo");
                });
                $("#div_codeudor").focusout(function() {
                    $("#div_codeudor .deudor-encabezado").removeClass("fijo");
                });
            }
        </script>

        <script>

            validarValorSolicitado(document.getElementById("valor_solicitado"));

            $(".deudor-contenedor").focusin(function() {
                $(this).addClass("deudor-contenedor-con-sombra");
            });
            $(".deudor-contenedor").focusout(function() {
                $(this).removeClass("deudor-contenedor-con-sombra");
            });

            // <!-- Evita que el formulario se envíe con Enter -->
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
                    //if (document.getElementById("adjuntar_cedula").files.length) {
                    //if ($("#btnAutorizacion").hasClass("active")) {
                    //$("#btnSiguiente").addClass("boton-siguiente-hover");
                    //$("#btnSiguiente").removeClass("boton-siguiente-listo");
                    $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-hover.svg')");
                    //}
                    //}
                });
                $('#btnSiguiente').mouseleave(function(e) {
                    //if (document.getElementById("adjuntar_cedula").files.length) {
                    //if ($("#btnAutorizacion").hasClass("active")) {
                    //$("#btnSiguiente").removeClass("boton-siguiente-hover");
                    //$("#btnSiguiente").addClass("boton-siguiente-listo");
                    $("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
                    //}
                    //}
                });

                if ($("#btnPersonaJuridica").hasClass("active")) {
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

                $("input[name^='celular_codeudor_deudor_']").on("input", function() {
                    formatNumber($(this));
                });

                $("#telefono").on("input", function() {
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

            function createShareButton(enlace) {
                const btn = document.getElementById("btnCompartirLink");

                const title = "Créditos Vanka - Formulario de codeudor";
                const text = "Haz clic en el siguiente enlace para diligenciar los datos del codeudor de tu crédito Vanka";
                const url = enlace;

                //btn.innerText = "share" in navigator ? "Share" : "Share via e-mail";

                btn.onclick = () => {
                    if (navigator.share !== undefined) {
                        navigator
                            .share({
                                title,
                                text,
                                url
                            })
                            .then(() => console.log("Shared!"))
                            .catch(err => console.error(err));
                    } else {
                        window.location = `mailto:?subject=${title}&body=${text}%0A${url}`;
                    }
                };

                return btn;
            }

            function validarValorSolicitado(input) {
                let val = input.value.replace(/\./g,"");
                if (val < 3000000) {
                    input.setCustomValidity('Ingrese un valor mayor o igual a 3 millones');
                } else {
                    //Reiniciar error por defecto
                    input.setCustomValidity('');
                }
            }

            function mensajeValorSolicitado(input) {
                let val = input.value.replace(/\./g,"");
                if (val < 3000000) {
                    $("#modalValorSolicitado").modal('toggle');
                }
            }

            function validarEstadoBotonSiguiente() {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {
                    //if (document.getElementById("adjuntar_cedula").files.length) {
                    //if ($("#btnAutorizacion").hasClass("active")) {
                    //$("#btnSiguiente").addClass("boton-siguiente-hover");
                    $("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-presionado.svg')");
                    $("#btnSiguiente").css("background-image-crossorigin", "anonymous");
                    //alert($("#btnSiguiente").css("background-image"));
                    //$("#btnSiguiente").removeClass("boton-siguiente-listo");
                    //$("#btnSiguiente").css("background-image", "url()");

                    setTimeout(function(){
                        //$("#btnSiguiente").removeClass("boton-siguiente-hover");
                        $("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
                        $("#btnSiguiente").css("background-image-crossorigin", "anonymous");
                        //alert(2);
                        //$("#btnSiguiente").addClass("boton-siguiente-listo");
                        //$("#btnSiguiente").css("background-image", "url()");
                    }, 1000);
                    //}
                    //}
                }
            }

            function formatCurrency(element) {
                //console.log(element);
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
            $("#div_informacion_financiera_persona_juridica_icono_pendiente").hide();
            $("#div_informacion_financiera_persona_juridica_icono_completo").hide();
            $("#div_datos_empresariales_icono_pendiente").hide();
            $("#div_datos_empresariales_icono_completo").hide();
            $("#div_codeudor_icono_pendiente").hide();
            $("#div_codeudor_icono_completo").hide();
            $("#div_terminos_y_condiciones_icono_pendiente").hide();
            $("#div_terminos_y_condiciones_icono_completo").hide();

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

            validarCedula();
            validarEstadosFinancieros();

            validarEstadoCivil();
            validarTipoVivienda();
            validacionInicialBotonPersona();

            /*validarDivPersona();
            validarDivDatosPersonales();
            validarDivFuentesIngresoPersonaNatural();
            validarDivInformacionFinancieraPersonaNatural();
            validarDivDatosEmpresariales();
            validarDivCodeudor();*/

            function validarDivPersona() {
                if ($("#valor_solicitado").val().length > 0
                    && $("#plazo").val().length > 0
                    && $("#destino_credito").val().length > 0)
                {
                    $("#div_persona_icono_pendiente").hide();
                    $("#div_persona_icono_completo").show();
                }
                else {
                    $("#div_persona_icono_pendiente").show();
                    $("#div_persona_icono_completo").hide();
                }
            }

            function validarDivDatosPersonales() {
                if ($("#primer_apellido").val().length > 0
                    && $("#segundo_apellido").val().length > 0
                    && $("#nombres").val().length > 0
                    && $("#tipo_identificacion").val().length > 0
                    && $("#numero_identificacion").val().length > 0
                    && $("#fecha_nacimiento").val().length > 0
                    && $("#ciudad").val().length > 0
                    && $("#barrio").val().length > 0
                    && $("#celular").val().length > 0
                    && $("#correo").val().length > 0
                    && $("#estado_civil").val().length > 0
                    && $("#tipo_vivienda").val().length > 0
                    && $("#estrato").val().length > 0
                    && $("#personas_a_cargo").val().length > 0)
                {
                    if ($("#estado_civil").val() == "casado" || $("#estado_civil").val() == "union_libre") {
                        if ($("#nombre_apellido_conyuge").val().length > 0
                            && $("#celular_conyuge").val().length > 0
                            && $("#ciudad_conyuge").val().length > 0) {

                            $("#div_datos_personales_icono_pendiente").hide();
                            $("#div_datos_personales_icono_completo").show();
                        }
                        else {
                            $("#div_datos_personales_icono_pendiente").show();
                            $("#div_datos_personales_icono_completo").hide();
                        }
                    }
                    else {
                        $("#div_datos_personales_icono_pendiente").hide();
                        $("#div_datos_personales_icono_completo").show();
                    }
                }
                else {
                    $("#div_datos_personales_icono_pendiente").show();
                    $("#div_datos_personales_icono_completo").hide();
                }
            }

            function validarDivFuentesIngresoPersonaNatural() {
                var total_fuentes_ingreso = $('div[name^="div_empleados"]:not([name^="div_empleados_icono"])' ).length + $('div[name^="div_independientes"]:not([name^="div_independientes_icono"])' ).length;

                if (total_fuentes_ingreso > 0) {
                    $("#div_fuentes_ingreso_persona_natural_icono_pendiente").hide();
                    $("#div_fuentes_ingreso_persona_natural_icono_completo").show();
                }
                else {
                    $("#div_fuentes_ingreso_persona_natural_icono_pendiente").show();
                    $("#div_fuentes_ingreso_persona_natural_icono_completo").hide();
                }
            }

            function validarDivInformacionFinancieraPersonaNatural() {
                if ($("#honorarios").val().length > 0
                    && $("#gasto_personal_familiar").val().length > 0)
                {
                    if ($("#estado_civil").val() == "casado" || $("#estado_civil").val() == "union_libre") {
                        if ($("#conyuge_ingresos_mensuales").val().length > 0
                            && $("#conyuge_gastos_mensuales").val().length > 0) {

                            $("#div_informacion_financiera_persona_natural_icono_pendiente").hide();
                            $("#div_informacion_financiera_persona_natural_icono_completo").show();
                        }
                        else {
                            $("#div_informacion_financiera_persona_natural_icono_pendiente").show();
                            $("#div_informacion_financiera_persona_natural_icono_completo").hide();
                        }
                    }
                    else {
                        $("#div_informacion_financiera_persona_natural_icono_pendiente").hide();
                        $("#div_informacion_financiera_persona_natural_icono_completo").show();
                    }
                }
                else {
                    $("#div_informacion_financiera_persona_natural_icono_pendiente").show();
                    $("#div_informacion_financiera_persona_natural_icono_completo").hide();
                }
            }

            function validarDivInformacionFinancieraPersonaJuridica() {
                if ($("#informacion_financiera_ingresos").val().length > 0
                    && $("#informacion_financiera_activos").val().length > 0
                    && $("#informacion_financiera_por_cobrar").val().length > 0
                    && $("#informacion_financiera_egresos").val().length > 0
                    && $("#informacion_financiera_pasivos").val().length > 0
                    && $("#informacion_financiera_por_pagar").val().length > 0
                    && $("#informacion_financiera_patrimonio").val().length > 0
                    && $("#informacion_financiera_fecha").val().length > 0)
                {
                    $("#div_informacion_financiera_persona_juridica_icono_pendiente").hide();
                    $("#div_informacion_financiera_persona_juridica_icono_completo").show();
                }
                else {
                    $("#div_informacion_financiera_persona_juridica_icono_pendiente").show();
                    $("#div_informacion_financiera_persona_juridica_icono_completo").hide();
                }
            }

            function validarDivDatosEmpresariales() {
                if ($("#nombre_empresa").val().length > 0
                    && $("#nit").val().length > 0
                    && $("#direccion_empresa").val().length > 0
                    && $("#ciudad_empresa").val().length > 0
                    && $("#numero_contacto_empresa").val().length > 0
                    && $("#actividad_economica_empresa").val().length > 0
                    && $("#antiguedad_empresa").val().length > 0
                    && $("#primer_apellido_representante_legal").val().length > 0
                    && $("#segundo_apellido_representante_legal").val().length > 0
                    && $("#nombres_representante_legal").val().length > 0
                    && $("#tipo_identificacion_representante_legal").val().length > 0
                    && $("#numero_identificacion_representante_legal").val().length > 0
                    && $("#correo_representante_legal").val().length > 0
                    && $("#ciudad_representante_legal").val().length > 0
                    && $("#direccion_representante_legal").val().length > 0
                    && $("#celular_representante_legal").val().length > 0)
                {
                    $("#div_datos_empresariales_icono_pendiente").hide();
                    $("#div_datos_empresariales_icono_completo").show();
                }
                else {
                    $("#div_datos_empresariales_icono_pendiente").show();
                    $("#div_datos_empresariales_icono_completo").hide();
                }
            }

            function validarDivCodeudor() {
                var total_codeudores = $('div[name^="div_codeudor_"]:not([name^="div_codeudor_icono"])' ).length;

                if (total_codeudores > 0) {
                    $("#div_codeudor_icono_pendiente").hide();
                    $("#div_codeudor_icono_completo").show();
                }
                else {
                    $("#div_codeudor_icono_pendiente").show();
                    $("#div_codeudor_icono_completo").hide();
                }
            }

            function validacionInicialBotonPersona() {
                if ($("#tipo_persona").val() == "juridica") {
                    validarBotonPersona(document.getElementById("btnPersonaJuridica"));
                }
            }
            
            function validarBotonPersona(elem) {
                $("#div_codeudor").show();
                $("#div_autorizaciones").show();
                $("#div_botones").show();
                $("#adjuntar_cedula").attr("required", true);

                if (elem.name == "btnPersonaNatural") {
                    $("#costo_consulta").text('SEIS MIL QUINIENTOS PESOS M/CTE ($6.500.oo) por persona');

                    $("#btnPersonaNatural").addClass('active');
                    $("#btnPersonaJuridica").removeClass('active');
                    $("#tipo_persona").val("natural");

                    $("#div_datos_personales").show();
                    $("#primer_apellido").attr("required", true);
                    $("#segundo_apellido").attr("required", true);
                    $("#nombres").attr("required", true);
                    $("#tipo_identificacion").attr("required", true);
                    $("#numero_identificacion").attr("required", true);
                    $("#fecha_nacimiento").attr("required", true);
                    $("#ciudad").attr("required", true);
                    $("#barrio").attr("required", true);
                    $("#celular").attr("required", true);
                    $("#correo").attr("required", true);
                    $("#estado_civil").attr("required", true);
                    $("#tipo_vivienda").attr("required", true);
                    $("#estrato").attr("required", true);
                    $("#personas_a_cargo").attr("required", true);
                    if ($("#estado_civil").val() == "casado" || $("#estado_civil").val() == "union_libre") {
                        $("#nombre_apellido_conyuge").attr("required", true);
                        $("#celular_conyuge").attr("required", true);
                        $("#ciudad_conyuge").attr("required", true);
                    }
                    else {
                        $("#nombre_apellido_conyuge").removeAttr("required");
                        $("#celular_conyuge").removeAttr("required");
                        $("#ciudad_conyuge").removeAttr("required");
                    }

                    $("#div_fuentes_ingreso_persona_natural").show();

                    $("#div_informacion_financiera_persona_natural").show();
                    $("#honorarios").attr("required", true);
                    $("#gasto_personal_familiar").attr("required", true);
                    if ($("#estado_civil").val() == "casado" || $("#estado_civil").val() == "union_libre") {
                        $("#conyuge_ingresos_mensuales").attr("required", true);
                        $("#conyuge_gastos_mensuales").attr("required", true);
                    }
                    else {
                        $("#conyuge_ingresos_mensuales").removeAttr("required");
                        $("#conyuge_gastos_mensuales").removeAttr("required");
                    }

                    $("#div_activos_persona_natural").show();

                    $("#div_datos_empresariales *").removeAttr("required");
                    $("#div_datos_empresariales").hide();
                    $("#div_informacion_financiera_persona_juridica *").removeAttr("required");
                    $("#div_informacion_financiera_persona_juridica").hide();

                    //$("#adjuntar_cedula_label").text("Adjuntar cédula");
                    /*$("#texto_adjuntar_cedula").text("Adjuntar cédula");
                    if (/iPhone|iPad|iPod/i.test(navigator.userAgent) == true ) {
                        $("#adjuntar_cedula_label").css("height", "unset");
                    }*/
                    //$("#adjuntar_cedula_check").css("transform", "translate(-50%, 0%)");

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
                    $("#nombre_empresa").attr("required", true);
                    $("#nit").attr("required", true);
                    $("#direccion_empresa").attr("required", true);
                    $("#ciudad_empresa").attr("required", true);
                    $("#numero_contacto_empresa").attr("required", true);
                    $("#actividad_economica_empresa").attr("required", true);
                    $("#antiguedad_empresa").attr("required", true);
                    $("#primer_apellido_representante_legal").attr("required", true);
                    $("#segundo_apellido_representante_legal").attr("required", true);
                    $("#nombres_representante_legal").attr("required", true);
                    $("#tipo_identificacion_representante_legal").attr("required", true);
                    $("#numero_identificacion_representante_legal").attr("required", true);
                    $("#correo_representante_legal").attr("required", true);
                    $("#ciudad_representante_legal").attr("required", true);
                    $("#direccion_representante_legal").attr("required", true);
                    $("#celular_representante_legal").attr("required", true);

                    $("#div_informacion_financiera_persona_juridica").show();
                    $("#div_informacion_financiera_persona_juridica *").attr("required", true);

                    //$("#adjuntar_cedula_label").text("Adjuntar cédula representante legal");
                    /*$("#texto_adjuntar_cedula").text("Adjuntar cédula representante legal");
                    if (/iPhone|iPad|iPod/i.test(navigator.userAgent) == true ) {
                        $("#adjuntar_cedula_label").css("height", "95px");
                    }*/
                    //$("#adjuntar_cedula_check").css("transform", "translate(0%, 0%)");

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

            /*function habilitarSiguiente() {

                if ($("#tipo_persona").val() == "natural") {
                    if ($("#btnAutorizacion").hasClass("active") &&
                        document.getElementById("adjuntar_cedula").files.length) {

                        $("#btnSiguiente").addClass('boton-siguiente-listo');
                        $("#btnSiguiente").removeClass('boton-siguiente-desactivado');
                        $("#btnSiguiente").attr('disabled', false);
                    }
                    else {
                        $("#btnSiguiente").addClass('boton-siguiente-desactivado');
                        $("#btnSiguiente").removeClass('boton-siguiente-listo');
                        $("#btnSiguiente").attr('disabled', true);
                    }
                }

                else {
                    if ($("#btnAutorizacion").hasClass("active") &&
                        document.getElementById("adjuntar_cedula").files.length &&
                        document.getElementById("adjuntar_estados_financieros").files.length) {

                        $("#btnSiguiente").addClass('boton-siguiente-listo');
                        $("#btnSiguiente").removeClass('boton-siguiente-desactivado');
                        $("#btnSiguiente").attr('disabled', false);
                    }
                    else {
                        $("#btnSiguiente").addClass('boton-siguiente-desactivado');
                        $("#btnSiguiente").removeClass('boton-siguiente-listo');
                        $("#btnSiguiente").attr('disabled', true);
                    }
                }
            }*/

            function validarBotonAutorizacion(elem) {
                if ($("#btnAutorizacion").hasClass("active")) {
                    $("#btnAutorizacion").removeClass('active');
                    $("#div_terminos_y_condiciones_icono_pendiente").show();
                    $("#div_terminos_y_condiciones_icono_completo").hide();
                }
                else {
                    $("#btnAutorizacion").addClass('active');
                    $("#div_terminos_y_condiciones_icono_pendiente").hide();
                    $("#div_terminos_y_condiciones_icono_completo").show();
                }
                //habilitarSiguiente();
            }

            function validarCedula() {
                if (document.getElementById("adjuntar_cedula").files.length) {
                    if (document.getElementById("adjuntar_cedula").files[0].size > 26214400) {
                        alert("El archivo no puede superar los 25MB");
                        this.value = "";
                        return;
                    }

                    $("#adjuntar_cedula_label").addClass('boton-adjuntar-cedula-activo');
                    $("#adjuntar_cedula_check").css("visibility", "visible");
                    $("#adjuntar_cedula_camara").css("visibility", "hidden");
                    $("#adjuntar_cedula_icono_adjuntar").css("visibility", "hidden");
                    $("#adjuntar_cedula_check").removeClass("oculto");
                    $("#adjuntar_cedula_camara").addClass("oculto");
                    $("#adjuntar_cedula_icono_adjuntar").addClass("oculto");
                } else {
                    $("#adjuntar_cedula_label").removeClass('boton-adjuntar-cedula-activo');
                    $("#adjuntar_cedula_check").css("visibility", "hidden");
                    $("#adjuntar_cedula_camara").css("visibility", "visible");
                    $("#adjuntar_cedula_icono_adjuntar").css("visibility", "visible");
                    $("#adjuntar_cedula_check").addClass("oculto");
                    $("#adjuntar_cedula_camara").removeClass("oculto");
                    $("#adjuntar_cedula_icono_adjuntar").removeClass("oculto");
                }
                //habilitarSiguiente();
            }

            function validarEstadosFinancieros() {
				if (document.getElementById("adjuntar_estados_financieros").files.length) {
					for (i = 0; i < document.getElementById("adjuntar_estados_financieros").files.length; i++)
					{
						if (document.getElementById("adjuntar_estados_financieros").files[i].size > 26214400) {
						   alert("El archivo no puede superar los 25MB");
						   this.value = "";
						   return;
						}
					}

					$("#adjuntar_estados_financieros_label").addClass('boton-adjuntar-cedula-activo');
					$("#adjuntar_estados_financieros_check").css("visibility", "visible");
					$("#adjuntar_estados_financieros_camara").css("visibility", "hidden");
					$("#adjuntar_estados_financieros_icono_adjuntar").css("visibility", "hidden");
					$("#adjuntar_estados_financieros_check").removeClass("oculto");
					$("#adjuntar_estados_financieros_camara").addClass("oculto");
					$("#adjuntar_estados_financieros_icono_adjuntar").addClass("oculto");
				} else {
					$("#adjuntar_estados_financieros_label").removeClass('boton-adjuntar-cedula-activo');
					$("#adjuntar_estados_financieros_check").css("visibility", "hidden");
					$("#adjuntar_estados_financieros_camara").css("visibility", "visible");
					$("#adjuntar_estados_financieros_icono_adjuntar").css("visibility", "visible");
					$("#adjuntar_estados_financieros_check").addClass("oculto");
					$("#adjuntar_estados_financieros_camara").removeClass("oculto");
					$("#adjuntar_estados_financieros_icono_adjuntar").removeClass("oculto");
				}
				//habilitarSiguiente();
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
                    $("#div_arriendo_vivienda *").attr("required", true);
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
                //boton.addClass("boton-siguiente-presionado");
                $("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-presionado.svg')");
                $("#btnSiguiente").css("background-image-crossorigin", "anonymous");
                setTimeout(function() {
                    //boton.removeClass("boton-siguiente-presionado");
                    $("#btnSiguiente").css("background-image", "url('/credito/Resources/img/boton-siguiente-listo.svg')");
                    $("#btnSiguiente").css("background-image-crossorigin", "anonymous");
                }, 200);
            }

            let div_vehiculos_inicial = <?php if (isset($_SESSION['vehiculos'])) { echo $_SESSION['vehiculos']; } else { echo "''"; } ?>;
            for (i = 0; i < div_vehiculos_inicial.length; i++) {
                crearFilaInicialVehiculo(div_vehiculos_inicial[i].id, div_vehiculos_inicial[i].placa, div_vehiculos_inicial[i].valor_comercial, div_vehiculos_inicial[i].prenda);
                if (parseInt(div_vehiculos_inicial[i].id) >= cant_div_vehiculos) {
                    cant_div_vehiculos = parseInt(div_vehiculos_inicial[i].id) + 1;
                }
            }

            let div_inmuebles_inicial = <?php if (isset($_SESSION['inmuebles'])) { echo $_SESSION['inmuebles']; } else { echo "''"; } ?>;
            for (i = 0; i < div_inmuebles_inicial.length; i++) {
                crearFilaInicialInmueble(div_inmuebles_inicial[i].id, div_inmuebles_inicial[i].tipo_inmueble, div_inmuebles_inicial[i].valor_comercial, div_inmuebles_inicial[i].hipoteca, div_inmuebles_inicial[i].porcentaje_propiedad);
                if (parseInt(div_inmuebles_inicial[i].id) >= cant_div_inmuebles) {
                    cant_div_inmuebles = parseInt(div_inmuebles_inicial[i].id) + 1;
                }
            }

            let div_empleados_inicial = <?php if (isset($_SESSION['empleados'])) { echo $_SESSION['empleados']; } else { echo "''"; } ?>;
            for (i = 0; i < div_empleados_inicial.length; i++) {
                crearFilaInicialEmpleado(div_empleados_inicial[i].id, div_empleados_inicial[i].empresa, div_empleados_inicial[i].sector, div_empleados_inicial[i].antiguedad_empleado, div_empleados_inicial[i].tipo_contrato, div_empleados_inicial[i].duracion, div_empleados_inicial[i].duracion_cantidad, div_empleados_inicial[i].fin_contrato);
                if (parseInt(div_empleados_inicial[i].id) >= cant_div_empleados) {
                    cant_div_empleados = parseInt(div_empleados_inicial[i].id) + 1;
                }
            }

            let div_independientes_inicial = <?php if (isset($_SESSION['independientes'])) { echo $_SESSION['independientes']; } else { echo "''"; } ?>;
            for (i = 0; i < div_independientes_inicial.length; i++) {
                crearFilaInicialIndependiente(div_independientes_inicial[i].id, div_independientes_inicial[i].empresa, div_independientes_inicial[i].sector, div_independientes_inicial[i].antiguedad_independiente, div_independientes_inicial[i].ocupacion);
                if (parseInt(div_independientes_inicial[i].id) >= cant_div_independientes) {
                    cant_div_independientes = parseInt(div_independientes_inicial[i].id) + 1;
                }
            }

            let div_codeudores_inicial = <?php if (isset($_SESSION['codeudores'])) { echo $_SESSION['codeudores']; } else { echo "''"; } ?>;
            if (div_codeudores_inicial.length == 0) {
                crearFilaCodeudor();
            }
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
                    '	<button id="btnEliminarVehiculos' + id + '" name="btnEliminarVehiculos' + id + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_vehiculos_' + id + '\')" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Vehículo</b></label>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 120px;">' +
                    '	<label for="placa_vehiculo">Placa</label>' +
                    '	<input type="text" class="form-control" id="placa_vehiculo_' + id + '" name="placa_vehiculo_' + id + '" placeholder="Escribe..." maxlength="8" value="' + placa + '" required >' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 160px !important;">' +
                    '	<label for="valor_comercial_vehiculo">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_vehiculo_' + id + '" name="valor_comercial_vehiculo_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="prenda_vehiculo">Pignoración</label>' +
                    '	<select class="form-control" id="prenda_vehiculo_' + id + '" name="prenda_vehiculo_' + id + '" onchange="validarPrendaVehiculo(' + id + ')" >' +
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

                let porcentaje_propiedad_10 = "";
                let porcentaje_propiedad_25 = "";
                let porcentaje_propiedad_33 = "";
                let porcentaje_propiedad_50 = "";
                let porcentaje_propiedad_75 = "";
                let porcentaje_propiedad_100 = "";
                if (porcentaje_propiedad == "10") {
                    porcentaje_propiedad_10 = " selected ";
                }
                else if (porcentaje_propiedad == "25") {
                    porcentaje_propiedad_25 = " selected ";
                }
                else if (porcentaje_propiedad == "33") {
                    porcentaje_propiedad_33 = " selected ";
                }
                else if (porcentaje_propiedad == "50") {
                    porcentaje_propiedad_50 = " selected ";
                }
                else if (porcentaje_propiedad == "75") {
                    porcentaje_propiedad_75 = " selected ";
                }
                else if (porcentaje_propiedad == "100") {
                    porcentaje_propiedad_100 = " selected ";
                }

                let div_inmuebles = '<div id="div_inmuebles_' + id + '" name="div_inmuebles_' + id + '" onmouseenter="$(\'#btnEliminarInmuebles' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarInmuebles' + id + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="row">' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarInmuebles' + id + '" name="btnEliminarInmuebles' + id + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_inmuebles_' + id + '\')" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Propiedad</b></label>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 170px;">' +
                    '	<label for="tipo_inmueble">Tipo</label>' +
                    '	<select class="form-control" id="tipo_inmueble_' + id + '" name="tipo_inmueble_' + id + '" required >' +
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
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_inmueble_' + id + '" name="valor_comercial_inmueble_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 300px !important;">' +
                    '	<label for="porcentaje_propiedad_inmueble">Porcentaje de propiedad</label>' +
                    '	<select class="form-control" id="porcentaje_propiedad_inmueble_' + id + '" name="porcentaje_propiedad_inmueble_' + id + '" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="10" ' + porcentaje_propiedad_10 + '>10%</option>' +
                    '  		<option value="25" ' + porcentaje_propiedad_25 + '>25%</option>' +
                    '  		<option value="33" ' + porcentaje_propiedad_33 + '>33%</option>' +
                    '  		<option value="50" ' + porcentaje_propiedad_50 + '>50%</option>' +
                    '  		<option value="75" ' + porcentaje_propiedad_75 + '>75%</option>' +
                    '  		<option value="100" ' + porcentaje_propiedad_100 + '>100%</option>' +
                    '	</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="deudor-control deudor-div-vacio" style="width: 200px !important;">' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="hipoteca_inmueble">Hipoteca</label>' +
                    '	<select class="form-control" id="hipoteca_inmueble_' + id + '" name="hipoteca_inmueble_' + id + '" >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="Si" ' + hipoteca_si + '>Sí</option>' +
                    '  		<option value="No" ' + hipoteca_no + '>No</option>' +
                    '	</select>' +
                    '</div>' +
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
                    '	<button id="btnEliminarEmpleados' + id + '" name="btnEliminarEmpleados' + id + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_empleados_' + id + '\'); validarDivFuentesIngresoPersonaNatural();" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Empleado</b></label>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 210px">' +
                    '	<label for="empresa_empleado">Empresa</label>' +
                    '	<input type="text" class="form-control" id="empresa_empleado_' + id + '" name="empresa_empleado_' + id + '" placeholder="Escribe..." value="' + empresa + '" required >' +
                    '</div>' +
                    '<div class="deudor-control">' +
                    '	<label for="sector_empleado">Cargo</label>' +
                    '	<input type="text" class="form-control" id="sector_empleado_' + id + '" name="sector_empleado_' + id + '" placeholder="Tu labor" value="' + sector + '" required >' +
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
                    '	<select class="form-control" id="tipo_contrato_empleado_' + id + '" name="tipo_contrato_empleado_' + id + '" onchange="validarTipoContrato(' + id + ')" required >' +
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
                    '	<input type="number" class="form-control" id="duracion_cantidad_empleado_' + id + '" name="duracion_cantidad_empleado_' + id + '" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Meses..." value="' + duracion_cantidad + '" >' +
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
                    '	<input type="date" class="form-control" id="fin_contrato_empleado_' + id + '" name="fin_contrato_empleado_' + id + '" placeholder="dd-mm-yyyy" value="' + fin_contrato + '" >' +
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
                    '	<button id="btnEliminarIndependientes' + id + '" name="btnEliminarIndependientes' + id + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_independientes_' + id + '\'); validarDivFuentesIngresoPersonaNatural();" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Independiente</b></label>' +
                    '</div>' +
                    '<div class="deudor-control" style="display: flex; flex-direction: column">' +
                    '	<label for="empresa_independiente">Actividad económica</label>' +
                    '    <select class="form-control js-example-basic-single" id="empresa_independiente_' + id + '" name="empresa_independiente_' + id + '" required >' +
                    '    <option selected>-Escoge-</option>' +
                    <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                    '        <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>"><?= $listado_actividades_economicas[$i]['nombre']; ?></option>' +
                    <?php endfor; ?>
                    '    </select>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 225px">' +
                    '	<label for="ocupacion_independiente">Cargo</label>' +
                    '	<input type="text" class="form-control" id="ocupacion_independiente_' + id + '" name="ocupacion_independiente_' + id + '" placeholder="Tu labor" value="' + ocupacion + '" required >' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-label-control-dependiente" style="width: 180px" >' +
                    '	<label >Antigüedad</label>' +
                    '</div>' +
                    '<div class="deudor-control" >' +
                    '	<select class="form-control" id="antiguedad_independiente_' + id + '" name="antiguedad_independiente_' + id + '" required >' +
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
				let div_codeudor = '<div id="div_codeudor_' + id + '" name="div_codeudor_' + id + '" onmouseenter="$(\'#btnEliminarCodeudores' + id + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarCodeudores' + id + '\').css(\'visibility\', \'hidden\')" >' +
                            '<div class="row" >' +
                            '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
							'	<button id="btnEliminarCodeudores' + id + '" name="btnEliminarCodeudores' + id + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_codeudor_' + id + '\'); validarDivCodeudor();" >X</button>' +
							'</div>' +
							'<div class="deudor-control" >' +
							'<label for="nombre_codeudor_deudor_' + id + '">Nombre(s) y apellido(s) persona o Nombre empresa</label>' +
							'	<input type="text" class="form-control" id="nombre_codeudor_deudor_' + id + '" name="nombre_codeudor_deudor_' + id + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + nombres + '" required >' +
							'  </div>' +
							'  <div class="deudor-control deudor-control__celular_codeudor">' +
							'	<label for="celular_codeudor_deudor_' + id + '">Celular de contacto</label>' +
							'	<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_codeudor_deudor_' + id + '" name="celular_codeudor_deudor_' + id + '" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + celular + '" required >' +
							'  </div>' +
                            '  </div>' +
                            '<div class="row" >' +
                            '  <div style="padding: 0 35px"></div>' +
							'  <div class="deudor-control">' +
							'	<label for="correo_codeudor_deudor_' + id + '">Correo electrónico</label>' +
							'	<input type="email" class="form-control" id="correo_codeudor_deudor_' + id + '" name="correo_codeudor_deudor_' + id + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="' + correo + '" required >' +
							'  </div>' +
							'</div>' +
							'</div>' +
							'</div>';
				$('#div_caja_codeudor_elementos').append(div_codeudor);
			}

            function crearFilaVehiculo() {
                let div_vehiculos = '<div class="row" id="div_vehiculos_' + cant_div_vehiculos + '" name="div_vehiculos_' + cant_div_vehiculos + '" onmouseenter="$(\'#btnEliminarVehiculos' + cant_div_vehiculos + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarVehiculos' + cant_div_vehiculos + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarVehiculos' + cant_div_vehiculos + '" name="btnEliminarVehiculos' + cant_div_vehiculos + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_vehiculos_' + cant_div_vehiculos + '\')" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Vehículo</b></label>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 120px;">' +
                    '	<label for="placa_vehiculo">Placa</label>' +
                    '	<input type="text" class="form-control" id="placa_vehiculo_' + cant_div_vehiculos + '" name="placa_vehiculo_' + cant_div_vehiculos + '" placeholder="Escribe..." maxlength="8" value="" required >' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 160px !important;">' +
                    '	<label for="valor_comercial_vehiculo">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_vehiculo_' + cant_div_vehiculos + '" name="valor_comercial_vehiculo_' + cant_div_vehiculos + '" placeholder="Cifra..." value="" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="prenda_vehiculo">Pignoración</label>' +
                    '	<select class="form-control" id="prenda_vehiculo_' + cant_div_vehiculos + '" name="prenda_vehiculo_' + cant_div_vehiculos + '" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="Si">Sí</option>' +
                    '  		<option value="No">No</option>' +
                    '	</select>' +
                    '</div>' +
                    '</div>';

                $('#div_activos').append(div_vehiculos);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarVehiculos' + cant_div_vehiculos).css("visibility", "hidden");
                }

                $("#valor_comercial_vehiculo_" + cant_div_vehiculos).on("input", function() {
                    formatCurrency($(this));
                });

                $("#placa_vehiculo_" + cant_div_vehiculos).focus();

                cant_div_vehiculos++;
            }

            function crearFilaInmueble() {
                let div_inmuebles = '<div id="div_inmuebles_' + cant_div_inmuebles + '" name="div_inmuebles_' + cant_div_inmuebles + '" onmouseenter="$(\'#btnEliminarInmuebles' + cant_div_inmuebles + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarInmuebles' + cant_div_inmuebles + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="row">' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarInmuebles' + cant_div_inmuebles + '" name="btnEliminarInmuebles' + cant_div_inmuebles + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_inmuebles_' + cant_div_inmuebles + '\')" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Propiedad</b></label>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 170px;">' +
                    '	<label for="tipo_inmueble">Tipo</label>' +
                    '	<select class="form-control" id="tipo_inmueble_' + cant_div_inmuebles + '" name="tipo_inmueble_' + cant_div_inmuebles + '" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="apartamento">Apartamento</option>' +
                    '  		<option value="casa">Casa</option>' +
                    '  		<option value="local">Local</option>' +
                    '  		<option value="oficina">Oficina</option>' +
                    '  		<option value="otro">Otro</option>' +
                    '  		<option value="lote">Lote</option>' +
                    '	</select>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 160px !important;">' +
                    '	<label for="valor_comercial_inmueble">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_inmueble_' + cant_div_inmuebles + '" name="valor_comercial_inmueble_' + cant_div_inmuebles + '" placeholder="Cifra..." value="" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 300px !important;">' +
                    '	<label for="porcentaje_propiedad_inmueble">Porcentaje de propiedad</label>' +
                    '	<select class="form-control" id="porcentaje_propiedad_inmueble_' + cant_div_inmuebles + '" name="porcentaje_propiedad_inmueble_' + cant_div_inmuebles + '" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="10">10%</option>' +
                    '  		<option value="25">25%</option>' +
                    '  		<option value="33">33%</option>' +
                    '  		<option value="50">50%</option>' +
                    '  		<option value="75">75%</option>' +
                    '  		<option value="100">100%</option>' +
                    '	</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="deudor-control deudor-div-vacio" style="width: 200px !important;">' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="hipoteca_inmueble">Hipoteca</label>' +
                    '	<select class="form-control" id="hipoteca_inmueble_' + cant_div_inmuebles + '" name="hipoteca_inmueble_' + cant_div_inmuebles + '" >' +
                    '		<option value="" >-Escoge-</option>' +
                    '  		<option value="Si">Sí</option>' +
                    '  		<option value="No">No</option>' +
                    '	</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#div_activos').append(div_inmuebles);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarInmuebles' + cant_div_inmuebles).css("visibility", "hidden");
                }

                $("#valor_comercial_inmueble_" + cant_div_inmuebles).on("input", function() {
                    formatCurrency($(this));
                });

                $("#tipo_inmueble_" + cant_div_inmuebles).focus();

                cant_div_inmuebles++;
            }

            function crearFilaEmpleado() {
                let div_empleados = '<div class="row" id="div_empleados_' + cant_div_empleados + '" name="div_empleados_' + cant_div_empleados + '" onmouseenter="$(\'#btnEliminarEmpleados' + cant_div_empleados + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarEmpleados' + cant_div_empleados + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="row">' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarEmpleados' + cant_div_empleados + '" name="btnEliminarEmpleados' + cant_div_empleados + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_empleados_' + cant_div_empleados + '\'); validarDivFuentesIngresoPersonaNatural();" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Empleado</b></label>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 210px">' +
                    '	<label for="empresa_empleado">Empresa</label>' +
                    '	<input type="text" class="form-control" id="empresa_empleado_' + cant_div_empleados + '" name="empresa_empleado_' + cant_div_empleados + '" placeholder="Escribe..." value="" required >' +
                    '</div>' +
                    '<div class="deudor-control">' +
                    '	<label for="sector_empleado">Cargo</label>' +
                    '	<input type="text" class="form-control" id="sector_empleado_' + cant_div_empleados + '" name="sector_empleado_' + cant_div_empleados + '" placeholder="Tu labor" value="" required >' +
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
                    '	<select class="form-control" id="tipo_contrato_empleado_' + cant_div_empleados + '" name="tipo_contrato_empleado_' + cant_div_empleados + '" onchange="validarTipoContrato(' + cant_div_empleados + ')" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '		<option value="laboral_fijo">Laboral fijo</option>' +
                    '		<option value="laboral_indefinido">Laboral indefinido</option>' +
                    '		<option value="prestacion_servicios">Prestación de servicios</option>' +
                    '		<option value="obra_labor">Por obra o labor</option>' +
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
                    '	<input type="number" class="form-control" id="duracion_cantidad_empleado_' + cant_div_empleados + '" name="duracion_cantidad_empleado_' + cant_div_empleados + '" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Meses..." value="" >' +
                    '</div>' +
                    '</div>' +
                    '<div id="div_fin_contrato_' + cant_div_empleados + '" class="row" style="margin-bottom: 10px">' +
                    '<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-label-control-dependiente" style="width: 190px" >' +
                    '	<label>Fin del contrato</label>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control deudor-control-dependiente" >' +
                    '	<input type="date" class="form-control" id="fin_contrato_empleado_' + cant_div_empleados + '" name="fin_contrato_empleado_' + cant_div_empleados + '" placeholder="dd-mm-yyyy" value="<?php echo date('Y-m-d'); ?>" >' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#div_fuentes_ingreso').append(div_empleados);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarEmpleados' + cant_div_empleados).css("visibility", "hidden");
                }

                $("#empresa_empleado_" + cant_div_empleados).focus();

                cant_div_empleados++;
            }

            function crearFilaIndependiente() {
                let div_independientes = '<div class="row" id="div_independientes_' + cant_div_independientes + '" name="div_independientes_' + cant_div_independientes + '" onmouseenter="$(\'#btnEliminarIndependientes' + cant_div_independientes + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarIndependientes' + cant_div_independientes + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="row">' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarIndependientes' + cant_div_independientes + '" name="btnEliminarIndependientes' + cant_div_independientes + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_independientes_' + cant_div_independientes + '\'); validarDivFuentesIngresoPersonaNatural();" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__etiqueta-controles-dinamicos" >' +
                    '	<label><b>Independiente</b></label>' +
                    '</div>' +
                    '<div class="deudor-control" style="display: flex; flex-direction: column">' +
                    '	<label for="empresa_independiente">Actividad económica</label>' +
                    '    <select class="form-control js-example-basic-single" id="empresa_independiente_' + cant_div_independientes + '" name="empresa_independiente_' + cant_div_independientes + '" required >' +
                    '    <option selected>-Escoge-</option>' +
                    <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                    '        <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>"><?= $listado_actividades_economicas[$i]['nombre']; ?></option>' +
                    <?php endfor; ?>
                    '    </select>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 225px">' +
                    '	<label for="ocupacion_independiente">Cargo</label>' +
                    '	<input type="text" class="form-control" id="ocupacion_independiente_' + cant_div_independientes + '" name="ocupacion_independiente_' + cant_div_independientes + '" placeholder="Tu labor" value="" required >' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="deudor-control deudor-div-vacio" style="width: 220px !important;">' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-label-control-dependiente" style="width: 180px" >' +
                    '	<label >Antigüedad</label>' +
                    '</div>' +
                    '<div class="deudor-control" >' +
                    '	<select class="form-control" id="antiguedad_independiente_' + cant_div_independientes + '" name="antiguedad_independiente_' + cant_div_independientes + '" required >' +
                    '		<option value="" >-Escoge-</option>' +
                    '		<option value="menos_6_meses" >Menos de 6 meses</option>' +
                    '		<option value="mas_6_meses" >Más de 6 meses</option>' +
                    '		<option value="mas_1_anho" >Más de 1 año</option>' +
                    '		<option value="mas_2_anhos" >Más de 2 años</option>' +
                    '		<option value="mas_5_anhos" >Más de 5 años</option>' +
                    '		<option value="mas_10_anhos" >Más de 10 años</option>' +
                    '	</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('#div_fuentes_ingreso').append(div_independientes);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarIndependientes' + cant_div_independientes).css("visibility", "hidden");
                }

                $("#empresa_independiente_" + cant_div_independientes).focus();

                cant_div_independientes++;
                inicializarSelectPlugin();
            }

            function crearFilaCodeudor() {
                let div_codeudor = '<div id="div_codeudor_' + cant_div_codeudores + '" name="div_codeudor_' + cant_div_codeudores + '" onmouseenter="$(\'#btnEliminarCodeudores' + cant_div_codeudores + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarCodeudores' + cant_div_codeudores + '\').css(\'visibility\', \'hidden\')" >' +
                    '<div class="row">' +
                    '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
                    '	<button id="btnEliminarCodeudores' + cant_div_codeudores + '" name="btnEliminarCodeudores' + cant_div_codeudores + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_codeudor_' + cant_div_codeudores + '\'); validarDivCodeudor();" >X</button>' +
                    '</div>' +
                    '<div class="deudor-control" >' +
                    '   <label for="nombre_codeudor_deudor_' + cant_div_codeudores + '">Nombre(s) y apellido(s) persona o Nombre empresa</label>' +
                    '	<input type="text" class="form-control" id="nombre_codeudor_deudor_' + cant_div_codeudores + '" name="nombre_codeudor_deudor_' + cant_div_codeudores + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
                    '</div>' +
                    '<div class="deudor-control deudor-control__celular_codeudor" >' +
                    '	<label for="celular_codeudor_deudor_' + cant_div_codeudores + '">Celular de contacto</label>' +
                    '	<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_codeudor_deudor_' + cant_div_codeudores + '" name="celular_codeudor_deudor_' + cant_div_codeudores + '" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div style="padding: 0 35px">' +
                    '</div>' +
                    '<div class="deudor-control" >' +
                    '	<label for="correo_codeudor_deudor_' + cant_div_codeudores + '">Correo electrónico</label>' +
                    '	<input type="email" class="form-control" id="correo_codeudor_deudor_' + cant_div_codeudores + '" name="correo_codeudor_deudor_' + cant_div_codeudores + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $('#div_caja_codeudor_elementos').append(div_codeudor);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarCodeudores' + cant_div_codeudores).css("visibility", "hidden");
                }

                $("#nombre_codeudor_deudor_" + cant_div_codeudores).focus();

                cant_div_codeudores++;
            }

            function eliminarFilaDinamica(nombre_div) {
                $('#' + nombre_div).remove();
            }
        </script>

        <script>
            $("#mainForm").submit(function(e){
                e.preventDefault();
            });

            var interval = 5000;
            setTimeout(registrarSesionDeudor, interval);

            var interval2 = 10000;
            setTimeout(registrarDatosTemporales, interval2);

            function registrarSesionDeudor() {
                var htmlVehiculos = "";
                var htmlInmuebles = "";
                var htmlEmpleados = "";
                var htmlIndependientes = "";
                $("div[name*='div_vehiculos_']").each(function() {
                    htmlVehiculos += $(this).prop('outerHTML');
                });
                $("div[name*='div_inmuebles_']").each(function() {
                    htmlInmuebles += $(this).prop('outerHTML');
                });
                $("div[name*='div_empleados_']").each(function() {
                    htmlEmpleados += $(this).prop('outerHTML');
                });
                $("div[name*='div_independientes_']").each(function() {
                    htmlIndependientes += $(this).prop('outerHTML');
                });

                $.ajax({
                    type: 'POST',
                    url: 'guardar_sesion_deudor',
                    data:  $(mainForm).serialize(),
                    success: function (data) {
                    },
                    complete: function (data) {
                        if (data.responseText != "success") {
                            console.log("Error al registrar los datos");
                        }
                    }
                });

                setTimeout(registrarSesionDeudor, interval);
            }

            function registrarDatosTemporales() {
                var htmlVehiculos = "";
                var htmlInmuebles = "";
                var htmlEmpleados = "";
                var htmlIndependientes = "";
                $("div[name*='div_vehiculos_']").each(function() {
                    htmlVehiculos += $(this).prop('outerHTML');
                });
                $("div[name*='div_inmuebles_']").each(function() {
                    htmlInmuebles += $(this).prop('outerHTML');
                });
                $("div[name*='div_empleados_']").each(function() {
                    htmlEmpleados += $(this).prop('outerHTML');
                });
                $("div[name*='div_independientes_']").each(function() {
                    htmlIndependientes += $(this).prop('outerHTML');
                });

                $.ajax({
                    type: 'POST',
                    url: 'guardar_datos_temporales_deudor',
                    data:  $(mainForm).serialize(),
                    success: function (data) {
                    },
                    complete: function (data) {
                        if (data.responseText != "success") {
                            console.log("Error al registrar los datos");
                        }
                    }
                });

                setTimeout(registrarDatosTemporales, interval2);
            }

            function registrarDatosDeudor() {
                document.getElementById("mainForm").submit();
            }

            function enviarInformacionDeudor() {
                var validForm = document.getElementById("mainForm").checkValidity();
                if (validForm == true) {
                    var total_fuentes_ingreso = ($('div[name^="div_empleados"]:not([name^="div_empleados_icono"])' ).length + $('div[name^="div_independientes"]:not([name^="div_independientes_icono"])' ).length);
                    var total_codeudores = $('div[name^="div_codeudor_"]:not([name^="div_codeudor_icono"])' ).length;

                    if ($("#btnAutorizacion").hasClass("active")) {
                        if (total_codeudores > 0) {
                            if ($("#tipo_persona").val() == "natural") {
                                if (total_fuentes_ingreso > 0) {
                                    $('#modalCargando').modal('show');

                                    //const viewportmeta = document.querySelector('meta[name=viewport]');
                                    //viewportmeta.setAttribute('content', "initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0");

                                    registrarDatosDeudor();
                                }
                                else {
                                    mostrarModalValidacionFuentesIngresoYActivos();
                                }
                            }
                            else {
                                $('#modalCargando').modal('show');

                                //const viewportmeta = document.querySelector('meta[name=viewport]');
                                //viewportmeta.setAttribute('content', "initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0");

                                registrarDatosDeudor();
                            }
                        }
                        else {
                            mostrarModalValidacionCodeudores();
                        }
                    }
                    else {
                        mostrarModalValidacionTerminosYCondiciones();
                    }
                }
            }

            function mostrarModalCodeudor() {
                $('#modalSiguiente').modal('toggle');
            }

            function mostrarModalValidacionFuentesIngresoYActivos() {
                document.getElementById('div_fuentes_ingreso_persona_natural').scrollIntoView();
                $('#modalValidacionFuentesIngresoYActivos').modal('toggle');
            }

            function mostrarModalValidacionCodeudores() {
                document.getElementById('div_codeudor').scrollIntoView();
                $('#modalValidacionCodeudores').modal('toggle');
            }

            function mostrarModalValidacionTerminosYCondiciones() {
                $('#modalValidacionTerminosYCondiciones').modal('toggle');
            }

            function validarCodigoRedimir(element, length) {
                const number = element.value;
                var num = '' + number;
                while (num.length < length) {
                    num = '0' + num;
                }
                if (!isNaN(Number(num))) {
                    if (Number(num) <= 999999
                        && Number(num) % 1 == 0
                        && Number(num) > 0) {
                            element.value = num;
                    }
                    else {
                        element.value = 0;
                    }
                }
                else {
                    element.value = 0;
                }
            }

        </script>

        <script>
            function inicializarSelectPlugin() {
                $('.js-example-basic-single').select2();
            }
            $(document).ready(function() {
                inicializarSelectPlugin()
            });
        </script>
        </html>
        <?php
    }
}