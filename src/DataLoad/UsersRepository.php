<?php

namespace DataLoad;

use User;

class UsersRepository
{
    private DataSource $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function addUser(User $user): void
    {
        $this->dataSource->addData($user->getLogin(), $user->getPassword());
    }

    public function isUserExist(User $user): bool
    {
        $record = $this->dataSource->getDataByKey($user->getLogin());
        if (isset($record) && ($record[0] == $user->getPassword())) {
            return true;
        }
        return false;
    }

    public function echoAll()
    {
        $users = $this->dataSource->getAllData();
        $userLogins = array_keys((array)$users);
        foreach ($userLogins as $record) {
            echo $record . ":<br>";
            foreach ($users[$record] as $item) {
                echo $item . "<br>";
            }
        }
    }
}