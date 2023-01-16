<?php

namespace Controllers;

use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Input;
use Infinitesimal\Url;
use Model\Debtor;
use Model\CreditMailer;
use Model\Database;
use Model\SpreadsheetExporter;
use Views\AdminView;

class AdminController
{
	private $db;
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function openAdminPanel() {
		new AdminView();
	}
	
	public function exportar() {
		error_reporting(0);
		$debtorsData = $this->db->getDebtorsData();
		$codebtorsData = $this->db->getCodebtorsData();
		$se = new SpreadsheetExporter();
		$se->exportAdminList($debtorsData, $codebtorsData);
	}
	
	public function exportarTemporales() {
		error_reporting(0);
		$debtorsData = $this->db->getTempDebtorsData();
		$codebtorsData = $this->db->getTempCodebtorsData();
		$se = new SpreadsheetExporter();
		$se->exportAdminTempList($debtorsData, $codebtorsData);
	}
}