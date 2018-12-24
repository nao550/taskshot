<?php
namespace ftech;

use PDO;

class Setting
{
    private $pdo;

    public function __construct($setting = '')
    {
        $config = new Config;
        $this->pdo = $config->getPdo();
    }

}
