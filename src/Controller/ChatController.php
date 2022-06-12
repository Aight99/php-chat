<?php

declare(strict_types=1);

namespace Controller;

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

    public function render(iterable $messages, User $user) : string
    {
        $msgArr = [];
        foreach ($messages as $message) {
            $msgArr[] = $messages;
        }
        $msgArr[] = new Message("Pokemon is the best game ever!", "Leon", "N");
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/Chat/chat.html.twig', [
            'messages' => $msgArr,
            'user' => $user
        ]);
    }
}