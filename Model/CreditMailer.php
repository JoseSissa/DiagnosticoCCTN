<?php

namespace Model;

use Model\Mailer;

use Infinitesimal\Url;

class CreditMailer
{
	
	const ruta_logo = "https://drive.google.com/uc?export=download&id=1delFFGeY5UOrKJQp2D2DHLrEaxIKTxbM";
	
	public function __construct() {
	}

	public function getTemplateContents($url) {
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false); //Solo para entorno de pruebas
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
		  echo curl_error($ch);
		  echo "\n<br />";
		  $contents = '';
		} else {
		  curl_close($ch);
		}

		if (!is_string($contents) || !strlen($contents)) {
		echo "Failed to get contents.";
		$contents = '';
		}
		
		return $contents;
	}
	
	public function sendDebtorMailToAdmin($debtor) {
		$mailer = new Mailer();
		
		$asunto_correo = "Formulario deudor #" . $debtor->id . " - Vanka";
		$nombres = "";
		$celular = "";
		$correo = "";
		
		$num_radicado = $debtor->id;
		
		if ($debtor->tipo_persona == "juridica") {
			$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoDeudorAdminJuridica.html"));
			
			$nombres = $debtor->nombre_empresa;
			$celular = $debtor->celular_representante_legal;
			$correo = $debtor->correo_representante_legal;
			$cuerpo_correo = str_replace('%nit%', $debtor->nit, $cuerpo_correo);
		}
		else {
			$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoDeudorAdminNatural.html"));
			
			$nombres = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
			$celular = $debtor->celular;
			$correo = $debtor->correo;
			$cuerpo_correo = str_replace('%numero_identificacion%', $debtor->numero_identificacion, $cuerpo_correo);
		}
		
		$enlace_admin_deudor = "vanka.com.co/credito/abrir_formulario_deudor_anterior?num_radicado=" . $num_radicado;
		
		$cuerpo_correo = str_replace('%nombres%', mb_strtoupper($nombres, 'UTF-8'), $cuerpo_correo);
		$cuerpo_correo = str_replace('%celular%', $celular, $cuerpo_correo);
		$cuerpo_correo = str_replace('%correo%', $correo, $cuerpo_correo);
		$cuerpo_correo = str_replace('%enlace_admin_deudor%', $enlace_admin_deudor, $cuerpo_correo);
			
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);

		$res = $mailer->sendMail(explode(",", getenv('SCHEDULE_TO_EMAILS')), [], $asunto_correo, $cuerpo_correo);
		return $res;
	}
	
	public function sendDebtorMailToDebtor($debtor, $codebtors_summary) {
		$mailer = new Mailer();
		
		$asunto_correo = "Tu solicitud de crédito Vanka";
		$nombres = "";
		$correo = "";
		$enlace_codeudor = "https://www.vanka.com.co/credito/codeudor?uid=";
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoDeudorDeudor.html"));
		
		$num_radicado = $debtor->id;
		if ($debtor->tipo_persona == "juridica") {
			$correo = $debtor->correo_representante_legal;
			$nombres = $debtor->nombre_empresa;
		}
		else {
			$correo = $debtor->correo;
			$nombres = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$lista_codeudores = "";
		for ($i = 0; $i < count($codebtors_summary); $i++) {
			$lista_codeudores = $lista_codeudores . "<li><b>" . $codebtors_summary[$i]->nombres . "</b> - ". $enlace_codeudor . $codebtors_summary[$i]->uid . "</li>";
		}
		$cuerpo_correo = str_replace('%deudor%', mb_strtoupper($nombres, 'UTF-8'), $cuerpo_correo);
		$cuerpo_correo = str_replace('%lista_codeudores%', $lista_codeudores, $cuerpo_correo);
		$cuerpo_correo = str_replace('%num_radicado%', $num_radicado, $cuerpo_correo);
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		
		$res = $mailer->sendMail([ $correo ], explode(",", getenv('SCHEDULE_TO_EMAILS')), $asunto_correo, $cuerpo_correo);
		
		return $res;
	}
	
	public function sendDebtorMailToCodebtor($debtor, $codebtorSummary) {
		$mailer = new Mailer();
		
		$nombres = "";
		$enlace_codeudor = "https://www.vanka.com.co/credito/codeudor?uid=" . $codebtorSummary->uid;
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoDeudorCodeudor.html"));
		
		if ($debtor->tipo_persona == "juridica") {
			$nombres = $debtor->nombre_empresa;
		}
		else {
			$nombres = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$asunto_correo = $nombres . " solicitó un crédito a Vanka";
		
		$cuerpo_correo = str_replace('%deudor%', mb_strtoupper($nombres, 'UTF-8'), $cuerpo_correo);
		$cuerpo_correo = str_replace('%codeudor%', $codebtorSummary->nombres, $cuerpo_correo);
		$cuerpo_correo = str_replace('%enlace_codeudor%', $enlace_codeudor, $cuerpo_correo);
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		
		$res = $mailer->sendMail([ $codebtorSummary->correo ], explode(",", getenv('SCHEDULE_TO_EMAILS')), $asunto_correo, $cuerpo_correo);
		
		return $res;
	}
	
	public function sendNewCodebtorMailToDebtor($debtor, $codebtors_summary) {
		$mailer = new Mailer();
		
		$asunto_correo = "Nuevos codeudores añadidos a tu crédito Vanka";
		$nombres = "";
		$correo = "";
		$enlace_codeudor = "https://www.vanka.com.co/credito/codeudor?uid=";
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoNuevoCodeudorDeudor.html"));
		
		$num_radicado = $debtor->id;
		if ($debtor->tipo_persona == "juridica") {
			$correo = $debtor->correo_representante_legal;
			$nombres = $debtor->nombre_empresa;
		}
		else {
			$correo = $debtor->correo;
			$nombres = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$lista_codeudores = "";
		for ($i = 0; $i < count($codebtors_summary); $i++) {
			$lista_codeudores = $lista_codeudores . "<li><b>" . $codebtors_summary[$i]->nombres . "</b> - ". $enlace_codeudor . $codebtors_summary[$i]->uid . "</li>";
		}
		$cuerpo_correo = str_replace('%deudor%', mb_strtoupper($nombres, 'UTF-8'), $cuerpo_correo);
		$cuerpo_correo = str_replace('%lista_codeudores%', $lista_codeudores, $cuerpo_correo);
		$cuerpo_correo = str_replace('%num_radicado%', $num_radicado, $cuerpo_correo);
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		
		$res = $mailer->sendMail([ $correo ], explode(",", getenv('SCHEDULE_TO_EMAILS')), $asunto_correo, $cuerpo_correo);
		
		return $res;
	}
	
	public function sendNewCodebtorMailToAdmin($debtor, $codebtors_summary) {
		$mailer = new Mailer();
		
		$asunto_correo = "El deudor #" . $debtor->id . " ha registrado nuevos codeudores - Vanka";
		$nombres = "";
		$enlace_codeudor = "https://www.vanka.com.co/credito/codeudor?uid=";
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoNuevoCodeudorAdmin.html"));
		
		$num_radicado = $debtor->id;
		if ($debtor->tipo_persona == "juridica") {
			$nombres = $debtor->nombre_empresa;
		}
		else {
			$nombres = $debtor->nombres . " " . $debtor->primer_apellido . " " . $debtor->segundo_apellido;
		}
		
		$cuerpo_correo = str_replace('%nombres%', mb_strtoupper($nombres, 'UTF-8'), $cuerpo_correo);
		$cuerpo_correo = str_replace('%num_radicado%', $num_radicado, $cuerpo_correo);
		
		$lista_codeudores = "";
		for ($i = 0; $i < count($codebtors_summary); $i++) {
			$lista_codeudores = $lista_codeudores . "<li><b>" . $codebtors_summary[$i]->nombres . "</b> - ". $enlace_codeudor . $codebtors_summary[$i]->uid . "</li>";
		}
		$cuerpo_correo = str_replace('%lista_codeudores%', $lista_codeudores, $cuerpo_correo);
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);

		$res = $mailer->sendMail(explode(",", getenv('SCHEDULE_TO_EMAILS')), [], $asunto_correo, $cuerpo_correo);
		return $res;
	}
	
	public function sendCodebtorMailToAdmin($codebtorData, $id_deudor) {
		$mailer = new Mailer();
		
		$asunto_correo = "Formulario codeudor #" . $id_deudor . " - Vanka";
		
		$enlace_admin_codeudor = "vanka.com.co/credito/abrir_formulario_codeudor_anterior?uid=" . $codebtorData->uid;
		
		$datos_deudor = json_decode($codebtorData->datos_deudor);
		
		if ($codebtorData->tipo_persona == "juridica") {
			$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
			$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
			
			$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoCodeudorAdminPersonaJuridica.html"));
			$cuerpo_correo = str_replace('%id_deudor%', $codebtorData->id_deudor, $cuerpo_correo);			
			$cuerpo_correo = str_replace('%solicitante%', mb_strtoupper($datos_deudor->nombre_empresa, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%nombre_empresa%', mb_strtoupper($codebtorData->nombre_empresa, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%celular%', $codebtorData->celular_representante_legal, $cuerpo_correo);
			$cuerpo_correo = str_replace('%correo_representante_legal%', $codebtorData->correo_representante_legal, $cuerpo_correo);
			$cuerpo_correo = str_replace('%numero_contacto_empresa%', $codebtorData->numero_contacto_empresa, $cuerpo_correo);
			$cuerpo_correo = str_replace('%enlace_admin_codeudor%', $enlace_admin_codeudor, $cuerpo_correo);
			$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		}
		else {
			$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
			$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
			
			$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoCodeudorAdminPersonaNatural.html"));
			$cuerpo_correo = str_replace('%id_deudor%', $codebtorData->id_deudor, $cuerpo_correo);
			$cuerpo_correo = str_replace('%solicitante%', mb_strtoupper($datos_deudor->nombres . " " . $datos_deudor->primer_apellido . " " . $datos_deudor->segundo_apellido, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%nombres%', mb_strtoupper($codebtorData->nombres, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%primer_apellido%', mb_strtoupper($codebtorData->primer_apellido, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%segundo_apellido%', mb_strtoupper($codebtorData->segundo_apellido, 'UTF-8'), $cuerpo_correo);
			$cuerpo_correo = str_replace('%celular%', $codebtorData->celular, $cuerpo_correo);
			$cuerpo_correo = str_replace('%correo%', $codebtorData->correo, $cuerpo_correo);
			$cuerpo_correo = str_replace('%numero_identificacion%', $codebtorData->numero_identificacion, $cuerpo_correo);
			$cuerpo_correo = str_replace('%enlace_admin_codeudor%', $enlace_admin_codeudor, $cuerpo_correo);
			$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		}
		
		$res = $mailer->sendMail(explode(",", getenv('SCHEDULE_TO_EMAILS')), [], $asunto_correo, $cuerpo_correo);
		return $res;
	}
	
	public function sendCodebtorMailToDebtor($codebtorData, $debtorData) {
		$mailer = new Mailer();
		
		$asunto_correo = "Solicitud de crédito completada - Vanka";
		
		$correo = "";
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoCodeudorDeudor.html"));
		
		if ($codebtorData->tipo_persona == "juridica") {
			$cuerpo_correo = str_replace('%nombre_codeudor%', mb_strtoupper($codebtorData->nombre_empresa, 'UTF-8'), $cuerpo_correo);
		}
		else {
			$cuerpo_correo = str_replace('%nombre_codeudor%', mb_strtoupper($codebtorData->nombres . " " . $codebtorData->primer_apellido . " " . $codebtorData->segundo_apellido, 'UTF-8'), $cuerpo_correo);
		}
		
		if ($debtorData->tipo_persona == "juridica") {
			$correo = $debtorData->correo_representante_legal;
			$cuerpo_correo = str_replace('%nombre_deudor%', mb_strtoupper($debtorData->nombre_empresa, 'UTF-8'), $cuerpo_correo);
		}
		else {
			$correo = $debtorData->correo;
			$cuerpo_correo = str_replace('%nombre_deudor%', mb_strtoupper($debtorData->nombres . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido, 'UTF-8'), $cuerpo_correo);
		}
			
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		
		$res = $mailer->sendMail([ $correo ], explode(",", getenv('SCHEDULE_TO_EMAILS')), $asunto_correo, $cuerpo_correo);
		
		return $res;
	}
	
	public function sendCodebtorMailToCodebtor($codebtorData, $debtorData) {
		$mailer = new Mailer();
		
		$correo = "";
		
		$asunto_correo = "Solicitud de crédito completada - Vanka";
		
		$firma_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaFirmaCorreo.html"));
		$firma_correo = str_replace('%ruta_logo%', self::ruta_logo, $firma_correo);
		
		$cuerpo_correo = $this->getTemplateContents(Url::Get("/Templates/PlantillaCorreoCodeudorCodeudor.html"));
		
		if ($codebtorData->tipo_persona == "juridica") {
			$correo = $codebtorData->correo_representante_legal;
			$cuerpo_correo = str_replace('%nombre_codeudor%', mb_strtoupper($codebtorData->nombre_empresa, 'UTF-8'), $cuerpo_correo);
		}
		else {
			$correo = $codebtorData->correo;
			$cuerpo_correo = str_replace('%nombre_codeudor%', mb_strtoupper($codebtorData->nombres . " " . $codebtorData->primer_apellido . " " . $codebtorData->segundo_apellido, 'UTF-8'), $cuerpo_correo);
		}
		
		if ($debtorData->tipo_persona == "juridica") {
			//$asunto_correo = "Vanka S.A.S: Tu registro como codeudor de " . $debtorData->nombre_empresa . " ha sido guardado";
			$cuerpo_correo = str_replace('%nombre_deudor%', mb_strtoupper($debtorData->nombre_empresa, 'UTF-8'), $cuerpo_correo);
		}
		else {
			//$asunto_correo = "Vanka S.A.S: Tu registro como codeudor de " . $debtorData->nombres . " " . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido . " ha sido guardado";
			$cuerpo_correo = str_replace('%nombre_deudor%', mb_strtoupper($debtorData->nombres . " " . $debtorData->primer_apellido . " " . $debtorData->segundo_apellido, 'UTF-8'), $cuerpo_correo);
		}
		
		$cuerpo_correo = str_replace('%html_firma%', $firma_correo, $cuerpo_correo);
		
		$res = $mailer->sendMail([ $correo ], explode(",", getenv('SCHEDULE_TO_EMAILS')), $asunto_correo, $cuerpo_correo);
		return $res;
	}
	
}