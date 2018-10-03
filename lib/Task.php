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

    public function getAllTask( $userid )
    {
        $sql = 'select * from tasks where compflg = false and userid = :userid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->execute();

        return ($stmt->fetchAll());
    }

    /* Task を検索して、arrey で返す
     * @param string $user_id
     * @param string $queryString
     * @return array
     */
    /**
     * @param $user_id
     * @param $queryString
     * @return array
     */
    public function getTask($userid, $queryString)
    {
        $sql = 'select * from tasks where compflg = false and userid = :userid';

        $args = array(
            'stdate' => FILTER_SANITIZE_ENCODED,
            'eddate' => FILTER_SANITIZE_ENCODED,
        );
        $query = filter_var_array( $queryString, $args );

        if (!(empty($query['stdate']))){
            $sql .= " and date >= :stdate ";
        }
        if (!(empty($query['eddate']))){
            $sql .= " and date <= :eddate ";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);

        if (!(empty($query['stdate']))){
            $stmt->bindValue(':stdate', $query['stdate'], PDO::PARAM_STR);
        }
        if (!(empty($query['eddate']))){
            $stmt->bindValue(':eddate', $query['eddate'], PDO::PARAM_STR);
        }

        $stmt->execute();

        return ($stmt->fetchAll());
    }

    public function addTask($tasks)
    {
        $sql = 'INSERT INTO tasks (userid, rank, tag, date, work, '.
           'compflg, regdate ) '.
           'VALUE (:userid, :rank, :tag, :date, :work, 0, NOW());';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userid', $tasks['userid'], PDO::PARAM_STR);
        $stmt->bindValue(':rank', $tasks['rank'], PDO::PARAM_STR);
        $stmt->bindValue(':tag', $tasks['tag'], PDO::PARAM_STR);
        $stmt->bindValue(':date', $tasks['date'], PDO::PARAM_STR);
        $stmt->bindValue(':work', $tasks['work'], PDO::PARAM_STR);
        $stmt->execute();

        return 0;
    }

    public function endTask($taskcd)
    {
        $sql = "UPDATE tasks set compflg='1' where cd=:cd ;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':cd', $taskcd, PDO::PARAM_STR);
        $stmt->execute();
        return 0;
    }

    public function upTask($tasks){
        $sql = "UPDATE tasks set ";

        switch ($tasks['idclass']) {
            case 'taskrank':
                $sql .= " rank=:taskrank ";
                break;
            case 'tasktag' :
                $sql .= " tag=:tasktag ";
                break;
            case 'taskdate' :
                $sql .= " date=:taskdate ";
                break;
            case 'taskwork' :
                $sql .= " work=:taskwork ";
                break;
            default:
                exit();
        }
        $sql .= "WHERE cd=:cd ";

        $stmt = $this->pdo->prepare($sql);
        switch ($tasks['idclass']) {
            case 'taskrank':
                $stmt->bindValue(':taskrank', $tasks['idvalue'], PDO::PARAM_STR);
                break;
            case 'tasktag':
                $stmt->bindValue(':tasktag', $tasks['idvalue'], PDO::PARAM_STR);
                break;
            case 'taskdate':
                $stmt->bindValue(':taskdate', $tasks['idvalue'], PDO::PARAM_STR);
                break;
            case 'taskwork':
                $stmt->bindValue(':taskwork', $tasks['idvalue'], PDO::PARAM_STR);
                break;
        }

        $stmt->bindValue(':cd', $tasks['cd'], PDO::PARAM_STR);
        $stmt->execute();
        return 0;

    }
}
