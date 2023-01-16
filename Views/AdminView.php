<?php

namespace Views;

use Infinitesimal\Input;
use Model\Debtor;
use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class AdminView
{
    public function __construct()
    {
		//$success = htmlspecialchars(Input::Any('success'), ENT_QUOTES);
		?>
		<html lang="es">
			
			<head>
				<title>Panel de administración - Vanka</title>
				<?php new HtmlHead(); ?>
            </head>
			<body>
				<?php new HeaderRow(); ?>
				<div class="contenedor-pagina">
					<div class="admin__contenido">
						<button type="button" class="btn btn-primary" onclick="window.location.href='logout'">Cerrar sesión</button>
						<button type="button" class="btn btn-primary" onclick="window.location.href='exportar'">Exportar datos</button>
						<button type="button" class="btn btn-primary" onclick="window.location.href='exportar_temporales'">Exportar temporales</button>
					</div>
					
				</div>
				<?php new Footer(); ?>
			</body>
		</html>
		<?php
    }
}