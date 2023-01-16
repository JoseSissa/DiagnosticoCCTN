<?php

namespace Model;

class Employee
{
	
	public function __construct($empresa, $sector, $antiguedad_empleado, $tipo_contrato, $duracion, $duracion_cantidad, $fin_contrato) {
		$this->empresa = $empresa;
		$this->sector = $sector;
		$this->antiguedad_empleado = $antiguedad_empleado;
		$this->tipo_contrato = $tipo_contrato;
		$this->duracion = $duracion;
		$this->duracion_cantidad = $duracion_cantidad;
		$this->fin_contrato = $fin_contrato;
	}
}