<?php

use Twig\Environment;

class ChatController
{
    private Environment $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;

        echo $this->twig->render('/LoginSystem/auth.html.twig');
    }


}