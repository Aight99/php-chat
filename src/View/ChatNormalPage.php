<?php

namespace View;

use Model\User;
use Twig\Environment;

class ChatNormalPage implements ChatPage
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function renderHTML(array $messages, User $user): string
    {
        return $this->twig->render('/Chat/chat.html.twig', [
            'messages' => $messages,
            'user' => $user
        ]);
    }

    public function getTwig() : Environment {
        return $this->twig;
    }
}