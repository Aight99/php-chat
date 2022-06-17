<?php

declare(strict_types=1);

use Controller\ChatController;
use Controller\LoginController;
use Model\Message;
use Model\User;
use Model\UserActiveRecord;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Application
{
    private LoginController $loginController;
    private ChatController $chatController;

    public function __construct()
    {
        $loader = new FilesystemLoader(dirname(__DIR__) . "/templates/");
        $twig = new Environment($loader);
        $logger = new Logger('logger');
        $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/DatabaseInfo.log'), Logger::INFO));
        $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/Debug.log'), Logger::DEBUG));
        $this->loginController = new LoginController($twig, $logger);
        $this->chatController = new ChatController($twig, $logger);
    }

    public function run(): string
    {
        $cookieTime = 3600;
        $logger = new Logger('logger');
        $logger->pushHandler(new StreamHandler((dirname(__DIR__ ) . '/Logs/Debug.log'), Logger::DEBUG));
        try {
            $logger->debug("Run is working");
        } catch (\Throwable $e) { // For PHP 7
            echo $e->getMessage();
        }

        if ($this->isLoggedOut()) {
            setcookie ("login", "", time() - $cookieTime);
            return $this->loginController->render();
        }
        if ($this->isSessionExist()) {
            $logger->debug("Session is working");
            if ($this->isMessageSent()) {
                $user = new UserActiveRecord($_COOKIE["login"], "123");
                $receiver = ($_GET["receiver"] == "") ? Message::PUBLIC_MESSAGE : $_GET["receiver"];
                $text = $_GET["message"];
                $logger->debug("GETs is working");
                $this->chatController->createMessage($user, $text, $receiver);
                $logger->debug("Create message is working");
                return $this->chatController->render($user);
            }
            $user = new User($_COOKIE["login"], "123");
            return $this->chatController->render($user);
        }
        if ($this->isLoggedIn()) {
            $user = new UserActiveRecord($_GET["auth_login"], $_GET["auth_password"]);
            if ($user->getByLogin($_GET["auth_login"])->getPassword() == $_GET["auth_password"]) {
                setcookie("login", $_GET["auth_login"], time() + $cookieTime);
                return $this->chatController->render($user);
            }
        }
        if ($this->isRegister() && $_GET["reg_password"] == $_GET["reg_password2"]) {
            $user = new UserActiveRecord($_GET["reg_login"], $_GET["reg_password"]);
            $user->save();
            return $this->chatController->render($user);
        }

        return $this->loginController->render();
    }

    private function isSessionExist():bool {
        return isset($_COOKIE["login"]);
    }
    private function isLoggedIn():bool {
        $isAuthLoginSet = isset($_GET["auth_login"]) && $_GET["auth_login"] != "";
        $isAuthPasswordSet = isset($_GET["auth_password"]) && $_GET["auth_password"] != "";
        return $isAuthLoginSet && $isAuthPasswordSet;
    }
    private function isLoggedOut(): bool {
        return isset($_GET["action"]) && $_GET["action"] == "logout";
    }
    private function isRegister():bool {
        $isRegLoginSet = isset($_GET["reg_login"]) && $_GET["reg_login"] != "";
        $isRegPasswordSet = isset($_GET["reg_password"]) && $_GET["reg_password"] != "";
        $isRegPassword2Set = isset($_GET["reg_password2"]) && $_GET["reg_password2"] != "";
        return $isRegLoginSet && $isRegPasswordSet && $isRegPassword2Set;
    }
    private function isMessageSent(): bool {
        return isset($_GET["message"]) && $_GET["message"] != "";
    }

}