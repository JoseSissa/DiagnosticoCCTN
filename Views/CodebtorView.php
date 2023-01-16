<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class CodebtorView
{
    public function __construct($uid, $id_deudor, $codeudor, $deudor, $listado_ciudades, $listado_actividades_economicas)
    {
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
                <h2 class="solo-movil">Bienvenido <b><?= $codeudor ?></b></h2>
                <p class="lead">Completa esta solicitud de crédito con tu información en los campos a continuación.<br>Tu información y datos personales estarán seguros.</p>
            </div>

            <div class="container">
                <form class="needs-validation" id="mainForm" name="mainForm" action="registrar_datos_codeudor" method="POST" role="form" enctype="multipart/form-data" autocomplete="off" >
                    <input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>" />

                    <div class="deudor-contenedor" >
                        <div class="deudor-encabezado deudor-encabezado-codeudor">
                            <div class="deudor-encabezado-codeudor-texto">
                                Vas a respaldar a: <b><span style="word-break: break-word;" id="nombre_deudor" name="nombre_deudor" ><?= $deudor ?></span></b>
                            </div>
                            <div id="deudor-encabezado-codeudor-imagen" class="deudor-encabezado-codeudor-imagen" style="margin-left: auto" >
                                <img src="Resources/img/watering.svg" height=80 style="border-radius: 25px !important;" />
                            </div>
                        </div>
                    </div>

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
                                <input type="hidden" id="tipo_persona_codeudor" name="tipo_persona_codeudor" value="<?php if (isset($_SESSION['tipo_persona_codeudor'])) { echo $_SESSION['tipo_persona_codeudor']; } ?>" />
                                <div>
                                    <button id="btnPersonaNatural" name="btnPersonaNatural" class="boton-formulario" type="button" onclick="validarBotonPersona(this)" >Persona natural</button>
                                </div>
                                <div>
                                    <button id="btnPersonaJuridica" name="btnPersonaJuridica" class="boton-formulario" type="button" onclick="validarBotonPersona(this)">Persona jurídica</button>
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
                                    <label for="nombres_codeudor">Nombres</label>
                                    <input type="text" class="form-control" id="nombres_codeudor" name="nombres_codeudor" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombres_codeudor'])) { echo $_SESSION['nombres_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="primer_apellido_codeudor">Primer apellido</label>
                                    <input type="text" class="form-control" id="primer_apellido_codeudor" name="primer_apellido_codeudor" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['primer_apellido_codeudor'])) { echo $_SESSION['primer_apellido_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="segundo_apellido_codeudor">Segundo apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido_codeudor" name="segundo_apellido_codeudor" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['segundo_apellido_codeudor'])) { echo $_SESSION['segundo_apellido_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 120px; padding-right: 10px;">
                                    <label for="tipo_identificacion_codeudor">Identificación</label>
                                    <select class="form-control" id="tipo_identificacion_codeudor" name="tipo_identificacion_codeudor" onchange="validarDivDatosPersonales()" required >
                                        <option value="cedula_ciudadania" <?php if (isset($_SESSION['tipo_identificacion_codeudor'])) { if ($_SESSION['tipo_identificacion_codeudor'] == "cedula_ciudadania") { echo " selected "; } } ?> >C.C.</option>
                                        <option value="cedula_extranjeria" <?php if (isset($_SESSION['tipo_identificacion_codeudor'])) { if ($_SESSION['tipo_identificacion_codeudor'] == "cedula_extranjeria") { echo " selected "; } } ?> >C.E.</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 330px; padding-right: 10px;">
                                    <label class="label-invisible" for="numero_identificacion_codeudor">-</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_identificacion_codeudor" name="numero_identificacion_codeudor" onchange="validarDivDatosPersonales()" placeholder="Número" value="<?php if (isset($_SESSION['numero_identificacion_codeudor'])) { echo $_SESSION['numero_identificacion_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;">
                                    <label for="fecha_nacimiento_codeudor">Fecha de nacimiento</label>
                                    <input type="text" onchange="validarDivDatosPersonales()" max="<?php echo date("Y-m-d", strtotime("-18 year", strtotime(date("Y-m-d")))); ?>" class="form-control" id="fecha_nacimiento_codeudor" name="fecha_nacimiento_codeudor" placeholder="dd-mm-yyyy" value="<?php if (isset($_SESSION['fecha_nacimiento_codeudor'])) { echo $_SESSION['fecha_nacimiento_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 200px; padding-right: 10px;">
                                    <label for="ciudad_codeudor">Ciudad</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_codeudor" name="ciudad_codeudor" onchange="validarDivDatosPersonales()" required >
                                        <option value="" >-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_codeudor'])) { if ($_SESSION['ciudad_codeudor'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
                                            echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 250px;">
                                    <label for="barrio_codeudor">Dirección</label>
                                    <input type="text" class="form-control" id="barrio_codeudor" name="barrio_codeudor" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['barrio_codeudor'])) { echo $_SESSION['barrio_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;" >
                                    <label for="telefono_codeudor">Teléfono</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="telefono_codeudor" name="telefono_codeudor" onchange="validarDivDatosPersonales()" maxlength="10" placeholder="Opcional" value="<?php if (isset($_SESSION['telefono_codeudor'])) { echo $_SESSION['telefono_codeudor']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 200px; padding-right: 10px;">
                                    <label for="celular_codeudor">Celular</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_codeudor" name="celular_codeudor" onchange="validarDivDatosPersonales()" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['celular_codeudor'])) { echo $_SESSION['celular_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control deudor-control__personas_a_cargo" style="width: 200px; padding-right: 10px;">
                                    <label for="personas_a_cargo_codeudor">Personas a cargo</label>
                                    <select class="form-control" id="personas_a_cargo_codeudor" name="personas_a_cargo_codeudor" onchange="validarDivDatosPersonales();" required>
                                        <option value="" >-Escoge-</option>
                                        <option value=0 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "0") { echo " selected "; } } ?> >0</option>
                                        <option value=1 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "1") { echo " selected "; } } ?> >1</option>
                                        <option value=2 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "2") { echo " selected "; } } ?> >2</option>
                                        <option value=3 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "3") { echo " selected "; } } ?> >3</option>
                                        <option value=4 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "4") { echo " selected "; } } ?> >4</option>
                                        <option value=5 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "5") { echo " selected "; } } ?> >5</option>
                                        <option value=6 <?php if (isset($_SESSION['personas_a_cargo_codeudor'])) { if ($_SESSION['personas_a_cargo_codeudor'] == "6") { echo " selected "; } } ?> >6</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="estado_civil_codeudor">Estado civil</label>
                                    <select class="form-control" id="estado_civil_codeudor" name="estado_civil_codeudor" onchange="validarDivDatosPersonales(); validarEstadoCivil();" required>
                                        <option value="" >-Escoge-</option>
                                        <option value="soltero" <?php if (isset($_SESSION['estado_civil_codeudor'])) { if ($_SESSION['estado_civil_codeudor'] == "soltero") { echo " selected "; } } ?> >Soltero/a</option>
                                        <option value="casado" <?php if (isset($_SESSION['estado_civil_codeudor'])) { if ($_SESSION['estado_civil_codeudor'] == "casado") { echo " selected "; } } ?> >Casado/a</option>
                                        <option value="separado" <?php if (isset($_SESSION['estado_civil_codeudor'])) { if ($_SESSION['estado_civil_codeudor'] == "separado") { echo " selected "; } } ?> >Separado/a</option>
                                        <option value="viudo" <?php if (isset($_SESSION['estado_civil_codeudor'])) { if ($_SESSION['estado_civil_codeudor'] == "viudo") { echo " selected "; } } ?> >Viudo/a</option>
                                        <option value="union_libre" <?php if (isset($_SESSION['estado_civil_codeudor'])) { if ($_SESSION['estado_civil_codeudor'] == "union_libre") { echo " selected "; } } ?> >Unión libre</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="tipo_vivienda_codeudor">Vivienda</label>
                                    <select class="form-control" id="tipo_vivienda_codeudor" name="tipo_vivienda_codeudor" onchange="validarDivDatosPersonales(); validarTipoVivienda()" required >
                                        <option value="" >-Escoge-</option>
                                        <option value="arrendada" <?php if (isset($_SESSION['tipo_vivienda_codeudor'])) { if ($_SESSION['tipo_vivienda_codeudor'] == "arrendada") { echo " selected "; } } ?> >Arrendada</option>
                                        <option value="propia" <?php if (isset($_SESSION['tipo_vivienda_codeudor'])) { if ($_SESSION['tipo_vivienda_codeudor'] == "propia") { echo " selected "; } } ?> >Propia</option>
                                        <option value="familiar" <?php if (isset($_SESSION['tipo_vivienda_codeudor'])) { if ($_SESSION['tipo_vivienda_codeudor'] == "familiar") { echo " selected "; } } ?> >Familiar</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label for="estrato_codeudor" >Estrato</label>
                                    <select class="form-control" id="estrato_codeudor" name="estrato_codeudor" onchange="validarDivDatosPersonales()" required>
                                        <option value="" >-Escoge-</option>
                                        <option value="1" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "1") { echo " selected "; } } ?> >1</option>
                                        <option value="2" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "2") { echo " selected "; } } ?> >2</option>
                                        <option value="3" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "3") { echo " selected "; } } ?> >3</option>
                                        <option value="4" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "4") { echo " selected "; } } ?> >4</option>
                                        <option value="5" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "5") { echo " selected "; } } ?> >5</option>
                                        <option value="6" <?php if (isset($_SESSION['estrato_codeudor'])) { if ($_SESSION['estrato_codeudor'] == "6") { echo " selected "; } } ?> >6</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 400px;">
                                    <label for="correo_codeudor">Correo electrónico</label>
                                    <input type="email" class="form-control" id="correo_codeudor" name="correo_codeudor" onchange="validarDivDatosPersonales()" placeholder="nombre@correo.com" value="<?php if (isset($_SESSION['correo_codeudor'])) { echo $_SESSION['correo_codeudor']; } ?>" required >
                                </div>
                            </div>
                            <div class="row" id="div_datos_conyuge" name="div_datos_conyuge">
                                <div class="deudor-control" style="width: 280px">
                                    <label for="nombre_apellido_conyuge_codeudor">Nombre / Apellido Cónyuge</label>
                                    <input type="text" class="form-control" id="nombre_apellido_conyuge_codeudor" name="nombre_apellido_conyuge_codeudor" onchange="validarDivDatosPersonales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombre_apellido_conyuge_codeudor'])) { echo $_SESSION['nombre_apellido_conyuge_codeudor']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 170px">
                                    <label for="celular_conyuge_codeudor">Celular cónyuge</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_conyuge_codeudor" name="celular_conyuge_codeudor" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivDatosPersonales()" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['celular_conyuge_codeudor'])) { echo $_SESSION['celular_conyuge_codeudor']; } ?>" >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 400px">
                                    <label for="ciudad_conyuge_codeudor">Ciudad residencia</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_conyuge_codeudor" name="ciudad_conyuge_codeudor" onchange="validarDivDatosPersonales()" required >
                                        <option value="" >-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_conyuge_codeudor'])) { if ($_SESSION['ciudad_conyuge_codeudor'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
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
                                    <label for="nombre_empresa_codeudor">Nombre de la empresa</label>
                                    <input type="text" class="form-control" id="nombre_empresa_codeudor" name="nombre_empresa_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombre_empresa_codeudor'])) { echo $_SESSION['nombre_empresa_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="nit_codeudor">NIT</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.-]*" class="form-control" id="nit_codeudor" name="nit_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nit_codeudor'])) { echo $_SESSION['nit_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 300px;">
                                    <label for="ciudad_empresa_codeudor">Ciudad</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_empresa_codeudor" name="ciudad_empresa_codeudor" onchange="validarDivDatosEmpresariales()" required >
                                        <option value="" >-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_empresa_codeudor'])) { if ($_SESSION['ciudad_empresa_codeudor'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
                                            echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 330px;" >
                                    <label for="actividad_economica_empresa_codeudor">Actividad económica principal</label>
                                    <select class="form-control js-example-basic-single" id="actividad_economica_empresa_codeudor" name="actividad_economica_empresa_codeudor" onchange="validarDivDatosEmpresariales()" required >
                                        <option selected>-Escoge-</option>
                                        <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                                            <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>" <?php if (isset($_SESSION['actividad_economica_empresa_codeudor'])): ?><?php if ($_SESSION['actividad_economica_empresa_codeudor'] == $listado_actividades_economicas[$i]['codigo']): ?> selected <?php endif; ?><?php endif; ?> ><?= mb_convert_case($listado_actividades_economicas[$i]['nombre'], MB_CASE_TITLE, "UTF-8"); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 250px;">
                                    <label for="antiguedad_empresa_codeudor">Antigüedad empresa</label>
                                    <input type="number" class="form-control" id="antiguedad_empresa_codeudor" name="antiguedad_empresa_codeudor" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="validarDivDatosEmpresariales()" placeholder="Años..." value="<?php if (isset($_SESSION['antiguedad_empresa_codeudor'])) { echo $_SESSION['antiguedad_empresa_codeudor']; } ?>" required >
                                </div>
                            </div>
                            <div class="row">
                                <span style="font-weight: bold; padding-left: 15px; padding-top: 15px" >REPRESENTANTE LEGAL</span>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width: 450px;" >
                                    <label for="nombres_representante_legal_codeudor">Nombres</label>
                                    <input type="text" class="form-control" id="nombres_representante_legal_codeudor" name="nombres_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['nombres_representante_legal_codeudor'])) { echo $_SESSION['nombres_representante_legal_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="primer_apellido_representante_legal_codeudor">Primer apellido</label>
                                    <input type="text" class="form-control" id="primer_apellido_representante_legal_codeudor" name="primer_apellido_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['primer_apellido_representante_legal_codeudor'])) { echo $_SESSION['primer_apellido_representante_legal_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 200px;" >
                                    <label for="segundo_apellido_representante_legal_codeudor">Segundo apellido</label>
                                    <input type="text" class="form-control" id="segundo_apellido_representante_legal_codeudor" name="segundo_apellido_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['segundo_apellido_representante_legal_codeudor'])) { echo $_SESSION['segundo_apellido_representante_legal_codeudor']; } ?>" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width: 120px; padding-right: 10px;">
                                    <label for="tipo_identificacion_representante_legal_codeudor">Identificación</label>
                                    <select class="form-control" id="tipo_identificacion_representante_legal_codeudor" name="tipo_identificacion_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" required >
                                        <option value="cedula_ciudadania" <?php if (isset($_SESSION['tipo_identificacion_representante_legal_codeudor'])) { if ($_SESSION['tipo_identificacion_representante_legal_codeudor'] == "cedula_ciudadania") { echo " selected "; } } ?> >C.C.</option>
                                        <option value="cedula_extranjeria" <?php if (isset($_SESSION['tipo_identificacion_representante_legal_codeudor'])) { if ($_SESSION['tipo_identificacion_representante_legal_codeudor'] == "cedula_extranjeria") { echo " selected "; } } ?> >C.E.</option>
                                    </select>
                                </div>
                                <div class="deudor-control" style="width: 150px; padding-right: 10px;">
                                    <label class="label-invisible" for="numero_identificacion_representante_legal_codeudor">-</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="numero_identificacion_representante_legal_codeudor" name="numero_identificacion_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Número" value="<?php if (isset($_SESSION['numero_identificacion_representante_legal_codeudor'])) { echo $_SESSION['numero_identificacion_representante_legal_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="width: 330px;">
                                    <label for="correo_representante_legal_codeudor">Correo electrónico</label>
                                    <input type="email" class="form-control" id="correo_representante_legal_codeudor" name="correo_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="nombre@correo.com" value="<?php if (isset($_SESSION['correo_representante_legal_codeudor'])) { echo $_SESSION['correo_representante_legal_codeudor']; } ?>" required >
                                </div>
                                <div class="deudor-control" style="display: flex; flex-direction: column; width: 250px; padding-right: 10px;">
                                    <label for="ciudad_representante_legal_codeudor">Ciudad de residencia</label>
                                    <select class="form-control js-example-basic-single" id="ciudad_representante_legal_codeudor" name="ciudad_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" required >
                                        <option value="" >-Escoge-</option>
                                        <?php
                                        for ($i = 0; $i < sizeof($listado_ciudades); $i++) {
                                            echo '<option value="' . $listado_ciudades[$i]['codigo'] . '" ';
                                            if (isset($_SESSION['ciudad_representante_legal_codeudor'])) { if ($_SESSION['ciudad_representante_legal_codeudor'] == $listado_ciudades[$i]['codigo']) { echo " selected "; } }
                                            echo ' >' . mb_convert_case($listado_ciudades[$i]['ciudad'], MB_CASE_TITLE, "UTF-8") . ' (' . mb_convert_case($listado_ciudades[$i]['departamento'], MB_CASE_TITLE, "UTF-8") . ')</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width: 450px; padding-right: 10px;" >
                                    <label for="direccion_representante_legal_codeudor">Dirección</label>
                                    <input type="text" class="form-control" id="direccion_representante_legal_codeudor" name="direccion_representante_legal_codeudor" onchange="validarDivDatosEmpresariales()" placeholder="Escribe..." value="<?php if (isset($_SESSION['direccion_representante_legal_codeudor'])) { echo $_SESSION['direccion_representante_legal_codeudor']; } ?>" >
                                </div>
                                <div class="deudor-control" style="width: 190px; padding-right: 10px;">
                                    <label for="celular_representante_legal_codeudor">Celular</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_representante_legal_codeudor" name="celular_representante_legal_codeudor" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivDatosEmpresariales()" placeholder="XXX XXX XXXX" value="<?php if (isset($_SESSION['celular_representante_legal_codeudor'])) { echo $_SESSION['celular_representante_legal_codeudor']; } ?>" required >
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
                        <div class="deudor-caja" id="div_fuentes_ingreso" name="div_fuentes_ingreso" >
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
                                    <label for="honorarios_codeudor">Ingreso principal</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="honorarios_codeudor" name="honorarios_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['honorarios_codeudor'])) { echo $_SESSION['honorarios_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__comisiones" style="width:200px">
                                    <label for="comisiones_codeudor">Comisiones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="comisiones_codeudor" name="comisiones_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Opcional..." value="<?php if (isset($_SESSION['comisiones_codeudor'])) { echo $_SESSION['comisiones_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__otros-ingresos" style="width:200px">
                                    <label for="otros_ingresos_codeudor">Otros ingresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="otros_ingresos_codeudor" name="otros_ingresos_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Opcional..." value="<?php if (isset($_SESSION['otros_ingresos_codeudor'])) { echo $_SESSION['otros_ingresos_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width: 230px; padding-right: 75px">
                                    <label><span style="color: white; ">-</span><br><b>Gastos por mes</b></label>
                                </div>
                                <div class="deudor-control deudor-control__gastos-generales" style="width:200px">
                                    <label for="gasto_personal_familiar_codeudor">Gastos generales</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="gasto_personal_familiar_codeudor" name="gasto_personal_familiar_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Alimentación, educación, ocio..." value="<?php if (isset($_SESSION['gasto_personal_familiar_codeudor'])) { echo $_SESSION['gasto_personal_familiar_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__arriendo-vivienda" id="div_arriendo_vivienda" name="div_arriendo_vivienda" style="width:200px">
                                    <label for="arriendo_vivienda_codeudor">Arriendo vivienda</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="arriendo_vivienda_codeudor" name="arriendo_vivienda_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cifra..." value="<?php if (isset($_SESSION['arriendo_vivienda_codeudor'])) { echo $_SESSION['arriendo_vivienda_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__obligaciones" style="width:200px">
                                    <label for="cuotas_creditos_codeudor">Obligaciones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="cuotas_creditos_codeudor" name="cuotas_creditos_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cuotas préstamos..." value="<?php if (isset($_SESSION['cuotas_creditos_codeudor'])) { echo $_SESSION['cuotas_creditos_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_conyuge_informacion_financiera" name="div_conyuge_informacion_financiera">
                                <div class="deudor-control" style="padding-right: 115px">
                                    <label><br><b>* Cónyuge</b></label>
                                </div>
                                <div class="deudor-control deudor-control__conyuge_ingresos_mensuales" style="width:200px">
                                    <label for="conyuge_ingresos_mensuales_codeudor">Ingresos mensuales</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_ingresos_mensuales_codeudor" name="conyuge_ingresos_mensuales_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['conyuge_ingresos_mensuales_codeudor'])) { echo $_SESSION['conyuge_ingresos_mensuales_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__conyuge_gastos_mensuales" style="width:200px">
                                    <label for="conyuge_gastos_mensuales_codeudor">Gastos mensuales</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_gastos_mensuales_codeudor" name="conyuge_gastos_mensuales_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cifra..." value="<?php if (isset($_SESSION['conyuge_gastos_mensuales_codeudor'])) { echo $_SESSION['conyuge_gastos_mensuales_codeudor']; } ?>" >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control deudor-control__conyuge_obligaciones" style="width:200px">
                                    <label for="conyuge_obligaciones_codeudor">Obligaciones</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="conyuge_obligaciones_codeudor" name="conyuge_obligaciones_codeudor" onchange="validarDivInformacionFinancieraPersonaNatural()" placeholder="Cuotas préstamos..." value="<?php if (isset($_SESSION['conyuge_obligaciones_codeudor'])) { echo $_SESSION['conyuge_obligaciones_codeudor']; } ?>" >
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
                                <span>Adjunta los estados financieros con notas aclaratorias (Balance General y Estado de Resultados) del año <?php echo (intval(date('Y')) - 1) ?> o del último periodo que tengas disponibles</span>
                            </div>
                            <div class="row d-flex justify-content-center" style="padding-top: 25px">
                                <label class="boton-adjuntar-cedula boton-adjuntar-estados-financieros" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg)" id="adjuntar_estados_financieros_label" name="adjuntar_estados_financieros_label" for="adjuntar_estados_financieros" >Adjuntar<img class="boton-adjuntar-cedula-camara" style="height: 70% !important" id="adjuntar_estados_financieros_camara" name="adjuntar_estados_financieros_camara" src="Resources/img/camera.svg" /><img class="boton-adjuntar-cedula-icono-adjuntar" style="height: 70% !important; " id="adjuntar_estados_financieros_icono_adjuntar" name="adjuntar_estados_financieros_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" /><img class="boton-adjuntar-cedula-check" style="padding-left: 10px" id="adjuntar_estados_financieros_check" name="adjuntar_estados_financieros_check" src="Resources/img/check-listo.svg" /></label>
                                <input id="adjuntar_estados_financieros" name="adjuntar_estados_financieros[]" type="file" accept="image/*, application/pdf" onclick="animacionBotonAdjuntarAlPresionar($('#adjuntar_estados_financieros_label'));" onchange="validarEstadosFinancieros(); if( $(this).is(':invalid') == false ){ $('*').unbind('invalid'); } " oninvalid="$('*').on('invalid', function(e) { return false }); $('#modalValidacionEstadosFinancieros').modal('show'); document.getElementById('div_informacion_financiera_persona_juridica').scrollIntoView(); " required multiple >
                            </div>
                        </div>
                        <div class="deudor-caja">
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_ingresos_codeudor">Ingresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_ingresos_codeudor" name="informacion_financiera_ingresos_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_ingresos_codeudor'])) { echo $_SESSION['informacion_financiera_ingresos_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_activos_codeudor">Activos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_activos_codeudor" name="informacion_financiera_activos_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_activos_codeudor'])) { echo $_SESSION['informacion_financiera_activos_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_por_cobrar_codeudor">Cuentas por cobrar</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_cobrar_codeudor" name="informacion_financiera_por_cobrar_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_por_cobrar_codeudor'])) { echo $_SESSION['informacion_financiera_por_cobrar_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_egresos_codeudor">Egresos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_egresos_codeudor" name="informacion_financiera_egresos_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_egresos_codeudor'])) { echo $_SESSION['informacion_financiera_egresos_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_pasivos_codeudor">Pasivos</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_pasivos_codeudor" name="informacion_financiera_pasivos_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_pasivos_codeudor'])) { echo $_SESSION['informacion_financiera_pasivos_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_por_pagar_codeudor">Cuentas por pagar</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_por_pagar_codeudor" name="informacion_financiera_por_pagar_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_por_pagar_codeudor'])) { echo $_SESSION['informacion_financiera_por_pagar_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_patrimonio_codeudor">Patrimonio</label>
                                    <div class="input-icon">
                                        <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="informacion_financiera_patrimonio_codeudor" name="informacion_financiera_patrimonio_codeudor" onchange="validarDivInformacionFinancieraPersonaJuridica()" placeholder="Digite una cifra..." value="<?php if (isset($_SESSION['informacion_financiera_patrimonio_codeudor'])) { echo $_SESSION['informacion_financiera_patrimonio_codeudor']; } ?>" required >
                                        <i>$</i>
                                    </div>
                                </div>
                                <div class="deudor-control" style="width:33% !important">
                                    <label for="informacion_financiera_fecha_codeudor">Fecha de la información</label>
                                    <div class="input-icon">
                                        <input type="date" onchange="validarDivInformacionFinancieraPersonaJuridica()" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="informacion_financiera_fecha_codeudor" name="informacion_financiera_fecha_codeudor" placeholder="dd-mm-yyyy" value="<?php if (isset($_SESSION['informacion_financiera_fecha_codeudor'])) { echo $_SESSION['informacion_financiera_fecha_codeudor']; } ?>" required >
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
                        <div class="deudor-caja" id="div_activos" name="div_activos" >
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
                                    Por medio del presente escrito autorizo a Vanka SAS o a quien represente sus derechos, para que adelante las consultas que sean necesarias en
                                    relación al comportamiento financiero en las bases o bancos de datos propias o de centrales de riesgo (Datacrédito, Cifin, entre otras y similares).
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

                    <div style="text-align: center; padding-top: 30px; padding-bottom: 200px;" id="div_botones" name="div_botones" >

                        <div style="display: flex; flex-direction: row; align-items: flex-start; justify-content: center; flex-wrap: wrap">
                            <div style="display: flex; flex-direction: column">
                                <label class="boton-adjuntar-cedula" style="background-image: url(Resources/img/boton-adjuntar-cedula.svg);" id="adjuntar_cedula_label" name="adjuntar_cedula_label" for="adjuntar_cedula" >
                                    <span id="texto_adjuntar_cedula" name="texto_adjuntar_cedula">Adjunta tu cédula</span>
                                    <span style="white-space:nowrap;">
									<img class="boton-adjuntar-cedula-camara" id="adjuntar_cedula_camara" name="adjuntar_cedula_camara" src="Resources/img/camera.svg" />
									<img class="boton-adjuntar-cedula-icono-adjuntar" id="adjuntar_cedula_icono_adjuntar" name="adjuntar_cedula_icono_adjuntar" src="Resources/img/icono-adjuntar.svg" />
								</span>
                                    <img class="boton-adjuntar-cedula-check" id="adjuntar_cedula_check" name="adjuntar_cedula_check" src="Resources/img/check-listo.svg" />
                                </label>
                                * Solo la cara frontal
                                <input id="adjuntar_cedula" name="adjuntar_cedula" type="file" onclick="animacionBotonAdjuntarAlPresionar($('#adjuntar_cedula_label'));" onchange="validarCedula(); if( $(this).is(':invalid') == false ){ $('*').unbind('invalid'); } " accept="image/*, application/pdf" oninvalid="$('*').on('invalid', function(e) { return false }); $('#modalValidacionCedula').modal('show'); setTimeout( function() { document.getElementById('div_botones').scrollIntoView(); }, 1); " required >

                                <label id="label_adjuntar_cedula_representante_legal" name="label_adjuntar_cedula_representante_legal">(Representante legal)</label>
                            </div>

                            <button id="btnSiguiente" name="btnSiguiente" class="boton-siguiente" type="submit" onclick="animacionBotonSiguienteAlPresionar($(this)); validarEstadoBotonSiguiente(); enviarInformacionCodeudor()" >Siguiente</button>
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

        <!-- Modal -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalSiguiente" tabindex="-1" role="dialog" aria-labelledby="modalTitulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content" style="padding: 20px; max-width: 600px !important;">
                    <div class="modal-header" style="border-bottom: 0">
                        <h3 class="modal-title" id="modalTitulo"><b>Registro exitoso</b></h3>
                        <div class="deudor-seccion-listo" id="div_persona_icono_pendiente" name="div_persona_icono_pendiente" >
                            <img src="Resources/img/flag.svg" />
                        </div>
                    </div>
                    <div class="modal-body">
                        <p>Tu información ha sido registrada con éxito. Te estaremos informando de los pasos a seguir en tu correo electrónico en un estimado de 2 a 3 días.</p>
                    </div>
                    <div class="modal-footer" style="border-top: 0; padding: 30 12">
                        <button style="border: 0; background-color: transparent; font-weight: bold; font-size: 20px;" type="button" onclick="window.location='https://www.vanka.com.co'" >salir <img src="Resources/img/flecha-siguiente.svg" /></button>
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
                            declaro bajo la gravedad de juramento: que los recursos y dinero que recibo de Vanka S.A.S., como consecuencia del Contrato de Mutuo suscrito con
                            esta entidad, no van a ser destinados para la financiación del terrorismo o cualquier otra conducta delictiva o ilícita, de acuerdo con las
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
                            procedimiento para su ejercicio; (6) la identificación, dirección física o electrónica y teléfono del Responsable del Tratamiento. Lo anterior en
                            base a las leyes 1712 de 2014 y 1377 de 2013.
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

        </body>

        <!-- Encabezados fijos y ajuste de controles en forma inválida  -->
        <script>
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
            }
        </script>

        <script>

            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {
                $("#deudor-encabezado-codeudor-imagen").remove();
                $("#nombre_deudor").html("<br>" + $("#nombre_deudor").text());
            }

            $(".deudor-contenedor").focusin(function() {
                $(this).addClass("deudor-contenedor-con-sombra");
            });
            $(".deudor-contenedor").focusout(function() {
                $(this).removeClass("deudor-contenedor-con-sombra");
            });

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

                $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-listo.svg')");

                $('#btnSiguiente').mouseenter(function(e) {
                    $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-hover.svg')");
                });
                $('#btnSiguiente').mouseleave(function(e) {
                    $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-listo.svg')");
                });

                if ($("#btnPersonaNatural").hasClass("active")) {
                    validarBotonPersona(document.getElementById("btnPersonaNatural"));
                }
                else if ($("#btnPersonaJuridica").hasClass("active")) {
                    validarBotonPersona(document.getElementById("btnPersonaJuridica"));
                }

                $("#honorarios_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#comisiones_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#otros_ingresos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#gasto_personal_familiar_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#arriendo_vivienda_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#cuotas_creditos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#conyuge_ingresos_mensuales_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#conyuge_gastos_mensuales_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#conyuge_obligaciones_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_ingresos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_activos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_por_cobrar_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_egresos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_pasivos_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_por_pagar_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#informacion_financiera_patrimonio_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("input[name^='valor_comercial_vehiculo_codeudor_']").on("input", function() {
                    formatCurrency($(this));
                });

                $("input[name^='valor_comercial_inmueble_codeudor_']").on("input", function() {
                    formatCurrency($(this));
                });

                $("#numero_contacto_empresa_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#celular_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#celular_conyuge_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#celular_representante_legal_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#telefono_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#celular_codeudor").on("input", function() {
                    formatNumber($(this));
                });

                $("#nit_codeudor").on("input", function() {
                    formatNumberWithSpecialChars($(this));
                });

                $("#numero_identificacion_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                $("#numero_identificacion_representante_legal_codeudor").on("input", function() {
                    formatCurrency($(this));
                });

                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $("button[name^='btnEliminarEmpleados']").css("visibility", "hidden");
                    $("button[name^='btnEliminarIndependientes']").css("visibility", "hidden");
                    $("button[name^='btnEliminarVehiculos']").css("visibility", "hidden");
                    $("button[name^='btnEliminarInmuebles']").css("visibility", "hidden");
                }

            });

            function validarEstadoBotonSiguiente() {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == true ) {
                    $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-presionado.svg')");
                    setTimeout(function(){
                        $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-listo.svg')");
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
            $("#div_terminos_y_condiciones_icono_pendiente").hide();
            $("#div_terminos_y_condiciones_icono_completo").hide();

            $("#div_datos_personales").hide();
            $("#div_datos_personales *").removeAttr("required");
            $("#fecha_nacimiento_codeudor").removeAttr("required");
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
            $("#div_autorizaciones").hide();
            $("#div_autorizaciones *").removeAttr("required");
            $("#div_botones").hide();
            $("#div_botones *").removeAttr("required");

            validarCedula();
            validarEstadosFinancieros();

            validarEstadoCivil();
            validarTipoVivienda();
            validacionInicialBotonPersona();

            function validarDivDatosPersonales() {
                if ($("#primer_apellido_codeudor").val().length > 0
                    && $("#segundo_apellido_codeudor").val().length > 0
                    && $("#nombres_codeudor").val().length > 0
                    && $("#tipo_identificacion_codeudor").val().length > 0
                    && $("#numero_identificacion_codeudor").val().length > 0
                    && $("#fecha_nacimiento_codeudor").val().length > 0
                    && $("#ciudad_codeudor").val().length > 0
                    && $("#barrio_codeudor").val().length > 0
                    && $("#celular_codeudor").val().length > 0
                    && $("#correo_codeudor").val().length > 0
                    && $("#estado_civil_codeudor").val().length > 0
                    && $("#tipo_vivienda_codeudor").val().length > 0
                    && $("#estrato_codeudor").val().length > 0
                    && $("#personas_a_cargo_codeudor").val().length > 0)
                {
                    if ($("#estado_civil_codeudor").val() == "casado" || $("#estado_civil_codeudor").val() == "union_libre") {
                        if ($("#nombre_apellido_conyuge_codeudor").val().length > 0
                            && $("#celular_conyuge_codeudor").val().length > 0
                            && $("#ciudad_conyuge_codeudor").val().length > 0) {

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
                if ($("#honorarios_codeudor").val().length > 0
                    && $("#gasto_personal_familiar_codeudor").val().length > 0)
                {
                    if ($("#estado_civil_codeudor").val() == "casado" || $("#estado_civil_codeudor").val() == "union_libre") {
                        if ($("#conyuge_ingresos_mensuales_codeudor").val().length > 0
                            && $("#conyuge_gastos_mensuales_codeudor").val().length > 0) {

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
                if ($("#informacion_financiera_ingresos_codeudor").val().length > 0
                    && $("#informacion_financiera_activos_codeudor").val().length > 0
                    && $("#informacion_financiera_por_cobrar_codeudor").val().length > 0
                    && $("#informacion_financiera_egresos_codeudor").val().length > 0
                    && $("#informacion_financiera_pasivos_codeudor").val().length > 0
                    && $("#informacion_financiera_por_pagar_codeudor").val().length > 0
                    && $("#informacion_financiera_patrimonio_codeudor").val().length > 0
                    && $("#informacion_financiera_fecha_codeudor").val().length > 0)
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
                if ($("#nombre_empresa_codeudor").val().length > 0
                    && $("#nit_codeudor").val().length > 0
                    && $("#direccion_empresa_codeudor").val().length > 0
                    && $("#ciudad_empresa_codeudor").val().length > 0
                    && $("#numero_contacto_empresa_codeudor").val().length > 0
                    && $("#actividad_economica_empresa_codeudor").val().length > 0
                    && $("#antiguedad_empresa_codeudor").val().length > 0
                    && $("#primer_apellido_representante_legal_codeudor").val().length > 0
                    && $("#segundo_apellido_representante_legal_codeudor").val().length > 0
                    && $("#nombres_representante_legal_codeudor").val().length > 0
                    && $("#tipo_identificacion_representante_legal_codeudor").val().length > 0
                    && $("#numero_identificacion_representante_legal_codeudor").val().length > 0
                    && $("#correo_representante_legal_codeudor").val().length > 0
                    && $("#ciudad_representante_legal_codeudor").val().length > 0
                    && $("#direccion_representante_legal_codeudor").val().length > 0
                    && $("#celular_representante_legal_codeudor").val().length > 0)
                {
                    $("#div_datos_empresariales_icono_pendiente").hide();
                    $("#div_datos_empresariales_icono_completo").show();
                }
                else {
                    $("#div_datos_empresariales_icono_pendiente").show();
                    $("#div_datos_empresariales_icono_completo").hide();
                }
            }

            function validacionInicialBotonPersona() {

                if ($("#tipo_persona_codeudor").val() == "natural") {
                    validarBotonPersona(document.getElementById("btnPersonaNatural"));
                }
                else if ($("#tipo_persona_codeudor").val() == "juridica") {
                    validarBotonPersona(document.getElementById("btnPersonaJuridica"));
                }
            }

            function validarBotonPersona(elem) {
                $("#div_autorizaciones").show();
                $("#div_botones").show();
                $("#adjuntar_cedula").attr("required", true);

                if (elem.name == "btnPersonaNatural") {
                    $("#costo_consulta").text('SEIS MIL QUINIENTOS PESOS M/CTE ($6.500.oo) por persona');

                    $("#btnPersonaNatural").addClass('active');
                    $("#btnPersonaJuridica").removeClass('active');
                    $("#tipo_persona_codeudor").val("natural");

                    $("#div_datos_personales").show();
                    $("#primer_apellido_codeudor").attr("required", true);
                    $("#segundo_apellido_codeudor").attr("required", true);
                    $("#nombres_codeudor").attr("required", true);
                    $("#tipo_identificacion_codeudor").attr("required", true);
                    $("#numero_identificacion_codeudor").attr("required", true);
                    $("#fecha_nacimiento_codeudor").attr("required", true);
                    $("#ciudad_codeudor").attr("required", true);
                    $("#barrio_codeudor").attr("required", true);
                    $("#celular_codeudor").attr("required", true);
                    $("#correo_codeudor").attr("required", true);
                    $("#estado_civil_codeudor").attr("required", true);
                    $("#tipo_vivienda_codeudor").attr("required", true);
                    $("#estrato_codeudor").attr("required", true);
                    $("#personas_a_cargo_codeudor").attr("required", true);
                    if ($("#estado_civil_codeudor").val() == "casado" || $("#estado_civil_codeudor").val() == "union_libre") {
                        $("#nombre_apellido_conyuge_codeudor").attr("required", true);
                        $("#celular_conyuge_codeudor").attr("required", true);
                        $("#ciudad_conyuge_codeudor").attr("required", true);
                    }
                    else {
                        $("#nombre_apellido_conyuge_codeudor").removeAttr("required");
                        $("#celular_conyuge_codeudor").removeAttr("required");
                        $("#ciudad_conyuge_codeudor").removeAttr("required");
                    }

                    $("#div_fuentes_ingreso_persona_natural").show();

                    $("#div_informacion_financiera_persona_natural").show();
                    $("#honorarios_codeudor").attr("required", true);
                    $("#gasto_personal_familiar_codeudor").attr("required", true);
                    if ($("#estado_civil_codeudor").val() == "casado" || $("#estado_civil_codeudor").val() == "union_libre") {
                        $("#conyuge_ingresos_mensuales_codeudor").attr("required", true);
                        $("#conyuge_gastos_mensuales_codeudor").attr("required", true);
                    }
                    else {
                        $("#conyuge_ingresos_mensuales_codeudor").removeAttr("required");
                        $("#conyuge_gastos_mensuales_codeudor").removeAttr("required");
                    }

                    $("#div_activos_persona_natural").show();

                    $("#div_datos_empresariales *").removeAttr("required");
                    $("#div_datos_empresariales").hide();
                    $("#div_informacion_financiera_persona_juridica *").removeAttr("required");
                    $("#div_informacion_financiera_persona_juridica").hide();

                    $("#label_adjuntar_cedula_representante_legal").css("visibility", "hidden");
                    //$("#texto_adjuntar_cedula").text("Adjuntar cédula");

                    definirNombresMensajes("natural");
                }
                if (elem.name == "btnPersonaJuridica") {
                    $("#costo_consulta").text('VEINTISÉIS MIL PESOS M/CTE ($26.000.oo) por persona');

                    $("#btnPersonaJuridica").addClass('active');
                    $("#btnPersonaNatural").removeClass('active');
                    $("#tipo_persona_codeudor").val("juridica");

                    $("#div_datos_personales").hide();
                    $("#div_datos_personales *").removeAttr("required");
                    $("#fecha_nacimiento_codeudor").removeAttr("required");
                    $("#div_fuentes_ingreso_persona_natural").hide();
                    $("#div_fuentes_ingreso_persona_natural *").removeAttr("required");
                    $("#div_informacion_financiera_persona_natural").hide();
                    $("#div_informacion_financiera_persona_natural *").removeAttr("required");
                    $("#div_activos_persona_natural").hide();
                    $("#div_activos_persona_natural *").removeAttr("required");

                    $("#div_datos_empresariales").show();
                    $("#nombre_empresa_codeudor").attr("required", true);
                    $("#nit_codeudor").attr("required", true);
                    $("#direccion_empresa_codeudor").attr("required", true);
                    $("#ciudad_empresa_codeudor").attr("required", true);
                    $("#numero_contacto_empresa_codeudor").attr("required", true);
                    $("#actividad_economica_empresa_codeudor").attr("required", true);
                    $("#antiguedad_empresa_codeudor").attr("required", true);
                    $("#primer_apellido_representante_legal_codeudor").attr("required", true);
                    $("#segundo_apellido_representante_legal_codeudor").attr("required", true);
                    $("#nombres_representante_legal_codeudor").attr("required", true);
                    $("#tipo_identificacion_representante_legal_codeudor").attr("required", true);
                    $("#numero_identificacion_representante_legal_codeudor").attr("required", true);
                    $("#correo_representante_legal_codeudor").attr("required", true);
                    $("#ciudad_representante_legal_codeudor").attr("required", true);
                    $("#direccion_representante_legal_codeudor").attr("required", true);
                    $("#celular_representante_legal_codeudor").attr("required", true);

                    $("#div_informacion_financiera_persona_juridica").show();

                    $("#label_adjuntar_cedula_representante_legal").css("visibility", "visible");
                    //$("#texto_adjuntar_cedula").text("Adjuntar cédula representante legal");

                    definirNombresMensajes("juridica");
                }
            }

            function definirNombresMensajes(tipo_persona) {

                if (tipo_persona == "natural") {

                    $('#autorizaciones_nombre').text($('#nombres_codeudor').val());
                    $('#autorizaciones_primer_apellido').text($('#primer_apellido_codeudor').val());
                    $('#autorizaciones_segundo_apellido').text($('#segundo_apellido_codeudor').val());

                    $('#sarlaft_nombre').text($('#nombres').val());
                    $('#sarlaft_primer_apellido').text($('#primer_apellido_codeudor').val());
                    $('#sarlaft_segundo_apellido').text($('#segundo_apellido_codeudor').val());

                    $('#proteccion_datos_nombre').text($('#nombres').val());
                    $('#proteccion_datos_primer_apellido').text($('#primer_apellido_codeudor').val());
                    $('#proteccion_datos_segundo_apellido').text($('#segundo_apellido_codeudor').val());

                    $('#consulta_centrales_nombre').text($('#nombres').val());
                    $('#consulta_centrales_primer_apellido').text($('#primer_apellido_codeudor').val());
                    $('#consulta_centrales_segundo_apellido').text($('#segundo_apellido_codeudor').val());

                    $('#declaracion_nombre').text($('#nombres_codeudor').val());
                    $('#declaracion_primer_apellido').text($('#primer_apellido_codeudor').val());
                    $('#declaracion_segundo_apellido').text($('#segundo_apellido_codeudor').val());

                    $('#nombre_empresa_codeudor').on('input', function() {
                    });

                    $('#nombres_codeudor').on('input', function() {
                        $('#autorizaciones_nombre').text(this.value);
                        $('#sarlaft_nombre').text(this.value);
                        $('#proteccion_datos_nombre').text(this.value);
                        $('#consulta_centrales_nombre').text(this.value);
                        $('#declaracion_nombre').text(this.value);
                    });

                    $('#primer_apellido_codeudor').on('input', function() {
                        $('#autorizaciones_primer_apellido').text(this.value);
                        $('#sarlaft_primer_apellido').text(this.value);
                        $('#proteccion_datos_primer_apellido').text(this.value);
                        $('#consulta_centrales_primer_apellido').text(this.value);
                        $('#declaracion_primer_apellido').text(this.value);
                    });

                    $('#segundo_apellido_codeudor').on('input', function() {
                        $('#autorizaciones_segundo_apellido').text(this.value);
                        $('#sarlaft_segundo_apellido').text(this.value);
                        $('#proteccion_datos_segundo_apellido').text(this.value);
                        $('#consulta_centrales_segundo_apellido').text(this.value);
                        $('#declaracion_segundo_apellido').text(this.value);
                    });
                }

                else if (tipo_persona == "juridica") {

                    $('#autorizaciones_nombre').text($('#nombre_empresa_codeudor').val());
                    $('#autorizaciones_primer_apellido').text('');
                    $('#autorizaciones_segundo_apellido').text('');

                    $('#sarlaft_nombre').text($('#nombre_empresa_codeudor').val());
                    $('#sarlaft_primer_apellido').text('');
                    $('#sarlaft_segundo_apellido').text('');

                    $('#proteccion_datos_nombre').text($('#nombre_empresa_codeudor').val());
                    $('#proteccion_datos_primer_apellido').text('');
                    $('#proteccion_datos_segundo_apellido').text('');

                    $('#consulta_centrales_nombre').text($('#nombre_empresa_codeudor').val());
                    $('#consulta_centrales_primer_apellido').text('');
                    $('#consulta_centrales_segundo_apellido').text('');

                    $('#declaracion_nombre').text($('#nombre_empresa_codeudor').val());
                    $('#declaracion_primer_apellido').text('');
                    $('#declaracion_segundo_apellido').text('');

                    $('#nombre_empresa_codeudor').on('input', function() {
                        $('#autorizaciones_nombre').text(this.value);
                        $('#sarlaft_nombre').text(this.value);
                        $('#proteccion_datos_nombre').text(this.value);
                        $('#consulta_centrales_nombre').text(this.value);
                        $('#declaracion_nombre').text(this.value);
                    });

                    $('#nombres_codeudor').on('input', function() {
                    });

                    $('#primer_apellido_codeudor').on('input', function() {
                    });

                    $('#segundo_apellido_codeudor').on('input', function() {
                    });
                }
            }

            /*function habilitarSiguiente() {

                if ($("#tipo_persona_codeudor").val() == "natural") {
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
                if ($("#estado_civil_codeudor").val() == "casado" || $("#estado_civil_codeudor").val() == "union_libre") {
                    $("#div_datos_conyuge").show();
                    $("#div_conyuge_informacion_financiera").show();
                }
                else {
                    $("#div_datos_conyuge").hide();
                    $("#div_conyuge_informacion_financiera").hide();
                }
            }

            function validarTipoVivienda() {
                if ($("#tipo_vivienda_codeudor").val() == "propia" || $("#tipo_vivienda_codeudor").val() == "familiar") {
                    $("#div_arriendo_vivienda *").removeAttr("required");
                    $("#div_arriendo_vivienda").hide();
                }
                else {
                    $("#div_arriendo_vivienda *").attr("required", true);
                    $("#div_arriendo_vivienda").show();
                }
            }

            function validarTipoContrato(id_div) {
                if ($("#tipo_contrato_empleado_codeudor_" + id_div).val() == "laboral_fijo") {
                    $("#duracion_cantidad_empleado_codeudor_" + id_div).attr("required", true);
                    $("#div_fin_contrato_" + id_div).show();
                    $("#fin_contrato_empleado_codeudor_" + id_div).attr("required", true);
                }
                else {
                    $("#duracion_cantidad_empleado_codeudor_" + id_div).removeAttr("required");
                    $("#div_fin_contrato_codeudor_" + id_div).hide();
                    $("#fin_contrato_empleado_codeudor_" + id_div).removeAttr("required");
                }
            }

            let div_vehiculos_inicial = <?php if (isset($_SESSION['vehiculos_codeudor'])) { echo $_SESSION['vehiculos_codeudor']; } else { echo "''"; } ?>;
            for (i = 0; i < div_vehiculos_inicial.length; i++) {
                crearFilaInicialVehiculo(div_vehiculos_inicial[i].id, div_vehiculos_inicial[i].placa, div_vehiculos_inicial[i].valor_comercial, div_vehiculos_inicial[i].prenda);
                if (parseInt(div_vehiculos_inicial[i].id) >= cant_div_vehiculos) {
                    cant_div_vehiculos = parseInt(div_vehiculos_inicial[i].id) + 1;
                }
            }

            let div_inmuebles_inicial = <?php if (isset($_SESSION['inmuebles_codeudor'])) { echo $_SESSION['inmuebles_codeudor']; } else { echo "''"; } ?>;
            for (i = 0; i < div_inmuebles_inicial.length; i++) {
                crearFilaInicialInmueble(div_inmuebles_inicial[i].id, div_inmuebles_inicial[i].tipo_inmueble, div_inmuebles_inicial[i].valor_comercial, div_inmuebles_inicial[i].hipoteca, div_inmuebles_inicial[i].porcentaje_propiedad);
                if (parseInt(div_inmuebles_inicial[i].id) >= cant_div_inmuebles) {
                    cant_div_inmuebles = parseInt(div_inmuebles_inicial[i].id) + 1;
                }
            }

            let div_empleados_inicial = <?php if (isset($_SESSION['empleados_codeudor'])) { echo $_SESSION['empleados_codeudor']; } else { echo "''"; } ?>;
            for (i = 0; i < div_empleados_inicial.length; i++) {
                crearFilaInicialEmpleado(div_empleados_inicial[i].id, div_empleados_inicial[i].empresa, div_empleados_inicial[i].sector, div_empleados_inicial[i].antiguedad_empleado, div_empleados_inicial[i].tipo_contrato, div_empleados_inicial[i].duracion, div_empleados_inicial[i].duracion_cantidad, div_empleados_inicial[i].fin_contrato);
                if (parseInt(div_empleados_inicial[i].id) >= cant_div_empleados) {
                    cant_div_empleados = parseInt(div_empleados_inicial[i].id) + 1;
                }
            }

            let div_independientes_inicial = <?php if (isset($_SESSION['independientes_codeudor'])) { echo $_SESSION['independientes_codeudor']; } else { echo "''"; } ?>;
            for (i = 0; i < div_independientes_inicial.length; i++) {
                crearFilaInicialIndependiente(div_independientes_inicial[i].id, div_independientes_inicial[i].empresa, div_independientes_inicial[i].sector, div_independientes_inicial[i].antiguedad_independiente, div_independientes_inicial[i].ocupacion);
                if (parseInt(div_independientes_inicial[i].id) >= cant_div_independientes) {
                    cant_div_independientes = parseInt(div_independientes_inicial[i].id) + 1;
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
                $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-presionado.svg')");
                setTimeout(function() {
                    $("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-listo.svg')");
                }, 200);
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
                    '	<label for="placa_vehiculo_codeudor">Placa</label>' +
                    '	<input type="text" class="form-control" id="placa_vehiculo_codeudor_' + id + '" name="placa_vehiculo_codeudor_' + id + '" placeholder="Escribe..." maxlength="8" value="' + placa + '" required >' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 160px !important;">' +
                    '	<label for="valor_comercial_vehiculo_codeudor">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_vehiculo_codeudor_' + id + '" name="valor_comercial_vehiculo_codeudor_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="prenda_vehiculo_codeudor">Pignoración</label>' +
                    '	<select class="form-control" id="prenda_vehiculo_codeudor_' + id + '" name="prenda_vehiculo_codeudor_' + id + '" >' +
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
                    '	<label for="tipo_inmueble_codeudor">Tipo</label>' +
                    '	<select class="form-control" id="tipo_inmueble_codeudor_' + id + '" name="tipo_inmueble_codeudor_' + id + '" required >' +
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
                    '	<label for="valor_comercial_inmueble_codeudor">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_inmueble_codeudor_' + id + '" name="valor_comercial_inmueble_codeudor_' + id + '" placeholder="Cifra..." value="' + valor_comercial + '" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 300px !important;">' +
                    '	<label for="porcentaje_propiedad_inmueble_codeudor">Porcentaje de propiedad</label>' +
                    '	<select class="form-control" id="porcentaje_propiedad_inmueble_codeudor_' + id + '" name="porcentaje_propiedad_inmueble_codeudor_' + id + '" required >' +
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
                    '	<label for="hipoteca_inmueble_codeudor">Hipoteca</label>' +
                    '	<select class="form-control" id="hipoteca_inmueble_codeudor_' + id + '" name="hipoteca_inmueble_codeudor_' + id + '" >' +
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
                    '	<label for="empresa_empleado_codeudor">Empresa</label>' +
                    '	<input type="text" class="form-control" id="empresa_empleado_codeudor_' + id + '" name="empresa_empleado_codeudor_' + id + '" placeholder="Escribe..." value="' + empresa + '" required >' +
                    '</div>' +
                    '<div class="deudor-control">' +
                    '	<label for="sector_empleado_codeudor">Cargo</label>' +
                    '	<input type="text" class="form-control" id="sector_empleado_codeudor_' + id + '" name="sector_empleado_codeudor_' + id + '" placeholder="Tu labor" value="' + sector + '" required >' +
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
                    '	<select class="form-control" id="tipo_contrato_empleado_codeudor_' + id + '" name="tipo_contrato_empleado_codeudor_' + id + '" onchange="validarTipoContrato(' + id + ')" required >' +
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
                    '	<input type="number" class="form-control" id="duracion_cantidad_empleado_codeudor_' + id + '" name="duracion_cantidad_empleado_codeudor_' + id + '" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Meses..." value="' + duracion_cantidad + '" >' +
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
                    '	<input type="date" class="form-control" id="fin_contrato_empleado_codeudor_' + id + '" name="fin_contrato_empleado_codeudor_' + id + '" placeholder="dd-mm-yyyy" value="' + fin_contrato + '" >' +
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
                    '	<label for="empresa_independiente_codeudor">Actividad económica</label>' +
                    '    <select class="form-control js-example-basic-single" id="empresa_independiente_codeudor_' + id + '" name="empresa_independiente_codeudor_' + id + '" required >' +
                    '    <option selected>-Escoge-</option>' +
                    <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                    '        <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>"><?= $listado_actividades_economicas[$i]['nombre']; ?></option>' +
                    <?php endfor; ?>
                    '    </select>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 225px">' +
                    '	<label for="ocupacion_independiente">Cargo</label>' +
                    '	<input type="text" class="form-control" id="ocupacion_independiente_codeudor_' + id + '" name="ocupacion_independiente_codeudor_' + id + '" placeholder="Tu labor" value="' + ocupacion + '" required >' +
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
                    '	<select class="form-control" id="antiguedad_independiente_codeudor_' + id + '" name="antiguedad_independiente_codeudor_' + id + '" required >' +
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
                    '	<label for="placa_vehiculo_codeudor">Placa</label>' +
                    '	<input type="text" class="form-control" id="placa_vehiculo_codeudor_' + cant_div_vehiculos + '" name="placa_vehiculo_codeudor_' + cant_div_vehiculos + '" placeholder="Escribe..." maxlength="8" value="" required >' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 160px !important;">' +
                    '	<label for="valor_comercial_vehiculo_codeudor">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_vehiculo_codeudor_' + cant_div_vehiculos + '" name="valor_comercial_vehiculo_codeudor_' + cant_div_vehiculos + '" placeholder="Cifra..." value="" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 150px !important;">' +
                    '	<label for="prenda_vehiculo">Pignoración</label>' +
                    '	<select class="form-control" id="prenda_vehiculo_codeudor_' + cant_div_vehiculos + '" name="prenda_vehiculo_codeudor_' + cant_div_vehiculos + '" required >' +
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

                $("#valor_comercial_vehiculo_codeudor_" + cant_div_vehiculos).on("input", function() {
                    formatCurrency($(this));
                });

                $("#placa_vehiculo_codeudor_" + cant_div_vehiculos).focus();

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
                    '	<label for="tipo_inmueble_codeudor">Tipo</label>' +
                    '	<select class="form-control" id="tipo_inmueble_codeudor_' + cant_div_inmuebles + '" name="tipo_inmueble_codeudor_' + cant_div_inmuebles + '" required >' +
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
                    '	<label for="valor_comercial_inmueble_codeudor">Valor comercial</label>' +
                    '	<div class="input-icon">' +
                    '	  <input type="text" inputmode="numeric" pattern="[0-9.]*" class="form-control" id="valor_comercial_inmueble_codeudor_' + cant_div_inmuebles + '" name="valor_comercial_inmueble_codeudor_' + cant_div_inmuebles + '" placeholder="Cifra..." value="" required >' +
                    '	  <i>$</i>' +
                    '	</div>' +
                    '</div>' +
                    '<hr class="separador-movil">' +
                    '<div class="deudor-control" style="width: 300px !important;">' +
                    '	<label for="porcentaje_propiedad_inmueble">Porcentaje de propiedad</label>' +
                    '	<select class="form-control" id="porcentaje_propiedad_inmueble_codeudor_' + cant_div_inmuebles + '" name="porcentaje_propiedad_inmueble_codeudor_' + cant_div_inmuebles + '" required >' +
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
                    '	<label for="hipoteca_inmueble_codeudor">Hipoteca</label>' +
                    '	<select class="form-control" id="hipoteca_inmueble_codeudor_' + cant_div_inmuebles + '" name="hipoteca_inmueble_codeudor_' + cant_div_inmuebles + '" >' +
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

                $("#valor_comercial_inmueble_codeudor_" + cant_div_inmuebles).on("input", function() {
                    formatCurrency($(this));
                });

                $("#tipo_inmueble_codeudor_" + cant_div_inmuebles).focus();

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
                    '	<label for="empresa_empleado_codeudor">Empresa</label>' +
                    '	<input type="text" class="form-control" id="empresa_empleado_codeudor_' + cant_div_empleados + '" name="empresa_empleado_codeudor_' + cant_div_empleados + '" placeholder="Escribe..." value="" required >' +
                    '</div>' +
                    '<div class="deudor-control">' +
                    '	<label for="sector_empleado_codeudor">Cargo</label>' +
                    '	<input type="text" class="form-control" id="sector_empleado_codeudor_' + cant_div_empleados + '" name="sector_empleado_codeudor_' + cant_div_empleados + '" placeholder="Tu labor" value="" required >' +
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
                    '	<select class="form-control" id="tipo_contrato_empleado_codeudor_' + cant_div_empleados + '" name="tipo_contrato_empleado_codeudor_' + cant_div_empleados + '" onchange="validarTipoContrato(' + cant_div_empleados + ')" required >' +
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
                    '	<input type="number" class="form-control" id="duracion_cantidad_empleado_codeudor_' + cant_div_empleados + '" name="duracion_cantidad_empleado_codeudor_' + cant_div_empleados + '" min=0 onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Meses..." value="" >' +
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
                    '	<input type="date" class="form-control" id="fin_contrato_empleado_codeudor_' + cant_div_empleados + '" name="fin_contrato_empleado_codeudor_' + cant_div_empleados + '" placeholder="dd-mm-yyyy" value="<?php echo date('Y-m-d'); ?>" >' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#div_fuentes_ingreso').append(div_empleados);
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
                    $('#btnEliminarEmpleados' + cant_div_empleados).css("visibility", "hidden");
                }

                $("#empresa_empleado_codeudor_" + cant_div_empleados).focus();

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
                    '	<label for="empresa_independiente_codeudor">Actividad económica</label>' +
                    '    <select class="form-control js-example-basic-single" id="empresa_independiente_codeudor_' + cant_div_independientes + '" name="empresa_independiente_codeudor_' + cant_div_independientes + '" required >' +
                    '    <option selected>-Escoge-</option>' +
                    <?php for ($i = 0; $i < sizeof($listado_actividades_economicas); $i++): ?>
                    '        <option value="<?= $listado_actividades_economicas[$i]['codigo']; ?>"><?= $listado_actividades_economicas[$i]['nombre']; ?></option>' +
                    <?php endfor; ?>
                    '    </select>' +
                    '</div>' +
                    '<div class="deudor-control" style="width: 225px">' +
                    '	<label for="ocupacion_independiente">Cargo</label>' +
                    '	<input type="text" class="form-control" id="ocupacion_independiente_codeudor_' + cant_div_independientes + '" name="ocupacion_independiente_codeudor_' + cant_div_independientes + '" placeholder="Tu labor" value="" required >' +
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
                    '	<select class="form-control" id="antiguedad_independiente_codeudor_' + cant_div_independientes + '" name="antiguedad_independiente_codeudor_' + cant_div_independientes + '" required >' +
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

                $("#empresa_independiente_codeudor_" + cant_div_independientes).focus();

                cant_div_independientes++;
                inicializarSelectPlugin();
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
            setTimeout(registrarSesionCodeudor, interval);

            var interval2 = 10000;
            setTimeout(registrarDatosTemporales, interval2);

            function registrarSesionCodeudor() {
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
                    url: 'guardar_sesion_codeudor',
                    data:  $(mainForm).serialize(),
                    success: function (data) {
                    },
                    complete: function (data) {
                        if (data.responseText != "success") {
                            console.log("Error al registrar los datos");
                        }
                    }
                });

                setTimeout(registrarSesionCodeudor, interval);
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
                    url: 'guardar_datos_temporales_codeudor',
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

            function registrarDatosCodeudor() {
                document.getElementById("mainForm").submit();
            }

            function enviarInformacionCodeudor() {
                var validForm = document.getElementById("mainForm").checkValidity();
                if (validForm == true) {
                    var total_fuentes_ingreso = ($('div[name^="div_empleados"]:not([name^="div_empleados_icono"])' ).length + $('div[name^="div_independientes"]:not([name^="div_empleados_icono"])' ).length);

                    if ($("#btnAutorizacion").hasClass("active")) {
                        if ($("#tipo_persona_codeudor").val() == "natural") {
                            if (total_fuentes_ingreso > 0) {
                                $('#modalCargando').modal('show');

                                registrarDatosCodeudor();
                            }
                            else {
                                mostrarModalValidacionFuentesIngresoYActivos();
                            }
                        }
                        else {
                            $('#modalCargando').modal('show');
                            registrarDatosCodeudor();
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

            function mostrarModalValidacionTerminosYCondiciones() {
                $('#modalValidacionTerminosYCondiciones').modal('toggle');
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