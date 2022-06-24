<?php

declare(strict_types=1);

use Controller\ChatController;
use Controller\LoginController;
use Model\Message;
use Model\User;
use Model\UserActiveRecord;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Repository\MessageMapper;
use Repository\MessageRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use View\ChatNormalPage;

class Application
{
    private LoginController $loginController;
    private ChatController $chatController;

    public function __construct()
    {
        $loader = new FilesystemLoader(dirname(__DIR__) . "/templates/");
        $twig = new Environment($loader);
        $logger = new Logger('logger');
        $logger->pushHandler(new StreamHandler((dirname(__DIR__) . '/Logs/DatabaseInfo.log'), Logger::INFO));
        $logger->pushHandler(new StreamHandler((dirname(__DIR__) . '/Logs/Debug.log'), Logger::DEBUG));
        $this->loginController = new LoginController($twig, $logger);
        $this->chatController = new ChatController(new MessageRepository(new MessageMapper($logger)), new ChatNormalPage($twig), $logger);
    }

    public function run(): string
    {
        $cookieTime = 3600;
        $admin = "admin";
        $logger = new Logger('logger');
        $logger->pushHandler(new StreamHandler((dirname(__DIR__) . '/Logs/Debug.log'), Logger::DEBUG));

        if ($this->isLoggedOut()) {
            setcookie("login", "", time() - $cookieTime);
            setcookie("pass", "", time() - $cookieTime);
            return $this->loginController->render();
        }
        if ($this->isSessionExist()) {
            $user = new UserActiveRecord($_COOKIE["login"], "123");
            $user = $user->getByLogin($_COOKIE["login"]);
            if (md5($user->getPassword() . "salt") == $_COOKIE["pass"]) {
                if ($this->isMessageSent()) {
                    $receiver = ($_POST["receiver"] == "") ? Message::PUBLIC_MESSAGE : $_POST["receiver"];
                    $text = $_POST["msg_text"];
                    $this->chatController->createMessage($user, $text, (string)$receiver);
                    if ($_COOKIE["login"] == $admin) {
                        $this->chatController->setAdminView();
                    }
                    return $this->chatController->render($user);
                }
                if ($_COOKIE["login"] == $admin) {
                    $this->chatController->setAdminView();
                }
                return $this->chatController->render($user);
            }
        }
        if ($this->isLoggedIn()) {
            $user = new UserActiveRecord($_POST["auth_login"], $_POST["auth_password"]);
            $user = $user->getByLogin($_POST["auth_login"]);
            if (!is_null($user) && $user->getPassword() == $_POST["auth_password"]) {
                setcookie("login", $_POST["auth_login"], time() + $cookieTime);
                setcookie("pass", md5($_POST["auth_password"] . "salt"), time() + $cookieTime);
                if ($_POST["auth_login"] == $admin && $_POST["auth_password"] == $admin) {
                    $this->chatController->setAdminView();
                }
                return $this->chatController->render($user);
            }
        }
        if ($this->isRegister() && $_POST["reg_password"] == $_POST["reg_password2"]) {
            $user = new UserActiveRecord($_POST["reg_login"], $_POST["reg_password"]);
            $user->save();
            return $this->chatController->render($user);
        }
        return $this->loginController->render();
    }

    private function isSessionExist(): bool
    {
        return isset($_COOKIE["login"]) && isset($_COOKIE["pass"]);
    }

    private function isLoggedIn(): bool
    {
        $isAuthLoginSet = isset($_POST["auth_login"]) && $_POST["auth_login"] != "";
        $isAuthPasswordSet = isset($_POST["auth_password"]) && $_POST["auth_password"] != "";
        return $isAuthLoginSet && $isAuthPasswordSet;
    }

    private function isLoggedOut(): bool
    {
        return isset($_GET["action"]) && $_GET["action"] == "logout";
    }

    private function isRegister(): bool
    {
        $isRegLoginSet = isset($_POST["reg_login"]) && $_POST["reg_login"] != "";
        $isRegPasswordSet = isset($_POST["reg_password"]) && $_POST["reg_password"] != "";
        $isRegPassword2Set = isset($_POST["reg_password2"]) && $_POST["reg_password2"] != "";
        return $isRegLoginSet && $isRegPasswordSet && $isRegPassword2Set;
    }

    private function isMessageSent(): bool
    {
        return isset($_POST["msg_text"]) && $_POST["msg_text"] != "";
    }
}