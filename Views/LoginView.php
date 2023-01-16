<?php

namespace Views;

use Views\Components\HtmlHead;
use Views\Components\HeaderRow;
use Views\Components\Footer;

class LoginView
{
    public function __construct()
    {
		?>
		<html lang="es">
			<head>
				<title>Inicio de sesión - Vanka</title>
				<?php new HtmlHead(); ?>
            </head>
			<body>
				<?php new HeaderRow(); ?>
				<div class="contenedor-pagina">
					
					<h4 class="login__titulo">Ingresa tus datos:</h4>
					<form class="needs-validation" id="mainForm" name="mainForm" action="authorize" method="POST" >
					<div class="login__contenido">
						<div class="row">
						  <div class="col-md-6 mb-3">
							  <label for="usuario">Usuario</label>
							  <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Escribe tu nombre de usuario" value="" required>
						  </div>
						  <div class="col-md-6 mb-3">
							  <label for="clave">Contraseña</label>
							  <input type="password" id="clave" name="clave" class="form-control" placeholder="Escribe tu contraseña" value="" required>
						  </div>
						</div>
						<button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar sesión</button>
					</div>
					</form>
					
				</div>
				<?php new Footer(); ?>
			</body>
		</html>
		<?php
    }
}