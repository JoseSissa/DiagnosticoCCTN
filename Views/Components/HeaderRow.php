<?php

namespace Views\Components;

class HeaderRow
{
    public function __construct()
    {
        ?>
		<header class="banner" style="background-image: url('<?php if (strpos($_SERVER['REQUEST_URI'], "registro_finalizado") == true || strpos($_SERVER['REQUEST_URI'], "registro_codeudor_finalizado") == true) { echo "Resources/img/banner_icon.svg"; } else { echo "Resources/img/banner_icon_no_check.svg"; } ?>');">
			<div class="row div-header">
				<div class="col-6" style="align-self: center;">
					<h2 class="solo-escritorio" style="margin: 0 !important">Comencemos a impulsar <b>tus sueños</b></h2>
				</div>
				<div class="col-6" style="align-self: center; text-align: end;">
					<a href="https://vanka.com.co/">
						<img class="logo" alt="vanka" src="Resources/img/logo_vanka.png">
					</a>
				</div>
			</div>
		</header>
		<?php
    }
} 