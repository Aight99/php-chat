<?php

namespace Model;

use PDO;

//С помощью паттерна Active Record реализовать функционал над одной таблицей БД по:
//а). получению всех записей
//б). получению записи по id
//в). получению записей по значению поля из таблицы (фильтрация по полю)
//г). сохранению записи
//д). удалению записи

class UserActiveRecord extends User
{
//    private string $login;
//    private string $password;
    private PDO $connection;

    public function __construct(string $login, string $password)
    {
//        $this->login = $login;
//        $this->password = $password;
        parent::__construct($login, $password);
        $this->connection = new PDO('mysql:host=localhost;dbname=chat', 'root', '12345Qwerty');
    }

//    public function getLogin(): string
//    {
//        return $this->login;
//    }
//
//    public function getPassword(): string
//    {
//        return $this->password;
//    }

    public function getAll()
    {
        $sql = 'SELECT * from user';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByLogin($login): ?UserActiveRecord // Ну это id
    {
        $sql = 'SELECT * from user WHERE login= :login';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('login', $login);
        $stmt->execute();
        $user = $stmt->fetch();
        if (isset($user)) {
            return new UserActiveRecord($user['login'], $user['password']);
        } else {
            return null;
        }
    }

    public function getByPassword($password)
    {
        $sql = 'SELECT * from user WHERE password= :password';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('password', $password);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function save()
    {
        $login = $this->getLogin();
        $password = $this->getPassword();
        $sql = 'INSERT INTO user(login, password) values(:login, :password)';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('login', $login);
        $stmt->bindParam('password', $password);
        $stmt->execute();
    }

    public function delete()
    {
        $login = $this->getLogin();
        $sql = 'DELETE FROM user WHERE login= :login';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam('login', $login);
        $stmt->execute();
    }

}