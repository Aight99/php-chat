
<?php

use Controller\LoginController;
use Model\User;
use Model\Message;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// В Composer.json нет автозагрузки моих классов
spl_autoload_register(function ($class) {
    $path = dirname(__DIR__ ) . '/src/';
    $extension = '.php';
    $fullPath = $path . str_replace("\\", "/", $class) . $extension;
//    echo $fullPath . " was loaded <br>";
    require_once $fullPath;
});
require_once(dirname(__DIR__ ).'/vendor/autoload.php');
//try {
//    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//    $dotenv->load();
//} catch (\Throwable $e) {
//    echo $e->getMessage();
//}


$application = new Application();
echo $application->run();


//function logDebug(string $message = "")
//{
//    $logger = new Logger('logger');
//    $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/Debug.log'), Logger::DEBUG));
//    $logger->debug($message);
//}
