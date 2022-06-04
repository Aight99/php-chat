<?php
namespace DataLoad;

class MySQLSource implements DataSource
{
    public function getAllData(): iterable
    {
        // TODO: Implement getAllData() method.
        return null;
    }

//    public function isKeyExist(string $key): bool
//    {
//        // TODO: Implement isKeyExist() method.
//        return false;
//    }

    public function getDataByKey(string $key): string
    {
        // TODO: Implement getDataByID() method
        return "Database";
    }

    public function addData($key, ...$otherData)
    {
        // TODO: Implement addData() method.
    }
}