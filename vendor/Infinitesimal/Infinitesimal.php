<?php

namespace Infinitesimal;

use Dotenv\Dotenv;
use Infinitesimal\Routing\Router;

class Infinitesimal
{
    private function __construct(string $rootDir)
    {
        $this->registerAutoloaders($rootDir);
        Path::init($rootDir);
    }

    private function registerAutoloaders(string $rootDir)
    {
        spl_autoload_extensions(".php");
        spl_autoload_register(function ($class) use ($rootDir)
        {
            $folders = ['/', '/vendor/'];
            foreach ($folders as $folder)
            {
                $baseDir = $rootDir . $folder;
                $file = str_replace('\\', '/', $baseDir . $class) . '.php';
                if (file_exists($file))
                {
                    require $file;
                    break;
                }
            }
        });
    }

    private function process()
    {
        session_start();

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestedUrl = $_SERVER['REQUEST_URI'];
        $baseScriptUrl = pathinfo($_SERVER['SCRIPT_NAME'])['dirname'];
        if ($baseScriptUrl === "/") $baseScriptUrl = "";
        $projectUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . $baseScriptUrl;

        $pattern = "$$baseScriptUrl/([^?]*)(\?.*)?$";
        preg_match($pattern, $requestedUrl, $matches);

        $url = $matches[1];
        $queryString = isset($matches[2]) ? $matches[2] : '';

        Url::init($projectUrl);

        $container = new \DI\Container();
        /** @var Router $router */
        $router = $container->get(Router::class);
        $this->CallSetupFiles($container, $router);

        Container::registerContainer($container);

        $executable = $router->getExecutableForRoute($requestMethod, $url);
        $executable->execute();
    }

    private function CallSetupFiles(\DI\Container $container, Router $router)
    {
        $configurator = new \Setup\InfinitesimalSetup();
        $configurator->setupOnAwake();
        $configurator->SetupContainer($container);

        $routerConfigurator = new \Setup\RouterSetup();
        $routerConfigurator->setupRouter($router, $container);
    }

    /** @var Infinitesimal */
    private static $instance;

    public static function run(string $rootDir)
    {
        self::$instance = new Infinitesimal($rootDir);
        Dotenv::createImmutable($rootDir)->load();
        self::$instance->process();
    }
}

function view($path)
{
    if (substr($path, -4) !== '.php') $path .= '.php';
    require Path::view($path);
}