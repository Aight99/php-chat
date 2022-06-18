<?php

namespace View;

use Model\User;
use Twig\Environment;

interface ChatPage
{
    public function __construct(Environment $twig);
    public function renderHTML(array $messages, User $user) : string;
    public function getTwig() : Environment;
}