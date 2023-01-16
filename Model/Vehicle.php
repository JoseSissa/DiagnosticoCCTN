<?php

namespace Model;

class Vehicle
{
	
	public function __construct($placa, $valor_comercial, $prenda) {
		$this->placa = $placa;
		$this->valor_comercial = $valor_comercial;
		$this->prenda = $prenda;
	}
}