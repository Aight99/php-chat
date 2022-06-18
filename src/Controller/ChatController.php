<?php

declare(strict_types=1);

namespace Controller;

use Monolog\Logger;
use Model\Message;
use Model\User;
use Repository\MessageRepository;
use View\ChatAdminPage;
use View\ChatPage;

class ChatController
{
    private MessageRepository $messageRepository;
    private ChatPage $page;
    private Logger $logger;

    public function __construct(MessageRepository $messageRepository, ChatPage $page, Logger $logger)
    {
        $this->page = $page;
        $this->logger = $logger;
        $this->messageRepository = $messageRepository;
    }

    public function render(User $user) : string
    {
        return $this->page->renderHTML($this->messageRepository->getAll(), $user);
    }

    public function setAdminView() {
        $this->page = new ChatAdminPage($this->page->getTwig());
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