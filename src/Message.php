<?php

class Message
{
    public const PUBLIC_MESSAGE = -1;

    private int $time;
    private string $senderLogin;
    private string $receiverLogin;
    private string $messageText;

    public function __construct(string $messageText, string $senderLogin, string $receiverLogin = self::PUBLIC_MESSAGE)
    {
        $this->senderLogin = $senderLogin;
        $this->receiverLogin = $receiverLogin;
        $this->messageText = $messageText;
        $this->time = time();
    }

    public function getSenderLogin(): string
    {
        return $this->senderLogin;
    }

    public function getReceiverLogin(): string
    {
        return $this->receiverLogin;
    }

    public function getMessageText(): string
    {
        return $this->messageText;
    }

    public function getTime(): int
    {
        return $this->time;
    }
}