<?php
namespace ftech;

class Config
{
      private $config;
      public  $smarty;
      private $dbsv = 'localhost';
      private $dbnm = 'taskshot';
      private $dbuser = 'taskshot';
      private $dbpass = 'qbwNnfQ#Wjfc9S7Ww';
      private $homedir = __DIR__;

  function __construct($Config = ''){
    $this->config = $Config;

    if ( $_SERVER['SERVER_NAME'] == "taskshot.info" ){
      $this->dbnm = 'taskshot';
    } else {
      // 開発用サーバ
      $this->dbnm = 'taskshotdev';
    }
  }

  public function getDsn(){
    $dsn = 'mysql:host=' . $this->dbsv . ';dbname=' . $this->dbnm . ';charset=utf8';
    return $dsn;
  }

  public function getDbUser(){
    return $this->dbuser;
  }

  public function getDbPass(){
    return $this->dbpass;
  }

}
