<?php

namespace Model;

class Property
{
	
	public function __construct($tipo_inmueble, $valor_comercial, $hipoteca, $porcentaje_propiedad) {
		$this->tipo_inmueble = $tipo_inmueble;
		$this->valor_comercial = $valor_comercial;
		$this->hipoteca = $hipoteca;
        $this->porcentaje_propiedad = $porcentaje_propiedad;
	}
}