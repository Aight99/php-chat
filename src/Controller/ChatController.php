<?php

declare(strict_types=1);

namespace Controller;

use Monolog\Logger;
use PDO;
use Model\Message;
use Model\User;
use Repository\MessageRepository;
use Twig\Environment;
use Twig\Extension\DebugExtension;

class ChatController
{
    private MessageRepository $messageRepository;
    private Environment $twig;
    private Logger $logger;

    public function __construct(Environment $twig, Logger $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
        $this->messageRepository = new MessageRepository();
        $twig->addExtension(new DebugExtension());
    }

    public function render(User $user) : string
    {
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/Chat/chat.html.twig', [
            'messages' => $this->messageRepository->getAll(),
            'user' => $user
        ]);
    }

    public function createMessage(User $user, string $text, string $receiver) : void
    {
        $time = time();
        $login = $user->getLogin();
        $this->logger->debug("Trying to add $time by $login");
        $this->messageRepository->store(new Message($text, $login, $receiver, $time));
        $this->logger->info("Message $time by $login was added in the database");
    }
}