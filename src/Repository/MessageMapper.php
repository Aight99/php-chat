<?php

namespace Repository;

use Model\Message;
use PDO;

class MessageMapper
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO('mysql:host=localhost;dbname=chat', 'root', '12345Qwerty');
    }


    public function getAll()
    {
        $sql = 'SELECT * from message';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByID(int $id): ?Message
    {
        $sql = 'SELECT * from message WHERE id= :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('id', $id);
        $stmt->execute();
        $message = $stmt->fetch();
        if (isset($message)) {
            return new Message($message["text"], $message["sender_login"], $message["receiver_login"], (int)$message["time"]);
        } else {
            return null;
        }
    }

    public function getBySender(string $senderLogin)
    {
        $sql = 'SELECT * from user WHERE password= :password';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('password', $senderLogin);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function store(Message $message)
    {
        $text = $message->getText();
        $sender = $message->getSenderLogin();
        $receiver = $message->getReceiverLogin();
        $time = $message->getTime();
        $sql = 'INSERT INTO message(text, sender_login, receiver_login, time) values(:text, :sender, :receiver, :time)';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('text', $text);
        $stmt->bindParam('sender', $sender);
        $stmt->bindParam('receiver', $receiver);
        $stmt->bindParam('time', $time);
        $stmt->execute();
    }

    public function delete(Message $message)
    {
        $time = $message->getTime();
        $sender = $message->getSenderLogin();
        $sql = 'DELETE FROM message WHERE time= :time AND sender_login= :sender';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('time', $time);
        $stmt->bindParam('sender', $sender);
        $stmt->execute();
    }
}