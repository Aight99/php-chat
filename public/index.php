
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


$application = new Application();
echo $application->run();





//$loader = new FilesystemLoader(dirname(__DIR__) . "/templates/");
//$twig = new Environment($loader);
//$chat = new LoginController($twig);
//
//$isAuthLoginSet = isset($_POST["login"]) && $_POST["login"] != "";
//$isAuthPasswordSet = isset($_POST["password"]) && $_POST["password"] != "";
//$isRegLoginSet = isset($_POST["login"]) && $_POST["login"] != "";
//$isRegPasswordSet = isset($_POST["password"]) && $_POST["password"] != "";
//$isRegPassword2Set = isset($_POST["message"]) && $_POST["message"] != "";
//
//if ($isAuthLoginSet && $isAuthPasswordSet) {
//    $login = $_POST["auth_login"];
//    $password = $_POST["auth_password"];
//    echo "Проверяем бд <br> Пользователь найден <br> Добро пожаловать, {$login} <br> {$password}";
//    echo "<script>console.log('Проверяем бд  Пользователь найден <br> Добро пожаловать," . $login . "' );</script>";
//} else if ($isRegLoginSet && $isRegPasswordSet && $isRegPassword2Set) {
//    $login = $_POST["reg_login"];
//    $password = $_POST["reg_password"];
//    $password2 = $_POST["reg_password2"];
//    echo "Проверяем бд <br> Пользователь найден <br> Добро пожаловать, {$login} <br> {$password} <br> {$password2}";
//    echo "<script>console.log('Зареган под паролем " . $password . "' );</script>";
//} else if ($isAuthLoginSet || $isAuthPasswordSet || $isRegLoginSet || $isRegPasswordSet || $isRegPassword2Set) {
//    echo "Invalid input <br> Вы умерли от взлома жопы <br> бум";
//    echo "<script>console.log('Вы умерли от взлома жопы: ');</script>";
//}







//function logDebug(string $message = "")
//{
//    $logger = new Logger('logger');
//    $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/Debug.log'), Logger::DEBUG));
//    $logger->debug($message);
//}
//
//function printUser(User $user)
//{
//    $name = $user->getLogin();
//    $password = $user->getPassword();
//    echo "<p> Hello, $name! Your password was stolen, it's $password </p>";
//    logDebug("Hello, $name! Your password was stolen, it's $password");
//}
//
//$usersJsonPath = dirname(__DIR__ ) . '/src/' . "DataLoad\JsonFiles\Users.json";
//$messagesJsonPath = dirname(__DIR__ ) . '/src/' . "DataLoad\JsonFiles\Messages.json";
//$userRepository = new UsersRepository(new JsonSource($usersJsonPath));
//$messageRepository = new MessagesRepository(new JsonSource($messagesJsonPath));
//
//$isLoginSet = isset($_POST["login"]) && $_POST["login"] != "";
//$isPasswordSet = isset($_POST["password"]) && $_POST["password"] != "";
//$isMessageSet = isset($_POST["message"]) && $_POST["message"] != "";
//
//if ($isLoginSet && $isPasswordSet) {
//    $login = $_POST["login"];
//    $password = $_POST["password"];
//    $user = new User($login, $password);
//    printUser($user);
//    $userRepository->addUser($user);
////    $userRepository->echoAll();
//    $messageRepository->echoAll();
//    printMessageForm();
//} else if ($isLoginSet || $isPasswordSet) {
//    echo "Invalid input";
//    printLoginForm();
//} else if ($isMessageSet) {
//    $messageText = $_POST["message"];
//    $from = "Guest";
//    $message = new Message($messageText, $from);
//    $messageRepository->addMessage($message);
////    $userRepository->echoAll();
//    $messageRepository->echoAll();
//    printLoginForm();
//} else {
////    $userRepository->echoAll();
//    $messageRepository->echoAll();
//    printLoginForm();
//}
//
