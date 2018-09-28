<?php
namespace ftech;

class Config
{
    private $config;
    public $smarty;
    private $dbsv = 'localhost';
    private $dbnm = 'taskshot';
    private $dbuser = 'taskshot';
    private $dbpass = 'qbwNnfQ#Wjfc9S7Ww';
    private $homedir = __DIR__;

    public function __construct($Config = '')
    {
        $this->config = $Config;

        $server = filter_input(INPUT_SERVER, "SERVER_NAME");
        if ($server == "taskshot.info") {
            $this->dbnm = 'taskshot';
        } else {
          // 開発用サーバ
            $this->dbnm = 'taskshotdev';
        }
    }

    private function getDsn()
    {
        $dsn = 'mysql:host=' . $this->dbsv . ';dbname=' . $this->dbnm . ';charset=utf8';
        return $dsn;
    }

    public function getPdo()
    {
        try {
            $this->pdo = new \PDO($this->getDsn(), $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
        }
        return $this->pdo;
    }

    public function getBaseUrl()
    {
        $server = filter_input(INPUT_SERVER, "SERVER_NAME");
        if ($server == "taskshot.info") {
            return 'http://taskshot.info/';
        } else {
          // 開発用サーバ
            return 'http://www.kyo-to.net/~nao/taskshotdev/webroot/';
        }
    }
}
