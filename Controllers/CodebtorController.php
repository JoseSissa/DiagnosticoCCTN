<?php

namespace Controllers;

use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Codebtor;
use Model\CreditMailer;
use Model\Database;
use Model\Debtor;
use Model\Employee;
use Model\Independent;
use Model\Property;
use Model\Vehicle;
use Views\CodebtorView;
use Views\CodebtorSuccessView;

class CodebtorController
{
	private $db;
	
	public function __construct(Database $db, CreditMailer $creditMailer) {
		$this->db = $db;
		$this->creditMailer = $creditMailer;
	}
	
	public function checkHoneypot($input_name): bool {
		$honeypot = Input::Any($input_name);
		if ($honeypot != "")
		{
			return true;
		}
		return false;
	}
	
	public function abrirFormularioCodeudor() {

		if (Input::Any('uid') == null || Input::Any('uid') == "") {
			Url::redirect('/error');
		}
		$uid = htmlspecialchars(Input::Any('uid'), ENT_QUOTES);
		$codebtor = $this->db->getCodebtorSummary($uid);
		if ($codebtor == -1) {
			Url::redirect('/error');
		}
		
		$id_deudor = $codebtor->id_deudor;
		if ($codebtor->fue_diligenciado == 1) {
			Url::redirect('/registro_codeudor_finalizado?uid=' . $uid);
		}
		
		$debtor = $this->db->getDebtorData($id_deudor);
		
		$nombre_codeudor = $codebtor->nombres;
		if ($debtor->tipo_persona == "juridica") {
			$nombre_deudor = $debtor->nombre_empresa;
		}
		else {
			$nombre_deudor = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$listado_ciudades = $this->db->getCities();
        $listado_actividades_economicas = $this->db->getEconomicActivities();

		new CodebtorView($uid, $id_deudor, $nombre_codeudor, $nombre_deudor, $listado_ciudades, $listado_actividades_economicas);
	}
	
	public function registrarDatos() {
		$codebtor = new Codebtor();
		$codebtor->fromInput();
		
		$uid = htmlspecialchars(Input::Any('uid'), ENT_QUOTES);
		$result = $this->db->registerCodebtorData($uid, $codebtor);
		
		if ($result == 1) {
		
			$numero_identificacion = "";
			if ($codebtor->tipo_persona == "natural") {
				$numero_identificacion = $codebtor->numero_identificacion;
			}
			else if ($codebtor->tipo_persona == "juridica") {
				$numero_identificacion = $codebtor->numero_identificacion_representante_legal;
				$nit = $codebtor->nit;

				$id = $this->db->getCodebtorData($uid)->id;

				$this->subirEstadosFinancieros($id, $nit);
			}
			$this->subirCedula($numero_identificacion, $uid);
			
			if (strlen($uid) > 9) {
				if ($this->enviarCorreoCodeudor($uid) > 0) {
					if ($this->enviarCorreoCodeudorAdmin($uid) > 0) {
						
						$codebtorData = $this->db->getCodebtorSummary($uid);
						$id_deudor = $codebtorData->id_deudor;
						$debtorData = $this->db->getDebtorData($id_deudor);
						if ($debtorData->tipo_persona == "juridica") {
							$nombre_deudor = $debtorData->nombre_empresa;
						}
						else {
							$nombre_deudor = $debtorData->nombres . " " . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido;
						}
						
						new CodebtorSuccessView($id_deudor, $nombre_deudor);
						
					}
					else {
						die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
					}
				}
				else {
					die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
				}
			}
			else {
				die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
			}
		}
		else {
			die("Hubo un error al registrar los datos. Intente de nuevo, de lo contrario, por favor contáctenos a info@vanka.com.co");
		}
	}
	
	public function enviarCorreoCodeudor($uid) {
		$success = 1;
		
		//$uid = htmlspecialchars(Input::Any('uid'), ENT_QUOTES);
		$codebtorData = $this->db->getCodebtorData($uid);
		$id_deudor = $codebtorData->id_deudor;
		$debtorData = $this->db->getDebtorData($id_deudor);
		$res = $this->creditMailer->sendCodebtorMailToDebtor($codebtorData, $debtorData);
		if ($res == false) $success = 0;
		$res = $this->creditMailer->sendCodebtorMailToCodebtor($codebtorData, $debtorData);
		if ($res == false) $success = 0;
		return $success;
	}
	
	public function enviarCorreoCodeudorAdmin($uid) {
		$success = 1;
		
		$codebtorData = $this->db->getCodebtorData($uid);
		$id_deudor = $codebtorData->id_deudor;
		$res = $this->creditMailer->sendCodebtorMailToAdmin($codebtorData, $id_deudor);
		if ($res == false) $success = 0;
		
		return $success;
	}
	
	public function guardarSesion() {
		$codebtor = new Codebtor();
		$codebtor->guardarSesion();
	}
	
	public function guardarDatosTemporales() {
		$codebtor = new Codebtor();
		$codebtor->fromInput();
		$uid = htmlspecialchars(Input::Any('uid'), ENT_QUOTES);
		
		$id_deudor = $this->db->getIdDebtor($uid);
		
		echo $this->db->registerTempCodebtorData($uid, $id_deudor, $codebtor);
	}
	
	public function subirCedula($num_documento, $uid) {
		
		$consecutivo = $this->db->getCodebtorDocumentConsecutive($num_documento);
		
		//$filename = $_FILES['file']['name'];
		$filename = "documento_" . $num_documento . "_" . $consecutivo . "_" . date("Y_m_d_H_i_s");
		
		/* Location */
		$location = "Uploaded/DocumentoIdentidad/" . $filename;
		$uploadOk = 1;
		$imageFileType = pathinfo($_FILES['adjuntar_cedula']['name'], PATHINFO_EXTENSION);
		$location = $location . "." . $imageFileType;

		/* Valid Extensions */
		$valid_extensions = array("jpg","jpeg","png","pdf");
		/* Check file extension */
		if ( !in_array(strtolower($imageFileType),$valid_extensions) ) {
		   $uploadOk = 0;
		}

		if ($uploadOk == 0){
		   return 0;
		} else {
		   /* Upload file */
		   if (move_uploaded_file($_FILES['adjuntar_cedula']['tmp_name'], $location)){
			  $this->db->registerCodebtorDocument($location, $uid);
			  return $location;
		   } else {
			  return 0;
		   }
		}
	}

	public function subirEstadosFinancieros($id, $nit) {

		//$cantidad_estados_financieros = $_POST['cantidad_estados_financieros'];
		$cantidad_estados_financieros = count($_FILES['adjuntar_estados_financieros']['name']);

		for ($i = 0; $i < $cantidad_estados_financieros; $i++) {

			//$filename = $_FILES['file']['name'];
			$filename = "estados_financieros_" . $nit . "_" . $i . "_" . date("Y_m_d_H_i_s");

			/* Location */
			$location = "Uploaded/EstadosFinancieros/" . $filename;
			$uploadOk = 1;
			$imageFileType = pathinfo($_FILES['adjuntar_estados_financieros']['name'][$i], PATHINFO_EXTENSION);
			$location = $location . "." . $imageFileType;

			/* Valid Extensions */
			$valid_extensions = array("jpg","jpeg","png","pdf");
			/* Check file extension */
			if ( !in_array(strtolower($imageFileType),$valid_extensions) ) {
			   $uploadOk = 0;
			}

			if ($uploadOk == 0){
			   //return 0;
			} else {
			   /* Upload file */
			   if (move_uploaded_file($_FILES['adjuntar_estados_financieros']['tmp_name'][$i], $location)){
				  $this->db->registerFinancialStatement($location, $id, 1, $nit);
				  //return $location;
			   } else {
				  //return 0;
			   }
			}

		}
	}
	
	public function finalizarRegistro() {
		$uid = Input::Any('uid');
		$codebtorData = $this->db->getCodebtorSummary($uid);
		$id_deudor = $codebtorData->id_deudor;
		$debtorData = $this->db->getDebtorData($id_deudor);
		if ($debtorData->tipo_persona == "juridica") {
			$nombre_deudor = $debtorData->nombre_empresa;
		}
		else {
			$nombre_deudor = $debtorData->nombres . " " . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido;
		}
		new CodebtorSuccessView($id_deudor, $nombre_deudor);
	}
}
