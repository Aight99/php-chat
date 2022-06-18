
<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// В Composer.json нет автозагрузки моих классов
spl_autoload_register(function ($class) {
    $path = dirname(__DIR__ ) . '/src/';
    $extension = '.php';
    $fullPath = $path . str_replace("\\", "/", $class) . $extension;
    require_once $fullPath;
});
require_once(dirname(__DIR__ ).'/vendor/autoload.php');

$application = new Application();
echo $application->run();


function logDebug(string $message = "")
{
    $logger = new Logger('logger');
    $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/Debug.log'), Logger::DEBUG));
    $logger->debug($message);
}
