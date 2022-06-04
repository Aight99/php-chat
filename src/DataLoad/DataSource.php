<?php

namespace DataLoad;

interface DataSource
{
    public function getAllData() : iterable;
//    public function isKeyExist(string $key) : bool;
    public function getDataByKey(string $key);
    public function addData($key, ...$otherData);
}