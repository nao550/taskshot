<?php
namespace ftech;

use PDO;

class Task
{
    private $task;
    private $pdo;

    public function __construct($Task = '')
    {
        $this->task = $Task;

        $config = new Config;
        $this->pdo = $config->getPdo();
    }

    public function getAllTask()
    {
        $sql = 'select * from tasks where compflg = false ';
        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        return $stm;
    }

    public function addTask($tasks)
    {
        $sql = 'INSERT INTO tasks (lank, tag, date, work, '.
           'compflg, regdate ) '.
           'VALUE (:lank, :tag, :date, :work, 0, NOW());';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':lank', $tasks['lank'], PDO::PARAM_STR);
        $stmt->bindValue(':tag', $tasks['tag'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $tasks['date'], PDO::PARAM_STR);
        $stmt->bindValue(':work', $tasks['work'], PDO::PARAM_STR);
        $stmt->execute();

        return 0;
    }

    public function endTask($cd)
    {
        $sql = "UPDATE tasks set compflg='1' where cd=:cd ;";
        echo $sql ;
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
        $stmt->execute();
        return 0;
    }
}
