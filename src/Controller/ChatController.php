<?php

declare(strict_types=1);

namespace Controller;

use PDO;
use Model\Message;
use Model\User;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class ChatController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $twig->addExtension(new DebugExtension());
    }

    public function render(User $user) : string
    {
        $msgArr = [];
        $msgArr[] = new Message("Pokemon is the best game ever!", "Leon", "N");
        $db = new PDO('mysql:host=localhost;dbname=chat', 'root', '12345Qwerty');
        $query = "SELECT * FROM message ORDER BY `time` DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $messages = $statement->fetchAll();
        foreach ($messages as $message) {
            $mesObj = new Message($message["text"], $message["sender_login"], $message["receiver_login"], (int)$message["time"]);
            $msgArr[] = $mesObj;
        }
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/Chat/chat.html.twig', [
            'messages' => $msgArr,
            'user' => $user
        ]);
    }
}