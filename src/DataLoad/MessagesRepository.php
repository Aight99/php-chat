<?php

namespace DataLoad;

use Model\Message;

class MessagesRepository
{
    private DataSource $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function addMessage(Message $message) : void
    {
        $this->dataSource->addData($message->getTime(), $message->getText(), $message->getSenderLogin(), $message->getReceiverLogin());
    }

    public function getMessageList() : iterable
    {
        return $this->dataSource->getAllData();
    }

    public function echoAll()
    {
        $messages = $this->dataSource->getAllData();
        $timeStamps = array_keys((array)$messages);
        echo "<br> Сап двач <br> <br>";
        foreach ($timeStamps as $time) {
            echo date("F j H:i", $time) . ":<br>";
            echo "From {$messages[$time][1]}";
            if ($messages[$time][2] != -1) {
                echo " to {$messages[$time][2]}";
            }
            echo "<br>" . $messages[$time][0] . "<br>";
            echo "<br>";
        }
        echo "<br>";
    }
}