<?php

namespace Model;

class CodebtorSummary
{
	
	public function __construct($uid, $id_deudor, $nombres, $celular, $correo) {
		$this->uid = $uid;
		$this->id_deudor = $id_deudor;
		$this->nombres = $nombres;
		$this->celular = $celular;
		$this->correo = $correo;
		$this->fue_diligenciado = 0;
	}
	
	public function confirmarDiligenciado() {
		$this->fue_diligenciado = 1;
	}
}