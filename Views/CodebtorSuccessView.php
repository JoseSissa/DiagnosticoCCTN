<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class CodebtorSuccessView
{
    public function __construct($num_radicado, $nombre_deudor)
    {
		?>
		<html lang="es">
			<head>
				<title>Registro finalizado - Vanka</title>
				<?php new HtmlHead(); ?>
            </head>
			<body>
				<?php new HeaderRow(); ?>

				<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
				  <h3>¡Completaste la solicitud y se registró<br>exitosamente!</h3>
				  <br>
				  <p class="lead">Tu número de radicado es:<br><b>#<?= $num_radicado ?></b></p>
				  <br>
				  <p class="lead">Hemos enviado a tu correo esta novedad.<br>Si este no llega a tu bandeja principal,<br>verifica tu buzón de correo no deseado o spam.</p>
				  <br>
				  <p class="lead">De 1 a 3 días <b><?= $nombre_deudor ?></b> recibirá la respuesta de<br>su preaprobado y el paso a seguir.</p>
				  <br>
				  <p class="lead">Si deseas, puedes contactarnos al<br>+57 304 399 2901.</p>
				  <br>
				  <button class="boton-formulario active" type="button" onclick="window.location.href='https://www.vanka.com.co'" >Volver a Vanka</button>
				</div>

				<div class="row">
					<div class="col-12">
						<?php new Footer(); ?>
					</div>
				</div>
			
			</body>
		</html>
		<?php
    }
} 