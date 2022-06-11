<?php

declare(strict_types=1);

namespace Controller;

use Model\User;
use Twig\Environment;

class ChatController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(iterable $messages, User $user) : string
    {
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/Chat/chat.html.twig', [
            'messages' => $messages,
            'user' => $user
        ]);
    }
}