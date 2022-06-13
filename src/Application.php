<?php

declare(strict_types=1);

use Controller\ChatController;
use Controller\LoginController;
use DataLoad\JsonSource;
use DataLoad\MessagesRepository;
use DataLoad\UsersRepository;
use Model\User;
use Model\UserActiveRecord;
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
        $this->loginController = new LoginController($twig);
        $this->chatController = new ChatController($twig);
    }

    public function run(): string
    {
        $cookieTime = 3600;


//        $userRepository = new UsersRepository(new JsonSource($usersJsonPath));
//        $messageRepository = new MessagesRepository(new JsonSource($messagesJsonPath));
        if ($this->isLoggedOut()) {
            setcookie ("login", "", time() - $cookieTime);
            return $this->loginController->render();
        }
        if ($this->isSessionExist()) {
            if ($this->isMessageSent()) {
                $user = new UserActiveRecord($_COOKIE["login"], "123");
                return $this->chatController->render($user);
                return $_GET["message"] . " " . $_GET["receiver"];
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
        if ($this->isRegister()) {
            $user = new UserActiveRecord($_GET["reg_login"], $_GET["auth_password"]);
            return $this->chatController->render($user);
        }
//        if (!empty($_POST) && $_GET['action'] === 'remove_from_cart') {
//            return $this->serviceLocator->get(CartController::class)->removeProductAction((int)$_POST['product_id']);
//        }

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