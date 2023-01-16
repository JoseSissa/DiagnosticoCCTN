<?php

namespace Model;

class Independent
{
	
	public function __construct($empresa, $sector, $antiguedad_independiente, $ocupacion) {
		$this->empresa = $empresa;
		$this->sector = $sector;
		$this->antiguedad_independiente = $antiguedad_independiente;
		$this->ocupacion = $ocupacion;
	}
}