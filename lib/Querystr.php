<?php
/**
 * Created by PhpStorm.
 * User: ikeno
 * Date: 2018/10/18
 * Time: 10:31
 */
namespace ftech;

class Querystr
{

    private $querystr;
    private $pdo;

    public function __construct($Querystr = '')
    {
        $config = new Config;
        $this->pdo = $config->getPdo();
    }

    public function chkDate($str)
    {

        if (isset($str)){
            if (preg_match('/20[0-9][0-9]-[0-1][1-9]-[0-3][0-9]/',$str)){
                return $str;
            }
            switch ($str) {
                case 'today':
                case '今日':
                    return date('Y-m-d',time());
                    break;
                case 'yestarday':
                case '昨日':
                    return date('Y-m-d', mktime(0,0,0,date('m'), date('d')-1, date('y')));
                    break;
                case 'tomorrow':
                case '明日':
                    return date('Y-m-d', mktime(0,0,0,date('m'), date('d')+1, date('y')));
                    break;
                default:
                    return date('Y-m-d',time());
            }
        }
    }
}
