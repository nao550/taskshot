<?php
namespace ftech;

class Dbconnect
{
  private $dbconnect = '';

  function __construct($Dbconnect){
    $this->dbconnect = $Dbconnect;
  }

  public function con()
  {
    $config = new Config;

    try{
      $this->pdo = new PDO($config->dsn, $config->dbUser , $config->DbPass );
    } catch (PDOException $e) {
      exit('データベース接続失敗。'.$e->getMessage());
    }

    return $pdo;
  }
}
