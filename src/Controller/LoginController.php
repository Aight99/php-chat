<?php

declare(strict_types=1);

namespace Controller;

use Twig\Environment;

class LoginController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render() : string
    {
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/LoginSystem/auth.html.twig');
    }
}