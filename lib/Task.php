<?php
namespace ftech;
use PDO;

class Task
{
  private $task;
  private $pdo;

  function __construct($Task = ''){
    $this->task = $Task;

    $config = new Config;

    try{
      $this->pdo = new \PDO($config->getDsn(), $config->getDbUser() , $config->getDbPass() );
    } catch (PDOException $e) {
      exit('データベース接続失敗。'.$e->getMessage());
    }
  }

  public function getAllTask() {
    $sql = 'select * from t_task where compflg = false ';
    $stm = $this->pdo->prepare( $sql );
    $stm->execute();

    return $stm;
  }

  public function addTask( $tasks ){
    $sql = 'INSERT INTO t_task (lank, tag, date, work, '.
           'compflg, regdate ) '.
           'VALUE (:lank, :tag, :date, :work, 0, NOW());';

    $stmt = $this->pdo->prepare ($sql);
    $stmt->bindValue(':lank', $tasks['lank'], PDO::PARAM_STR);
    $stmt->bindValue(':tag', $tasks['tag'], PDO::PARAM_STR);
    $stmt->bindValue(':date', $tasks['date'], PDO::PARAM_STR);
    $stmt->bindValue(':work', $tasks['work'], PDO::PARAM_STR);
    $stmt->execute();

    return 0;
  }

  public function endTask( $cd ){
    $sql = "UPDATE t_task set compflg='1' where cd=:cd ;";
    echo $sql ;
    $stmt = $this->pdo->prepare ($sql);
    $stmt->bindValue(':cd', $cd, PDO::PARAM_STR);
    $stmt->execute();
    return 0;
  }
}
