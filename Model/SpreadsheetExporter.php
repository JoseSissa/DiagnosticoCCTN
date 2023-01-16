<?php

namespace Model;

use Exception;
use Infinitesimal\Url;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Style;

class SpreadsheetExporter
{
	public function __construct()
    {
    }
	
	public function exportAdminList($debtorData, $codebtorData)
	{
		if (!is_array($debtorData)) {
			$debtorData = [];
		}
		if (!is_array($codebtorData)) {
			$codebtorData = [];
		}
		
		$inputFileType = "Xlsx";
		$inputFileName = "Templates/PlantillaClientes.xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$spreadsheet->setActiveSheetIndexByName('Base');
		$worksheet = $spreadsheet->getActiveSheet();
		
		$ultima_fila_vehiculos = 0;
		$ultima_fila_inmuebles = 0;
		$ultima_fila_empleados = 0;
		$ultima_fila_independientes = 0;
		
		for ($i = 0; $i < count($debtorData); $i++)
		{
			$worksheet->setCellValue('A' . ($i + 3), $debtorData[$i]->id);
			$worksheet->setCellValue('B' . ($i + 3), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
			$worksheet->setCellValue('C' . ($i + 3), $debtorData[$i]->referido);
			$worksheet->setCellValue('D' . ($i + 3), "vanka.com.co/credito/abrir_formulario_deudor_anterior?num_radicado=" . $debtorData[$i]->id);
			$worksheet->getCell('D' . ($i + 3))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_deudor_anterior?num_radicado=' . $debtorData[$i]->id);
			$worksheet->setCellValue('E' . ($i + 3), $debtorData[$i]->numero_identificacion);
			$worksheet->setCellValue('F' . ($i + 3), "");
			$worksheet->setCellValue('G' . ($i + 3), $debtorData[$i]->correo);
			$worksheet->setCellValue('H' . ($i + 3), $debtorData[$i]->celular);
			$worksheet->setCellValue('I' . ($i + 3), "DEUDOR");
			$worksheet->setCellValue('J' . ($i + 3), "");
			$worksheet->setCellValue('K' . ($i + 3), $debtorData[$i]->valor_solicitado);
			$worksheet->setCellValue('L' . ($i + 3), $debtorData[$i]->plazo);
			$worksheet->setCellValue('M' . ($i + 3), $debtorData[$i]->fecha_nacimiento);
			$worksheet->setCellValue('N' . ($i + 3), "");
			$worksheet->setCellValue('O' . ($i + 3), "");
			$worksheet->setCellValue('P' . ($i + 3), "");
			$worksheet->setCellValue('Q' . ($i + 3), "");
			$worksheet->setCellValue('R' . ($i + 3), 'vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $debtorData[$i]->adjunto_cedula));
			$worksheet->getCell('R' . ($i + 3))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $debtorData[$i]->adjunto_cedula));
			
			if (!is_array($debtorData[$i]->estados_financieros)) {
				$debtorData[$i]->estados_financieros = [];
			}
			for ($j = 0; $j < count($debtorData[$i]->estados_financieros); $j++) {
				$worksheet->setCellValue('S' . ($i + 3), $worksheet->getCell('S' . ($i + 3))->getValue() . 'vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $debtorData[$i]->estados_financieros[$j]) . "\n");
			}
			
			$worksheet->setCellValue('T' . ($i + 3), $debtorData[$i]->informacion_financiera_ingresos);
			$worksheet->setCellValue('U' . ($i + 3), $debtorData[$i]->informacion_financiera_activos);
			$worksheet->setCellValue('V' . ($i + 3), $debtorData[$i]->informacion_financiera_por_cobrar);
			$worksheet->setCellValue('W' . ($i + 3), $debtorData[$i]->informacion_financiera_egresos);
			$worksheet->setCellValue('X' . ($i + 3), $debtorData[$i]->informacion_financiera_pasivos);
			$worksheet->setCellValue('Y' . ($i + 3), $debtorData[$i]->informacion_financiera_por_pagar);
			$worksheet->setCellValue('Z' . ($i + 3), $debtorData[$i]->informacion_financiera_utilidad);
			$worksheet->setCellValue('AA' . ($i + 3), $debtorData[$i]->informacion_financiera_patrimonio);
            //$worksheet->setCellValue('AB' . ($i + 3), $debtorData[$i]->informacion_financiera_fecha); POR IMPLEMENTAR
			$worksheet->setCellValue('AB' . ($i + 3), $debtorData[$i]->tipo_persona);
			$worksheet->setCellValue('AC' . ($i + 3), $debtorData[$i]->destino_credito);
			$worksheet->setCellValue('AD' . ($i + 3), $debtorData[$i]->tipo_identificacion);
			$worksheet->setCellValue('AE' . ($i + 3), $debtorData[$i]->ciudad);
			$worksheet->setCellValue('AF' . ($i + 3), $debtorData[$i]->barrio);
			$worksheet->setCellValue('AG' . ($i + 3), $debtorData[$i]->departamento);
			$worksheet->setCellValue('AH' . ($i + 3), $debtorData[$i]->telefono);
			$worksheet->setCellValue('AI' . ($i + 3), $debtorData[$i]->estado_civil);
			$worksheet->setCellValue('AJ' . ($i + 3), $debtorData[$i]->tipo_vivienda);
			$worksheet->setCellValue('AK' . ($i + 3), $debtorData[$i]->estrato);
			$worksheet->setCellValue('AL' . ($i + 3), $debtorData[$i]->personas_a_cargo);
			$worksheet->setCellValue('AM' . ($i + 3), $debtorData[$i]->nombre_apellido_conyuge);
			$worksheet->setCellValue('AN' . ($i + 3), $debtorData[$i]->celular_conyuge);
			$worksheet->setCellValue('AO' . ($i + 3), $debtorData[$i]->ciudad_conyuge);
			$worksheet->setCellValue('AP' . ($i + 3), $debtorData[$i]->nombre_empresa);
			$worksheet->setCellValue('AQ' . ($i + 3), $debtorData[$i]->nit);
			//$worksheet->setCellValue('AR' . ($i + 3), $debtorData[$i]->razon_social_empresa);
			$worksheet->setCellValue('AS' . ($i + 3), $debtorData[$i]->direccion_empresa);
			$worksheet->setCellValue('AT' . ($i + 3), $debtorData[$i]->ciudad_empresa);
			$worksheet->setCellValue('AU' . ($i + 3), $debtorData[$i]->numero_contacto_empresa);
			$worksheet->setCellValue('AV' . ($i + 3), $debtorData[$i]->actividad_economica_empresa);
			$worksheet->setCellValue('AW' . ($i + 3), $debtorData[$i]->pagina_web_empresa);
			$worksheet->setCellValue('AX' . ($i + 3), $debtorData[$i]->antiguedad_empresa);
			$worksheet->setCellValue('AY' . ($i + 3), $debtorData[$i]->nombres_representante_legal . " " . $debtorData[$i]->primer_apellido_representante_legal . " " . $debtorData[$i]->segundo_apellido_representante_legal);
			$worksheet->setCellValue('AZ' . ($i + 3), $debtorData[$i]->tipo_identificacion_representante_legal);
			$worksheet->setCellValue('BA' . ($i + 3), $debtorData[$i]->numero_identificacion_representante_legal);
			$worksheet->setCellValue('BB' . ($i + 3), $debtorData[$i]->correo_representante_legal);
			$worksheet->setCellValue('BC' . ($i + 3), $debtorData[$i]->ciudad_representante_legal);
			$worksheet->setCellValue('BD' . ($i + 3), $debtorData[$i]->departamento_representante_legal);
			$worksheet->setCellValue('BE' . ($i + 3), $debtorData[$i]->direccion_representante_legal);
			$worksheet->setCellValue('BF' . ($i + 3), $debtorData[$i]->celular_representante_legal);
			$worksheet->setCellValue('BG' . ($i + 3), $debtorData[$i]->honorarios);
			$worksheet->setCellValue('BH' . ($i + 3), $debtorData[$i]->comisiones);
			$worksheet->setCellValue('BI' . ($i + 3), $debtorData[$i]->otros_ingresos);
			$worksheet->setCellValue('BJ' . ($i + 3), $debtorData[$i]->arriendo_vivienda);
			$worksheet->setCellValue('BK' . ($i + 3), $debtorData[$i]->gasto_personal_familiar);
			$worksheet->setCellValue('BL' . ($i + 3), $debtorData[$i]->cuotas_creditos);
			$worksheet->setCellValue('BM' . ($i + 3), $debtorData[$i]->conyuge_ingresos_mensuales);
			$worksheet->setCellValue('BN' . ($i + 3), $debtorData[$i]->conyuge_gastos_mensuales);
			$worksheet->setCellValue('BO' . ($i + 3), $debtorData[$i]->conyuge_obligaciones);
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$vehiculos_deudor = json_decode($debtorData[$i]->vehiculos);
			if (!is_array($vehiculos_deudor)) {
				$vehiculos_deudor = [];
			}
			$worksheet->setCellValue('BP' . ($i + 3), strval(count($vehiculos_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Vehiculos');
			$worksheet = $spreadsheet->getActiveSheet();
						
			for ($j = 0; $j < count($vehiculos_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_vehiculos), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_vehiculos), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_vehiculos), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->placa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->prenda);
				//$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->deuda);
				$ultima_fila_vehiculos++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$inmuebles_deudor = json_decode($debtorData[$i]->inmuebles);
			if (!is_array($inmuebles_deudor)) {
				$inmuebles_deudor = [];
			}
			$worksheet->setCellValue('BQ' . ($i + 3), strval(count($inmuebles_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Propiedades');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($inmuebles_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_inmuebles), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_inmuebles), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_inmuebles), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->tipo_inmueble);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->hipoteca);
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->porcentaje_propiedad);
				$ultima_fila_inmuebles++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$empleados_deudor = json_decode($debtorData[$i]->empleados);
			if (!is_array($empleados_deudor)) {
				$empleados_deudor = [];
			}
			$worksheet->setCellValue('BR' . ($i + 3), strval(count($empleados_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Empleados');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($empleados_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_empleados), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_empleados), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_empleados), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->sector);
				switch($empleados_deudor[$j]->antiguedad_empleo) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->tipo_contrato);
				$worksheet->setCellValue('H' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->duracion);
				$worksheet->setCellValue('I' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->duracion_cantidad);
				$ultima_fila_empleados++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$independientes_deudor = json_decode($debtorData[$i]->independientes);
			if (!is_array($independientes_deudor)) {
				$independientes_deudor = [];
			}
			$worksheet->setCellValue('BS' . ($i + 3), strval(count($independientes_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Independientes');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($independientes_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_independientes), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_independientes), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_independientes), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->sector);
				switch($independientes_deudor[$j]->antiguedad_independiente) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->ocupacion);
				$ultima_fila_independientes++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
		}
		
		for ($i = 0; $i < count($codebtorData); $i++)
		{
			$worksheet->setCellValue('A' . ($i + 3 + count($debtorData)), $codebtorData[$i]->id_deudor);
			$worksheet->setCellValue('B' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
			$worksheet->setCellValue('C' . ($i + 3 + count($debtorData)), $codebtorData[$i]->referido);
			$worksheet->setCellValue('D' . ($i + 3 + count($debtorData)), "vanka.com.co/credito/abrir_formulario_codeudor_anterior?uid=" . $codebtorData[$i]->resumen->uid);
			$worksheet->getCell('D' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_codeudor_anterior?uid=' . $codebtorData[$i]->resumen->uid);
			$worksheet->setCellValue('E' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_identificacion);
			$worksheet->setCellValue('F' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('G' . ($i + 3 + count($debtorData)), $codebtorData[$i]->correo);
			$worksheet->setCellValue('H' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular);
			$worksheet->setCellValue('I' . ($i + 3 + count($debtorData)), "CODEUDOR");
			$worksheet->setCellValue('J' . ($i + 3 + count($debtorData)), $codebtorData[$i]->id_deudor);
			$worksheet->setCellValue('K' . ($i + 3 + count($debtorData)), $codebtorData[$i]->valor_solicitado);
			$worksheet->setCellValue('L' . ($i + 3 + count($debtorData)), $codebtorData[$i]->plazo);
			$worksheet->setCellValue('M' . ($i + 3 + count($debtorData)), $codebtorData[$i]->fecha_nacimiento);
			$worksheet->setCellValue('N' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('O' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('P' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('Q' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('R' . ($i + 3 + count($debtorData)), 'vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->adjunto_cedula));
			$worksheet->getCell('R' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->adjunto_cedula));
			if (!is_array($codebtorData[$i]->estados_financieros)) {
				$codebtorData[$i]->estados_financieros = [];
			}
			for ($j = 0; $j < count($codebtorData[$i]->estados_financieros); $j++) {
				$worksheet->setCellValue('S' . ($i + 3 + count($debtorData)), $worksheet->getCell('S' . ($i + 3 + count($debtorData)))->getValue() . 'vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->estados_financieros[$j]) . "\n");
			}
			$worksheet->setCellValue('T' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_ingresos);
			$worksheet->setCellValue('U' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_activos);
			$worksheet->setCellValue('V' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_por_cobrar);
			$worksheet->setCellValue('W' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_egresos);
			$worksheet->setCellValue('X' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_pasivos);
			$worksheet->setCellValue('Y' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_por_pagar);
			$worksheet->setCellValue('Z' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_utilidad);
			$worksheet->setCellValue('AA' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_patrimonio);
            //$worksheet->setCellValue('AB' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_patrimonio); POR IMPLEMENTAR
			$worksheet->setCellValue('AB' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_persona);
			$worksheet->setCellValue('AC' . ($i + 3 + count($debtorData)), $codebtorData[$i]->destino_credito);
			$worksheet->setCellValue('AD' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_identificacion);
			$worksheet->setCellValue('AE' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad);
			$worksheet->setCellValue('AF' . ($i + 3 + count($debtorData)), $codebtorData[$i]->barrio);
			$worksheet->setCellValue('AG' . ($i + 3 + count($debtorData)), $codebtorData[$i]->departamento);
			$worksheet->setCellValue('AH' . ($i + 3 + count($debtorData)), $codebtorData[$i]->telefono);
			$worksheet->setCellValue('AI' . ($i + 3 + count($debtorData)), $codebtorData[$i]->estado_civil);
			$worksheet->setCellValue('AJ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_vivienda);
			$worksheet->setCellValue('AK' . ($i + 3 + count($debtorData)), $codebtorData[$i]->estrato);
			$worksheet->setCellValue('AL' . ($i + 3 + count($debtorData)), $codebtorData[$i]->personas_a_cargo);
			$worksheet->setCellValue('AM' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombre_apellido_conyuge);
			$worksheet->setCellValue('AN' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular_conyuge);
			$worksheet->setCellValue('AO' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_conyuge);
			$worksheet->setCellValue('AP' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombre_empresa);
			$worksheet->setCellValue('AQ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nit);
			//$worksheet->setCellValue('AR' . ($i + 3 + count($debtorData)), $codebtorData[$i]->razon_social_empresa);
			$worksheet->setCellValue('AS' . ($i + 3 + count($debtorData)), $codebtorData[$i]->direccion_empresa);
			$worksheet->setCellValue('AT' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_empresa);
			$worksheet->setCellValue('AU' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_contacto_empresa);
			$worksheet->setCellValue('AV' . ($i + 3 + count($debtorData)), $codebtorData[$i]->actividad_economica_empresa);
			$worksheet->setCellValue('AW' . ($i + 3 + count($debtorData)), $codebtorData[$i]->pagina_web_empresa);
			$worksheet->setCellValue('AX' . ($i + 3 + count($debtorData)), $codebtorData[$i]->antiguedad_empresa);
			$worksheet->setCellValue('AY' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombres_representante_legal . " " . $codebtorData[$i]->primer_apellido_representante_legal . " " . $codebtorData[$i]->segundo_apellido_representante_legal);
			$worksheet->setCellValue('AZ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_identificacion_representante_legal);
			$worksheet->setCellValue('BA' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_identificacion_representante_legal);
			$worksheet->setCellValue('BB' . ($i + 3 + count($debtorData)), $codebtorData[$i]->correo_representante_legal);
			$worksheet->setCellValue('BC' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_representante_legal);
			$worksheet->setCellValue('BD' . ($i + 3 + count($debtorData)), $codebtorData[$i]->departamento_representante_legal);
			$worksheet->setCellValue('BE' . ($i + 3 + count($debtorData)), $codebtorData[$i]->direccion_representante_legal);
			$worksheet->setCellValue('BF' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular_representante_legal);
			$worksheet->setCellValue('BG' . ($i + 3 + count($debtorData)), $codebtorData[$i]->honorarios);
			$worksheet->setCellValue('BH' . ($i + 3 + count($debtorData)), $codebtorData[$i]->comisiones);
			$worksheet->setCellValue('BI' . ($i + 3 + count($debtorData)), $codebtorData[$i]->otros_ingresos);
			$worksheet->setCellValue('BJ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->arriendo_vivienda);
			$worksheet->setCellValue('BK' . ($i + 3 + count($debtorData)), $codebtorData[$i]->gasto_personal_familiar);
			$worksheet->setCellValue('BL' . ($i + 3 + count($debtorData)), $codebtorData[$i]->cuotas_creditos);
			$worksheet->setCellValue('BM' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_ingresos_mensuales);
			$worksheet->setCellValue('BN' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_gastos_mensuales);
			$worksheet->setCellValue('BO' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_obligaciones);
			$worksheet->setCellValue('BT' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->nombres);
			$worksheet->setCellValue('BU' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->celular);
			$worksheet->setCellValue('BV' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->correo);
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$vehiculos_codeudor = json_decode($codebtorData[$i]->vehiculos);
			if (!is_array($vehiculos_codeudor)) {
				$vehiculos_codeudor = [];
			}
			$worksheet->setCellValue('BP' . ($i + 3 + count($debtorData)), strval(count($vehiculos_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Vehiculos');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($vehiculos_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_vehiculos), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_vehiculos), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_vehiculos), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->placa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->prenda);
				//$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->deuda);
				$ultima_fila_vehiculos++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$inmuebles_codeudor = json_decode($codebtorData[$i]->inmuebles);
			if (!is_array($inmuebles_codeudor)) {
				$inmuebles_codeudor = [];
			}
			$worksheet->setCellValue('BQ' . ($i + 3 + count($debtorData)), strval(count($inmuebles_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Propiedades');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($inmuebles_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_inmuebles), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_inmuebles), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_inmuebles), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->tipo_inmueble);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->hipoteca);
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->porcentaje_propiedad);
				$ultima_fila_inmuebles++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$empleados_codeudor = json_decode($codebtorData[$i]->empleados);
			if (!is_array($empleados_codeudor)) {
				$empleados_codeudor = [];
			}
			$worksheet->setCellValue('BR' . ($i + 3 + count($debtorData)), strval(count($empleados_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Empleados');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($empleados_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_empleados), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_empleados), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_empleados), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->sector);
				switch($empleados_codeudor[$j]->antiguedad_empleo) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->tipo_contrato);
				$worksheet->setCellValue('H' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->duracion);
				$worksheet->setCellValue('I' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->duracion_cantidad);
				$ultima_fila_empleados++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$independientes_codeudor = json_decode($codebtorData[$i]->independientes);
			if (!is_array($independientes_codeudor)) {
				$independientes_codeudor = [];
			}
			$worksheet->setCellValue('BS' . ($i + 3 + count($debtorData)), strval(count($independientes_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Independientes');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($independientes_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_independientes), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_independientes), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_independientes), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->sector);
				switch($independientes_codeudor[$j]->antiguedad_independiente) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->ocupacion);
				$ultima_fila_independientes++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
		}
		
		//SORTING
		$data = $worksheet->rangeToArray("A3:BV" . count($debtorData) + 2 + count($codebtorData));
		usort($data, array($this, "cmp"));
		
		//$y = 1;
		//$z = 3;
		
		for($j = 0; $j < count($data); $j++) {
			$worksheet->removeRow(3);
		}
		
		for($i = 1; $i < 75; $i++) {
			for($j = 3; $j < count($data) + 3; $j++) {
				$worksheet->setCellValueByColumnAndRow($i, $j, $data[$j-3][$i-1]);
			}
		}
		
		/*foreach ($data as $cell) {
			$worksheet->removeRow($z);
			$worksheet->insertNewRowBefore($z);
			foreach ($cell as $finalValue) {
				$worksheet->setCellValueByColumnAndRow($y, $z, $finalValue);
				$y++;
			}
			$z++;
		}*/
		
		for ($i = 0; $i < count($debtorData); $i++)
		{
			$worksheet->getCell('D' . ($i + 3))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_deudor_anterior?num_radicado=' . $debtorData[$i]->id);
			$worksheet->getCell('R' . ($i + 3))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $debtorData[$i]->adjunto_cedula));
		}
		
		for ($i = 0; $i < count($codebtorData); $i++)
		{
			$worksheet->getCell('D' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_codeudor_anterior?uid=' . $codebtorData[$i]->resumen->uid);
			$worksheet->getCell('R' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->adjunto_cedula));
		}
		
		//BOLD DEBTOR
		$worksheet->getStyle("A3:BV" . count($debtorData) + 2)->getFont()->setBold(true);
		
		$filename = "informe_clientes.xlsx";
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, $inputFileType);
		
		header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-dispoSition: attachment; filename=" . $filename);
		
		$writer->save('php://output');
		
		exit;
		
	}
	
	public function cmp($a, $b)
	{
		if ($a[0] == $b[0]) {
			return 0;
		}
		return ($a[0] < $b[0]) ? -1 : 1;
	}
	
	public function exportAdminTempList($debtorData, $codebtorData)
	{
		if (!is_array($debtorData)) {
			$debtorData = [];
		}
		if (!is_array($codebtorData)) {
			$codebtorData = [];
		}
		
		$inputFileType = "Xlsx";
		$inputFileName = "Templates/PlantillaClientes.xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		$spreadsheet = $reader->load($inputFileName);
		$spreadsheet->setActiveSheetIndexByName('Base');
		$worksheet = $spreadsheet->getActiveSheet();
		
		$ultima_fila_vehiculos = 0;
		$ultima_fila_inmuebles = 0;
		$ultima_fila_empleados = 0;
		$ultima_fila_independientes = 0;
		
		$worksheet->getStyle("A3:BV" . count($debtorData) + 2)->getFont()->setBold(true);
		
		for ($i = 0; $i < count($debtorData); $i++)
		{
			$worksheet->setCellValue('A' . ($i + 3), $debtorData[$i]->id);
			$worksheet->setCellValue('B' . ($i + 3), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
			$worksheet->setCellValue('C' . ($i + 3), $debtorData[$i]->referido);
			$worksheet->setCellValue('D' . ($i + 3), "vanka.com.co/credito/abrir_formulario_deudor_temporal_anterior?id=" . $debtorData[$i]->id);
			$worksheet->getCell('D' . ($i + 3))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_deudor_temporal_anterior?id=' . $debtorData[$i]->id);
			$worksheet->setCellValue('E' . ($i + 3), $debtorData[$i]->numero_identificacion);
			$worksheet->setCellValue('F' . ($i + 3), "");
			$worksheet->setCellValue('G' . ($i + 3), $debtorData[$i]->correo);
			$worksheet->setCellValue('H' . ($i + 3), $debtorData[$i]->celular);
			$worksheet->setCellValue('I' . ($i + 3), "DEUDOR");
			$worksheet->setCellValue('J' . ($i + 3), "");
			$worksheet->setCellValue('K' . ($i + 3), $debtorData[$i]->valor_solicitado);
			$worksheet->setCellValue('L' . ($i + 3), $debtorData[$i]->plazo);
			$worksheet->setCellValue('M' . ($i + 3), $debtorData[$i]->fecha_nacimiento);
			$worksheet->setCellValue('N' . ($i + 3), "");
			$worksheet->setCellValue('O' . ($i + 3), "");
			$worksheet->setCellValue('P' . ($i + 3), "");
			$worksheet->setCellValue('Q' . ($i + 3), "");
			
			$worksheet->setCellValue('T' . ($i + 3), $debtorData[$i]->informacion_financiera_ingresos);
			$worksheet->setCellValue('U' . ($i + 3), $debtorData[$i]->informacion_financiera_activos);
			$worksheet->setCellValue('V' . ($i + 3), $debtorData[$i]->informacion_financiera_por_cobrar);
			$worksheet->setCellValue('W' . ($i + 3), $debtorData[$i]->informacion_financiera_egresos);
			$worksheet->setCellValue('X' . ($i + 3), $debtorData[$i]->informacion_financiera_pasivos);
			$worksheet->setCellValue('Y' . ($i + 3), $debtorData[$i]->informacion_financiera_por_pagar);
			$worksheet->setCellValue('Z' . ($i + 3), $debtorData[$i]->informacion_financiera_utilidad);
			$worksheet->setCellValue('AA' . ($i + 3), $debtorData[$i]->informacion_financiera_patrimonio);
            //$worksheet->setCellValue('AB' . ($i + 3), $debtorData[$i]->informacion_financiera_patrimonio); POR IMPLEMENTAR
			$worksheet->setCellValue('AB' . ($i + 3), $debtorData[$i]->tipo_persona);
			$worksheet->setCellValue('AC' . ($i + 3), $debtorData[$i]->destino_credito);
			$worksheet->setCellValue('AD' . ($i + 3), $debtorData[$i]->tipo_identificacion);
			$worksheet->setCellValue('AE' . ($i + 3), $debtorData[$i]->ciudad);
			$worksheet->setCellValue('AF' . ($i + 3), $debtorData[$i]->barrio);
			$worksheet->setCellValue('AG' . ($i + 3), $debtorData[$i]->departamento);
			$worksheet->setCellValue('AH' . ($i + 3), $debtorData[$i]->telefono);
			$worksheet->setCellValue('AI' . ($i + 3), $debtorData[$i]->estado_civil);
			$worksheet->setCellValue('AJ' . ($i + 3), $debtorData[$i]->tipo_vivienda);
			$worksheet->setCellValue('AK' . ($i + 3), $debtorData[$i]->estrato);
			$worksheet->setCellValue('AL' . ($i + 3), $debtorData[$i]->personas_a_cargo);
			$worksheet->setCellValue('AM' . ($i + 3), $debtorData[$i]->nombre_apellido_conyuge);
			$worksheet->setCellValue('AN' . ($i + 3), $debtorData[$i]->celular_conyuge);
			$worksheet->setCellValue('AO' . ($i + 3), $debtorData[$i]->ciudad_conyuge);
			$worksheet->setCellValue('AP' . ($i + 3), $debtorData[$i]->nombre_empresa);
			$worksheet->setCellValue('AQ' . ($i + 3), $debtorData[$i]->nit);
			//$worksheet->setCellValue('AR' . ($i + 3), $debtorData[$i]->razon_social_empresa);
			$worksheet->setCellValue('AS' . ($i + 3), $debtorData[$i]->direccion_empresa);
			$worksheet->setCellValue('AT' . ($i + 3), $debtorData[$i]->ciudad_empresa);
			$worksheet->setCellValue('AU' . ($i + 3), $debtorData[$i]->numero_contacto_empresa);
			$worksheet->setCellValue('AV' . ($i + 3), $debtorData[$i]->actividad_economica_empresa);
			$worksheet->setCellValue('AW' . ($i + 3), $debtorData[$i]->pagina_web_empresa);
			$worksheet->setCellValue('AX' . ($i + 3), $debtorData[$i]->antiguedad_empresa);
			$worksheet->setCellValue('AY' . ($i + 3), $debtorData[$i]->nombres_representante_legal . " " . $debtorData[$i]->primer_apellido_representante_legal . " " . $debtorData[$i]->segundo_apellido_representante_legal);
			$worksheet->setCellValue('AZ' . ($i + 3), $debtorData[$i]->tipo_identificacion_representante_legal);
			$worksheet->setCellValue('BA' . ($i + 3), $debtorData[$i]->numero_identificacion_representante_legal);
			$worksheet->setCellValue('BB' . ($i + 3), $debtorData[$i]->correo_representante_legal);
			$worksheet->setCellValue('BC' . ($i + 3), $debtorData[$i]->ciudad_representante_legal);
			$worksheet->setCellValue('BD' . ($i + 3), $debtorData[$i]->departamento_representante_legal);
			$worksheet->setCellValue('BE' . ($i + 3), $debtorData[$i]->direccion_representante_legal);
			$worksheet->setCellValue('BF' . ($i + 3), $debtorData[$i]->celular_representante_legal);
			$worksheet->setCellValue('BG' . ($i + 3), $debtorData[$i]->honorarios);
			$worksheet->setCellValue('BH' . ($i + 3), $debtorData[$i]->comisiones);
			$worksheet->setCellValue('BI' . ($i + 3), $debtorData[$i]->otros_ingresos);
			$worksheet->setCellValue('BJ' . ($i + 3), $debtorData[$i]->arriendo_vivienda);
			$worksheet->setCellValue('BK' . ($i + 3), $debtorData[$i]->gasto_personal_familiar);
			$worksheet->setCellValue('BL' . ($i + 3), $debtorData[$i]->cuotas_creditos);
			$worksheet->setCellValue('BM' . ($i + 3), $debtorData[$i]->conyuge_ingresos_mensuales);
			$worksheet->setCellValue('BN' . ($i + 3), $debtorData[$i]->conyuge_gastos_mensuales);
			$worksheet->setCellValue('BO' . ($i + 3), $debtorData[$i]->conyuge_obligaciones);
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$vehiculos_deudor = json_decode($debtorData[$i]->vehiculos);
			if (!is_array($vehiculos_deudor)) {
				$vehiculos_deudor = [];
			}
			$worksheet->setCellValue('BP' . ($i + 3), strval(count($vehiculos_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Vehiculos');
			$worksheet = $spreadsheet->getActiveSheet();
						
			for ($j = 0; $j < count($vehiculos_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_vehiculos), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_vehiculos), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_vehiculos), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->placa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->prenda);
				//$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_deudor[$j]->deuda);
				$ultima_fila_vehiculos++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$inmuebles_deudor = json_decode($debtorData[$i]->inmuebles);
			if (!is_array($inmuebles_deudor)) {
				$inmuebles_deudor = [];
			}
			$worksheet->setCellValue('BQ' . ($i + 3), strval(count($inmuebles_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Propiedades');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($inmuebles_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_inmuebles), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_inmuebles), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_inmuebles), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->tipo_inmueble);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->hipoteca);
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_deudor[$j]->porcentaje_propiedad);
				$ultima_fila_inmuebles++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$empleados_deudor = json_decode($debtorData[$i]->empleados);
			if (!is_array($empleados_deudor)) {
				$empleados_deudor = [];
			}
			$worksheet->setCellValue('BR' . ($i + 3), strval(count($empleados_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Empleados');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($empleados_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_empleados), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_empleados), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_empleados), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->sector);
				switch($empleados_deudor[$j]->antiguedad_empleo) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->tipo_contrato);
				$worksheet->setCellValue('H' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->duracion);
				$worksheet->setCellValue('I' . ($j + 3 + $ultima_fila_empleados), $empleados_deudor[$j]->duracion_cantidad);
				$ultima_fila_empleados++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$independientes_deudor = json_decode($debtorData[$i]->independientes);
			if (!is_array($independientes_deudor)) {
				$independientes_deudor = [];
			}
			$worksheet->setCellValue('BS' . ($i + 3), strval(count($independientes_deudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Independientes');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($independientes_deudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_independientes), $debtorData[$i]->id);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_independientes), "DEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_independientes), $debtorData[$i]->nombres . " " . $debtorData[$i]->primer_apellido . " " . $debtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->sector);
				switch($independientes_deudor[$j]->antiguedad_independiente) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_independientes), $independientes_deudor[$j]->ocupacion);
				$ultima_fila_independientes++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
		}
		
		for ($i = 0; $i < count($codebtorData); $i++)
		{
			$worksheet->setCellValue('A' . ($i + 3 + count($debtorData)), $codebtorData[$i]->id_deudor);
			$worksheet->setCellValue('B' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
			$worksheet->setCellValue('C' . ($i + 3 + count($debtorData)), $codebtorData[$i]->referido);
			$worksheet->setCellValue('D' . ($i + 3 + count($debtorData)), "vanka.com.co/credito/abrir_formulario_codeudor_temporal_anterior?id=" . $codebtorData[$i]->id);
			$worksheet->getCell('D' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_formulario_codeudor_temporal_anterior?id=' . $codebtorData[$i]->id);
			$worksheet->setCellValue('E' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_identificacion);
			$worksheet->setCellValue('F' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('G' . ($i + 3 + count($debtorData)), $codebtorData[$i]->correo);
			$worksheet->setCellValue('H' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular);
			$worksheet->setCellValue('I' . ($i + 3 + count($debtorData)), "CODEUDOR");
			$worksheet->setCellValue('J' . ($i + 3 + count($debtorData)), $codebtorData[$i]->id_deudor);
			$worksheet->setCellValue('K' . ($i + 3 + count($debtorData)), $codebtorData[$i]->valor_solicitado);
			$worksheet->setCellValue('L' . ($i + 3 + count($debtorData)), $codebtorData[$i]->plazo);
			$worksheet->setCellValue('M' . ($i + 3 + count($debtorData)), $codebtorData[$i]->fecha_nacimiento);
			$worksheet->setCellValue('N' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('O' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('P' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('Q' . ($i + 3 + count($debtorData)), "");
			//$worksheet->setCellValue('R' . ($i + 3 + count($debtorData)), 'vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->adjunto_cedula));
			//$worksheet->getCell('R' . ($i + 3 + count($debtorData)))->getHyperlink()->setUrl('vanka.com.co/credito/abrir_documento?filename=' . str_replace("Uploaded/", "", $codebtorData[$i]->adjunto_cedula));
			//$worksheet->setCellValue('S' . ($i + 3 + count($debtorData)), "");
			$worksheet->setCellValue('T' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_ingresos);
			$worksheet->setCellValue('U' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_activos);
			$worksheet->setCellValue('V' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_por_cobrar);
			$worksheet->setCellValue('W' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_egresos);
			$worksheet->setCellValue('X' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_pasivos);
			$worksheet->setCellValue('Y' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_por_pagar);
			$worksheet->setCellValue('Z' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_utilidad);
			$worksheet->setCellValue('AA' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_patrimonio);
            //$worksheet->setCellValue('AA' . ($i + 3 + count($debtorData)), $codebtorData[$i]->informacion_financiera_fecha); POR IMPLEMENTAR
			$worksheet->setCellValue('AB' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_persona);
			$worksheet->setCellValue('AC' . ($i + 3 + count($debtorData)), $codebtorData[$i]->destino_credito);
			$worksheet->setCellValue('AD' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_identificacion);
			$worksheet->setCellValue('AE' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad);
			$worksheet->setCellValue('AF' . ($i + 3 + count($debtorData)), $codebtorData[$i]->barrio);
			$worksheet->setCellValue('AG' . ($i + 3 + count($debtorData)), $codebtorData[$i]->departamento);
			$worksheet->setCellValue('AH' . ($i + 3 + count($debtorData)), $codebtorData[$i]->telefono);
			$worksheet->setCellValue('AI' . ($i + 3 + count($debtorData)), $codebtorData[$i]->estado_civil);
			$worksheet->setCellValue('AJ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_vivienda);
			$worksheet->setCellValue('AK' . ($i + 3 + count($debtorData)), $codebtorData[$i]->estrato);
			$worksheet->setCellValue('AL' . ($i + 3 + count($debtorData)), $codebtorData[$i]->personas_a_cargo);
			$worksheet->setCellValue('AM' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombre_apellido_conyuge);
			$worksheet->setCellValue('AN' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular_conyuge);
			$worksheet->setCellValue('AO' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_conyuge);
			$worksheet->setCellValue('AP' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombre_empresa);
			$worksheet->setCellValue('AQ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nit);
			//$worksheet->setCellValue('AR' . ($i + 3 + count($debtorData)), $codebtorData[$i]->razon_social_empresa);
			$worksheet->setCellValue('AS' . ($i + 3 + count($debtorData)), $codebtorData[$i]->direccion_empresa);
			$worksheet->setCellValue('AT' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_empresa);
			$worksheet->setCellValue('AU' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_contacto_empresa);
			$worksheet->setCellValue('AV' . ($i + 3 + count($debtorData)), $codebtorData[$i]->actividad_economica_empresa);
			$worksheet->setCellValue('AW' . ($i + 3 + count($debtorData)), $codebtorData[$i]->pagina_web_empresa);
			$worksheet->setCellValue('AX' . ($i + 3 + count($debtorData)), $codebtorData[$i]->antiguedad_empresa);
			$worksheet->setCellValue('AY' . ($i + 3 + count($debtorData)), $codebtorData[$i]->nombres_representante_legal . " " . $codebtorData[$i]->primer_apellido_representante_legal . " " . $codebtorData[$i]->segundo_apellido_representante_legal);
			$worksheet->setCellValue('AZ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->tipo_identificacion_representante_legal);
			$worksheet->setCellValue('BA' . ($i + 3 + count($debtorData)), $codebtorData[$i]->numero_identificacion_representante_legal);
			$worksheet->setCellValue('BB' . ($i + 3 + count($debtorData)), $codebtorData[$i]->correo_representante_legal);
			$worksheet->setCellValue('BC' . ($i + 3 + count($debtorData)), $codebtorData[$i]->ciudad_representante_legal);
			$worksheet->setCellValue('BD' . ($i + 3 + count($debtorData)), $codebtorData[$i]->departamento_representante_legal);
			$worksheet->setCellValue('BE' . ($i + 3 + count($debtorData)), $codebtorData[$i]->direccion_representante_legal);
			$worksheet->setCellValue('BF' . ($i + 3 + count($debtorData)), $codebtorData[$i]->celular_representante_legal);
			$worksheet->setCellValue('BG' . ($i + 3 + count($debtorData)), $codebtorData[$i]->honorarios);
			$worksheet->setCellValue('BH' . ($i + 3 + count($debtorData)), $codebtorData[$i]->comisiones);
			$worksheet->setCellValue('BI' . ($i + 3 + count($debtorData)), $codebtorData[$i]->otros_ingresos);
			$worksheet->setCellValue('BJ' . ($i + 3 + count($debtorData)), $codebtorData[$i]->arriendo_vivienda);
			$worksheet->setCellValue('BK' . ($i + 3 + count($debtorData)), $codebtorData[$i]->gasto_personal_familiar);
			$worksheet->setCellValue('BL' . ($i + 3 + count($debtorData)), $codebtorData[$i]->cuotas_creditos);
			$worksheet->setCellValue('BM' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_ingresos_mensuales);
			$worksheet->setCellValue('BN' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_gastos_mensuales);
			$worksheet->setCellValue('BO' . ($i + 3 + count($debtorData)), $codebtorData[$i]->conyuge_obligaciones);
			$worksheet->setCellValue('BT' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->nombres);
			$worksheet->setCellValue('BU' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->celular);
			$worksheet->setCellValue('BV' . ($i + 3 + count($debtorData)), $codebtorData[$i]->resumen->correo);
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$vehiculos_codeudor = json_decode($codebtorData[$i]->vehiculos);
			if (!is_array($vehiculos_codeudor)) {
				$vehiculos_codeudor = [];
			}
			$worksheet->setCellValue('BP' . ($i + 3 + count($debtorData)), strval(count($vehiculos_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Vehiculos');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($vehiculos_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_vehiculos), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_vehiculos), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_vehiculos), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->placa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->prenda);
				//$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_vehiculos), $vehiculos_codeudor[$j]->deuda);
				$ultima_fila_vehiculos++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$inmuebles_codeudor = json_decode($codebtorData[$i]->inmuebles);
			if (!is_array($inmuebles_codeudor)) {
				$inmuebles_codeudor = [];
			}
			$worksheet->setCellValue('BQ' . ($i + 3 + count($debtorData)), strval(count($inmuebles_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Propiedades');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($inmuebles_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_inmuebles), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_inmuebles), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_inmuebles), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->tipo_inmueble);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->valor_comercial);
				$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->hipoteca);
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_inmuebles), $inmuebles_codeudor[$j]->porcentaje_propiedad);
				$ultima_fila_inmuebles++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$empleados_codeudor = json_decode($codebtorData[$i]->empleados);
			if (!is_array($empleados_codeudor)) {
				$empleados_codeudor = [];
			}
			$worksheet->setCellValue('BR' . ($i + 3 + count($debtorData)), strval(count($empleados_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Empleados');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($empleados_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_empleados), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_empleados), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_empleados), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->sector);
				switch($empleados_codeudor[$j]->antiguedad_empleo) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_empleados), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->tipo_contrato);
				$worksheet->setCellValue('H' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->duracion);
				$worksheet->setCellValue('I' . ($j + 3 + $ultima_fila_empleados), $empleados_codeudor[$j]->duracion_cantidad);
				$ultima_fila_empleados++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
			$independientes_codeudor = json_decode($codebtorData[$i]->independientes);
			if (!is_array($independientes_codeudor)) {
				$independientes_codeudor = [];
			}
			$worksheet->setCellValue('BS' . ($i + 3 + count($debtorData)), strval(count($independientes_codeudor)));
			
			$spreadsheet->setActiveSheetIndexByName('Independientes');
			$worksheet = $spreadsheet->getActiveSheet();
			
			for ($j = 0; $j < count($independientes_codeudor); $j++)
			{
				$worksheet->setCellValue('A' . ($j + 3 + $ultima_fila_independientes), $codebtorData[$i]->id_deudor);
				$worksheet->setCellValue('B' . ($j + 3 + $ultima_fila_independientes), "CODEUDOR");
				$worksheet->setCellValue('C' . ($j + 3 + $ultima_fila_independientes), $codebtorData[$i]->nombres . " " . $codebtorData[$i]->primer_apellido . " " . $codebtorData[$i]->segundo_apellido);
				$worksheet->setCellValue('D' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->empresa);
				$worksheet->setCellValue('E' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->sector);
				switch($independientes_codeudor[$j]->antiguedad_independiente) {
					case "menos_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Menos de 6 meses");
						break;
					case "mas_6_meses":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 6 meses");
						break;
					case "mas_1_anho":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 1 año");
						break;
					case "mas_2_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 2 años");
						break;
					case "mas_5_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 5 años");
						break;
					case "mas_10_anhos":
						$worksheet->setCellValue('F' . ($j + 3 + $ultima_fila_independientes), "Más de 10 años");
						break;
				}
				$worksheet->setCellValue('G' . ($j + 3 + $ultima_fila_independientes), $independientes_codeudor[$j]->ocupacion);
				$ultima_fila_independientes++;
			}
			
			$spreadsheet->setActiveSheetIndexByName('Base');
			$worksheet = $spreadsheet->getActiveSheet();
		}
		
		//SORTING
		die(var_dump(count($debtorData) + 2 + count($codebtorData)));
		$data = $worksheet->rangeToArray("A3:BV" . count($debtorData) + 2 + count($codebtorData));
		
		$filename = "informe_clientes.xlsx";
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, $inputFileType);
		
		header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-dispoSition: attachment; filename=" . $filename);
		
		$writer->save('php://output');
		
		exit;
	}
}