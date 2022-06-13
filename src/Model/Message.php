<?php

namespace Model;

class Message
{
    public const PUBLIC_MESSAGE = -1;
    public const CURRENT_TIME = -1;

    private int $time;
    private string $senderLogin;
    private string $receiverLogin;
    private string $text;

    public function __construct(string $messageText, string $senderLogin, string $receiverLogin = self::PUBLIC_MESSAGE, int $time = self::CURRENT_TIME)
    {
        $this->senderLogin = $senderLogin;
        $this->receiverLogin = $receiverLogin;
        $this->text = $messageText;
        if ($time == -1) {
            $this->time = time();
        } else {
            $this->time = $time;
        }
    }

    public function getSenderLogin(): string
    {
        return $this->senderLogin;
    }

    public function getReceiverLogin(): string
    {
        return $this->receiverLogin;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTime(): string
    {
        return date("F j H:i", $this->time);
    }
}