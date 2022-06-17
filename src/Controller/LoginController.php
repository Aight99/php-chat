<?php

declare(strict_types=1);

namespace Controller;

use Monolog\Logger;
use Twig\Environment;

class LoginController
{
    private Environment $twig;
    private Logger $logger;

    public function __construct(Environment $twig, Logger $logger)
    {
        $this->twig = $twig;
        $this->logger = $logger;
    }

    public function render() : string
    {
        // Добавить View страницы и рендерить через неё
        return $this->twig->render('/LoginSystem/auth.html.twig');
    }
}