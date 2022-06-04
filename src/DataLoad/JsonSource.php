<?php

namespace DataLoad;

class JsonSource implements DataSource
{
    // Жесонина со списком всех пользователей / сообщений
    private string $jsonPath;
    private iterable $database;

    public function __construct(string $jsonPath)
    {
        $this->jsonPath = $jsonPath;
        $this->database = $this->decodeJson();
    }

    public function getAllData(): iterable
    {
        return $this->database;
    }

    public function getDataByKey(string $key): ?string
    {
        if ($this->isKeyExist($key)) {
            return $this->database[$key];
        } else {
            return null;
        }
    }

    public function addData($key, ...$otherData)
    {
        $this->database[$key] = $otherData;
        file_put_contents($this->jsonPath, json_encode($this->database));
    }

    private function isKeyExist(string $key): bool
    {
        return isset($this->database[$key]);
    }

    private function decodeJson(): iterable
    {
        if (!file_exists($this->jsonPath)) {
            file_put_contents($this->jsonPath, json_encode([]));
        }

        $data = json_decode(file_get_contents($this->jsonPath), true);
        return $data ?? [];
    }
}