
<?php

// В Composer.json нет автозагрузки моих классов

spl_autoload_register(function ($class) {
    $path = dirname(__DIR__ ) . '/src/';
    $extension = '.php';
    $fullPath = $path . str_replace("\\", "/", $class) . $extension;
//    echo $fullPath . " was loaded <br>";
    require_once $fullPath;
});
require_once(dirname(__DIR__ ).'/vendor/autoload.php');

use DataLoad\MySQLSource;
use DataLoad\JsonSource;
use DataLoad\UsersRepository;
use DataLoad\MessagesRepository;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;


//echo "hui";
$loader = new FilesystemLoader(dirname(__DIR__) . "/templates/");
$twig = new Environment($loader);
$chat = new ChatController($twig);


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
//function printLoginForm() {
//    echo "
//    <form method=\"post\">
//        <div>
//            <label>
//                Login
//                <input type=\"text\" name=\"login\" id=\"login\" onfocus=\"this.value=''\">
//            </label>
//        </div>
//        <div>
//            <label>
//                Password
//                <input type=\"password\" name=\"password\" id=\"password\" onfocus=\"this.value=''\">
//            </label>
//        </div>
//        <button>Register</button>
//    </form>
//    ";
//}
//
//function printMessageForm() {
//    echo "
//    <form method=\"post\">
//        <div>
//            <label>
//                Your message is
//                <input type=\"text\" name=\"message\" id=\"message\" onfocus=\"this.value=''\">
//            </label>
//        </div>
//        <button>Send</button>
//    </form>
//    ";
//}

?>

<!--<style>-->
<!--    div {-->
<!--        margin: 10px;-->
<!--    }-->
<!---->
<!--    button {-->
<!--        margin-left: 10px;-->
<!--    }-->
<!--</style>-->