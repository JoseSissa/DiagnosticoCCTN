<?php

namespace Controllers;

use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Database;
use Views\ReadDebtorView;
use Views\ReadCodebtorView;

class ReadController
{
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function abrirFormularioDeudorAnterior() {
		if (Input::Any('num_radicado') == null || Input::Any('num_radicado') == "") {
			Url::redirect('/error');
		}
		
		$num_radicado = htmlspecialchars(Input::Any('num_radicado'), ENT_QUOTES);
		
		$debtor_data = $this->db->getDebtorData($num_radicado);
		$listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();
		new ReadDebtorView($debtor_data, $listado_ciudades, $listado_actividades_economicas);
	}
	
	public function abrirFormularioCodeudorAnterior() {
		if (Input::Any('uid') == null || Input::Any('uid') == "") {
			Url::redirect('/error');
		}
		
		$uid = htmlspecialchars(Input::Any('uid'), ENT_QUOTES);
		
		$codebtor_data = $this->db->getCodebtorData($uid);
		
		$id_deudor = $codebtor_data->id_deudor;
		$debtor = $this->db->getDebtorData($id_deudor);
		
		$nombre_codeudor = $codebtor_data->nombres;
		if ($debtor->tipo_persona == "juridica") {
			$nombre_deudor = $debtor->nombre_empresa;
		}
		else {
			$nombre_deudor = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();
		new ReadCodebtorView($codebtor_data, $uid, $nombre_codeudor, $nombre_deudor, $listado_ciudades, $listado_actividades_economicas);
	}
	
	public function abrirFormularioDeudorTemporalAnterior() {
		if (Input::Any('id') == null || Input::Any('id') == "") {
			Url::redirect('/error');
		}
		
		$id = htmlspecialchars(Input::Any('id'), ENT_QUOTES);
		
		$debtor_data = $this->db->getTempDebtorData($id);
		$listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();
		new ReadDebtorView($debtor_data, $listado_ciudades, $listado_actividades_economicas);
	}
	
	public function abrirFormularioCodeudorTemporalAnterior() {
		if (Input::Any('id') == null || Input::Any('id') == "") {
			Url::redirect('/error');
		}

		$id = htmlspecialchars(Input::Any('id'), ENT_QUOTES);
		
		$codebtor_data = $this->db->getTempCodebtorData($id);
		
		$id_deudor = $codebtor_data->id_deudor;
		$debtor = $this->db->getDebtorData($id_deudor);
		
		$nombre_codeudor = $codebtor_data->nombres;
		if ($debtor->tipo_persona == "juridica") {
			$nombre_deudor = $debtor->nombre_empresa;
		}
		else {
			$nombre_deudor = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}

        $listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();
        new ReadCodebtorView($codebtor_data, $id, $nombre_codeudor, $nombre_deudor, $listado_ciudades, $listado_actividades_economicas);
	}
}