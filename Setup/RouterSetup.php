<?php

namespace Setup;

use Infinitesimal\Auth\AuthMiddleware;
use Infinitesimal\Auth\Authentication;
use Infinitesimal\Auth\AuthenticationException;
use Infinitesimal\Globalization\GlobalizationMiddleware;
use Infinitesimal\Globalization\Persistence\GlobalizationSessionValue;
use Infinitesimal\Routing\Router;
use Infinitesimal\RouterSetupInterface;
use Infinitesimal\Url;
use Middlewares\AdminAuthorizationMiddleware;
use Psr\Container\ContainerInterface;

class RouterSetup implements RouterSetupInterface
{
    public function setupRouter(Router $router, ContainerInterface $container)
    {
		$this->setSession();
		
        $router->setAutoMiddlewares(GlobalizationMiddleware::class);

        $router->on404()->view('404');

        $router->all('')->controller(\Controllers\DebtorController::class, 'abrirFormularioDeudor');

		$router->all('guardar_datos_nuevo_formulario')->controller(\Controllers\DebtorController::class, 'guardarDatosNuevoFormulario');
		
		$router->all('registrar_datos_deudor')->controller(\Controllers\DebtorController::class, 'registrarDatos');
		
		$router->all('guardar_sesion_deudor')->controller(\Controllers\DebtorController::class, 'guardarSesion');
		
		$router->all('guardar_datos_temporales_deudor')->controller(\Controllers\DebtorController::class, 'guardarDatosTemporales');
		
		$router->all('subir_cedula')->controller(\Controllers\DebtorController::class, 'subirCedula');
		
		$router->all('registrar_datos_codeudor')->controller(\Controllers\CodebtorController::class, 'registrarDatos');
		
		$router->all('guardar_sesion_codeudor')->controller(\Controllers\CodebtorController::class, 'guardarSesion');
		
		$router->all('guardar_datos_temporales_codeudor')->controller(\Controllers\CodebtorController::class, 'guardarDatosTemporales');
		
		$router->all('codeudor')->controller(\Controllers\CodebtorController::class, 'abrirFormularioCodeudor');
		
		$router->all('login')->run(function ()
        {
            new \Views\LoginView();
        });
		
		$router->all('registro_finalizado')->controller(\Controllers\DebtorController::class, 'finalizarRegistro');
		
		$router->all('registro_codeudor_finalizado')->controller(\Controllers\CodebtorController::class, 'finalizarRegistro');
		
		$router->all('authorize')->controller(\Controllers\AuthController::class, 'login');
		
		$router->all('admin')->controller(\Controllers\AuthController::class, 'redirectAdmin');
		
		$router->all('logout')->controller(\Controllers\AuthController::class, 'logout');
		
		$router->all('nuevo_codeudor')->controller(\Controllers\DebtorController::class, 'abrirFormularioNuevoCodeudor');
		
		$router->all('registrar_nuevo_codeudor')->controller(\Controllers\DebtorController::class, 'registrarNuevoCodeudor');
		
		$router->setAutoMiddlewares(AdminAuthorizationMiddleware::class);
		
		$router->all('panel_admin')->controller(\Controllers\AdminController::class, 'openAdminPanel');
		
		$router->all('abrir_documento')->controller(\Controllers\FileController::class, 'openFile');
		
		$router->all('exportar')->controller(\Controllers\AdminController::class, 'exportar');
		
		$router->all('exportar_temporales')->controller(\Controllers\AdminController::class, 'exportarTemporales');
		
		$router->all('abrir_formulario_deudor_anterior')->controller(\Controllers\ReadController::class, 'abrirFormularioDeudorAnterior');
		
		$router->all('abrir_formulario_codeudor_anterior')->controller(\Controllers\ReadController::class, 'abrirFormularioCodeudorAnterior');
		
		$router->all('abrir_formulario_deudor_temporal_anterior')->controller(\Controllers\ReadController::class, 'abrirFormularioDeudorTemporalAnterior');
		
		$router->all('abrir_formulario_codeudor_temporal_anterior')->controller(\Controllers\ReadController::class, 'abrirFormularioCodeudorTemporalAnterior');
    }
	
	private function setSession() {
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 28800)) {
			session_unset();
			session_destroy();
		}
		$_SESSION['LAST_ACTIVITY'] = time();
	}
}