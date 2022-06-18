<?php

namespace Repository;

//С помощью паттерна Repository реализовать функционал над одной таблицей БД по:
//а). получению всех записей
//б). получению записи по id
//в). получению записей по значению поля из таблицы (фильтрация по полю)
//г). сохранению записи
//д). удалению записи

use Model\Message;

class MessageRepository
{
    private MessageMapper $mapper;
    private array $storage;

    public function __construct(MessageMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->storage = [];
        $this->updateStorage();
    }

    public function updateStorage()
    {
        $this->storage = $this->mapper->getAll();
    }

    public function getAll(): array
    {
        return $this->storage;
    }

    public function getByID(int $id): ?Message
    {
        return $this->mapper->getByID($id);
    }

    public function getBySender(string $sender)
    {
        return $this->mapper->getBySender($sender);
    }

    public function store(Message $message)
    {
        $this->mapper->store($message);
        $this->updateStorage();
    }

    public function delete(Message $message)
    {
        $this->mapper->delete($message);
        $this->updateStorage();
    }
}