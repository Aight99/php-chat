<?php

declare(strict_types=1);

use Controller\ChatController;
use Controller\LoginController;
use DataLoad\JsonSource;
use DataLoad\MessagesRepository;
use DataLoad\UsersRepository;
use Model\User;
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
        $isAuthLoginSet = isset($_GET["auth_login"]) && $_GET["auth_login"] != "";
        $isAuthPasswordSet = isset($_GET["auth_password"]) && $_GET["auth_password"] != "";
        $isRegLoginSet = isset($_GET["reg_login"]) && $_GET["reg_login"] != "";
        $isRegPasswordSet = isset($_GET["reg_password"]) && $_GET["reg_password"] != "";
        $isRegPassword2Set = isset($_GET["reg_password2"]) && $_GET["reg_password2"] != "";
        $isMessageSet = isset($_GET["message"]) && $_GET["message"] != "";

        $usersJsonPath = dirname(__DIR__) . '/src/' . "DataLoad\JsonFiles\Users.json";
        $messagesJsonPath = dirname(__DIR__) . '/src/' . "DataLoad\JsonFiles\Messages.json";
        $userRepository = new UsersRepository(new JsonSource($usersJsonPath));
        $messageRepository = new MessagesRepository(new JsonSource($messagesJsonPath));

        if ($isMessageSet) {
            return $_GET["message"] . " " . $_GET["receiver"];
        }
        if ($isAuthLoginSet) {
            $user = new User($_GET["auth_login"], "123");
//            $messages = $messageRepository->getMessageList();
            return $this->chatController->render($user);
        }
//        if (!empty($_POST) && $_GET['action'] === 'remove_from_cart') {
//            return $this->serviceLocator->get(CartController::class)->removeProductAction((int)$_POST['product_id']);
//        }
//
//        if (!empty($_POST) && $_GET['action'] === 'add_to_cart') {
//            return $this->serviceLocator->get(CartController::class)->addProductAction((int)$_POST['product_id']);
//        }
//
//        if (($_GET['action'] ?? '') === 'cart') {
//            return $this->serviceLocator->get(CartController::class)->showAction();
//        }

        return $this->loginController->render();
    }
}