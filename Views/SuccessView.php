<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class SuccessView
{
    public function __construct($num_radicado, $arrayUid)
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
                    <h3>¡Tu solicitud se registró<br>exitosamente!</h3>
                    <br>
                    <p class="lead">Tu número de radicado es:<br><b>#<?= $num_radicado ?></b></p>
                    <p class="lead">Ahora tu codeudor debe completar esta solicitud con el link enviado a su correo, tú también recibirás esta novedad.</p>
                    <p class="lead">Si este correo no llega a la bandeja principal, verifica tu buzón de correo no deseado o spam.</p>
                    <br>
                    <p class="lead">También puedes compartir a tu codeudor el link a través de:</p>
                    <div class="botones-compartir">
                        <?php $i = 0; ?>
                        <?php foreach($arrayUid as $uid): ?>
                        <?php $i++; ?>
                        <p class="lead font-weight-bold">Codeudor <?= $i ?></p>
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="https://www.vanka.com.co/credito/codeudor?uid=<?= $uid; ?>" data-a2a-title="Crédito Vanka">
                            <a class="a2a_button_whatsapp"></a>
                            <a class="a2a_button_facebook_messenger"></a>
                            <a class="a2a_button_email"></a>
                            <a class="a2a_button_telegram"></a>
                            <a class="a2a_button_sms"></a>
                        </div>
                        <br>
                        <!-- AddToAny END -->
                        <?php endforeach; ?>
                    </div>
                    <br>
                    <p class="lead">De 1 a 3 días recibirás la respuesta de tu<br>preaprobado y el paso a seguir.</p>
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

                <script>
                    var a2a_config = a2a_config || {};
                    a2a_config.onclick = 1;
                    a2a_config.locale = "es";
                    a2a_config.num_services = 6;
                </script>
                <script async src="https://static.addtoany.com/menu/page.js"></script>
			</body>
		</html>
		<?php
    }
} 