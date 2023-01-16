<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class NewCodebtorView
{
    public function __construct($id_deudor, $deudor, $listado_codeudores)
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
		</style>
		<html lang="es">
			<head>
				<title>Agregar codeudores - Vanka</title>
				<?php new HtmlHead(); ?>
            </head>
			<body>
				<div id="contenido_formulario" name="contenido_formulario" >
			
				<?php new HeaderRow(); ?>

				<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
				  <h2>Bienvenido <b><?= $deudor ?></b></h2>
				  <p class="lead">Aquí podrás agregar los codeudores que consideres necesarios.</p>
				</div>
				
				<div class="container">
				<form class="needs-validation" id="mainForm" name="mainForm" method="POST" action="registrar_nuevo_codeudor" role="form" enctype="multipart/form-data" autocomplete="off" >
				<input type="hidden" id="id_deudor" name="id_deudor" value="<?php echo $id_deudor; ?>" />
				
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
						<?php
							for ($i = 0; $i < count($listado_codeudores); $i++) {
								echo '<div class="row" id="filaCodeudorRegistrado_' . $i . '" onmouseenter="$(\'#btnEliminarCodeudoresRegistrados_' . $i . '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarCodeudoresRegistrados_' . $i . '\').css(\'visibility\', \'hidden\')">';
								echo '<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">';
								echo '<button id="btnEliminarCodeudoresRegistrados_' . $i . '" name="btnEliminarCodeudoresRegistrados_' . $i . '" class="boton-eliminar" type="button" onclick="eliminarCodeudorRegistrado(' . $i . ', \'' .  $listado_codeudores[$i]->uid . '\')" style="visibility: hidden;">X</button>';
								echo '</div>';
								echo '<div class="deudor-control">';
								echo '<label>Nombre(s) y apellido(s) persona o Nombre empresa</label>';
								echo '<input type="text" class="form-control" placeholder="Escribe..." value="' . $listado_codeudores[$i]->nombres . '" disabled>';
								echo '</div>';
								echo '<div class="deudor-control" style="width:190px !important">';
								echo '<label>Celular de contacto</label>';
								echo '<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" placeholder="Escribe..." value="' . $listado_codeudores[$i]->celular . '" disabled>';
								echo '</div>';
								echo '<div class="deudor-control" style="width:180px !important">';
								echo '<label>Correo electrónico</label>';
								echo '<input type="text" class="form-control" placeholder="Escribe..." value="' . $listado_codeudores[$i]->correo . '" disabled>';
								echo '</div>';
								echo '</div>';
							}
						?>
						<div class="row d-flex justify-content-center">
							<div style="padding: 10px 10px">
								<img src="Resources/img/boton-agregar.svg" style="cursor: pointer;" onmouseenter="animacionBotonAgregarAlPasarMouse($(this), 1);" onmouseleave="animacionBotonAgregarAlPasarMouse($(this), 0);" onclick="animacionBotonAgregarAlPresionar($(this)); crearFilaCodeudor()" />
								<span style="vertical-align: middle; padding-left: 5px"><b>Codeudor</b></span>
							</div>
						</div>
					  </div>
				  </div>
				
				<div style="text-align: center; padding-top: 30px; padding-bottom: 200px;" id="div_botones" name="div_botones" >
					
					<div style="display: flex; flex-direction: row; align-items: flex-start; justify-content: center; flex-wrap: wrap">
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
						<p>Debe diligenciar por lo menos un codeudor.</p>
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
						<h5 class="modal-title" id="modalTituloCargando">Cargando</h5>
					  </div>
					  <div class="modal-body">
						<p>Por favor espera mientras la información es registrada...</p>
					  </div>
					  <div class="modal-footer">
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
				
					$("#div_codeudor").focusin(function() {
						$("#div_codeudor .deudor-encabezado").addClass("fijo");
					});
					$("#div_codeudor").focusout(function() {
						$("#div_codeudor .deudor-encabezado").removeClass("fijo");
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
					
					
					if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
						$("button[name^='btnEliminarCodeudores']").css("visibility", "hidden");
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
				
			var cant_div_codeudores = 0;
			
			$("#div_codeudor_icono_pendiente").hide();
			$("#div_codeudor_icono_completo").hide();
			
			function validarDivCodeudor() {
				var total_codeudores = $('div[name^="div_codeudor_"]:not([name^="div_codeudor_icono"])' ).toArray();
				if (total_codeudores.length > 0) {
					
					var pendienteCorreoCodeudor = false;
					
					total_codeudores.forEach(function(item, index) {
						let id = item.id.replace("div_codeudor_", "");
						if ($("#correo_codeudor_deudor_" + id).val().length <= 0
							|| $("#nombre_codeudor_deudor_" + id).val().length <= 0
							|| $("#celular_codeudor_deudor_" + id).val().length <= 0)
						{
							pendienteCorreoCodeudor = true;
						}
					});
					
					if (pendienteCorreoCodeudor == true) {
						$("#div_codeudor_icono_pendiente").show();
						$("#div_codeudor_icono_completo").hide();
					}
					else {
						$("#div_codeudor_icono_pendiente").hide();
						$("#div_codeudor_icono_completo").show();
					}
				}
				else {
					$("#div_codeudor_icono_pendiente").show();
					$("#div_codeudor_icono_completo").hide();
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
			
			function animacionBotonSiguienteAlPresionar(boton) {
				$("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-presionado.svg')");
				setTimeout(function() {
					$("#btnSiguiente").css("background-image", "url('https://www.vanka.com.co/credito/Resources/img/boton-siguiente-listo.svg')");
				}, 200);
			}
			
			function crearFilaCodeudor() {
				let div_codeudor = '<div class="row" id="div_codeudor_' + cant_div_codeudores + '" name="div_codeudor_' + cant_div_codeudores + '" onmouseenter="$(\'#btnEliminarCodeudores' + cant_div_codeudores + '\').css(\'visibility\', \'\')" onmouseleave="$(\'#btnEliminarCodeudores' + cant_div_codeudores + '\').css(\'visibility\', \'hidden\')" >' +
							'<div class="deudor-control" style="display: flex; justify-content: flex-start; align-items: flex-end; padding-left: 15px; padding-right: 15px; ">' +
							'	<button id="btnEliminarCodeudores' + cant_div_codeudores + '" name="btnEliminarCodeudores' + cant_div_codeudores + '" class="boton-eliminar" type="button" onclick="eliminarFilaDinamica(\'div_codeudor_' + cant_div_codeudores + '\'); validarDivCodeudor();" >X</button>' +
							'</div>' +
							'<div class="deudor-control" >' +
							'<label for="nombre_codeudor_deudor_' + cant_div_codeudores + '">Nombre(s) y apellido(s) persona o Nombre empresa</label>' +
							'	<input type="text" class="form-control" id="nombre_codeudor_deudor_' + cant_div_codeudores + '" name="nombre_codeudor_deudor_' + cant_div_codeudores + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
							'  </div>' +
							'  <div class="deudor-control" style="width:190px !important">' +
							'	<label for="celular_codeudor_deudor_' + cant_div_codeudores + '">Celular de contacto</label>' +
							'	<input type="text" inputmode="numeric" pattern="[0-9.]{10,15}" class="form-control" id="celular_codeudor_deudor_' + cant_div_codeudores + '" name="celular_codeudor_deudor_' + cant_div_codeudores + '" minlength="10" maxlength="15" title="Mínimo 10 dígitos, máximo 15 dígitos" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
							'  </div>' +
							'  <div class="deudor-control" style="width:180px !important">' +
							'	<label for="correo_codeudor_deudor_' + cant_div_codeudores + '">Correo electrónico</label>' +
							'	<input type="text" class="form-control" id="correo_codeudor_deudor_' + cant_div_codeudores + '" name="correo_codeudor_deudor_' + cant_div_codeudores + '" onchange="validarDivCodeudor()" placeholder="Escribe..." value="" required >' +
							'  </div>' +
							'</div>' +
							'</div>' +
							'</div>';
				$('#div_caja_codeudor').append(div_codeudor);
				if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) == false ) {
					$('#btnEliminarCodeudores' + cant_div_codeudores).css("visibility", "hidden");
				}
				
				$("#nombre_codeudor_deudor_" + cant_div_codeudores).focus();
				
				cant_div_codeudores++;
			}
			
			function eliminarFilaDinamica(nombre_div) {
				$('#' + nombre_div).remove();
				validarDivCodeudor();
			}
			
			function eliminarCodeudorRegistrado(id, uid) {
				$.ajax({
					type: 'POST',
					url: 'eliminar_codeudor',
					data:  { uid: uid },
					success: function (data) {
					},
					complete: function (data) {
						if (data.responseText == 1) {
							$("#filaCodeudorRegistrado_" + id).remove();
						}
					}
				});
			}
			
			</script>
			
			<script>
				$("#mainForm").submit(function(e){
					e.preventDefault();
				});
				
				function registrarDatosCodeudor() {
					document.getElementById("mainForm").submit();
				}

				function enviarInformacionCodeudor() {
					var validForm = document.getElementById("mainForm").checkValidity();
					if (validForm == true) {
						var total_codeudores = $('div[name^="div_codeudor_"]:not([name^="div_codeudor_icono"])' ).length;
						if (total_codeudores > 0) {
							$('#modalCargando').modal('show');
							registrarDatosCodeudor();
						}
						else {
							$('#modalValidacionCodeudores').modal('toggle');
						}
					}
				}
				
			</script>
		</html>
		<?php
    }
}