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


    /*
     * chkDate
     * 入力された日付キーワード解析
     * @param string
     * @return string
     */
    public function chkDate($str)
    {

        if (isset($str)) {
            if (preg_match('/20[0-9][0-9]-[0-1][1-9]-[0-3][0-9]/', $str)) {
                return $str;
            }
            switch ($str) {
                case 'today':
                case '今日':
                    return date('Y-m-d', time());
                    break;
                case 'yestarday':
                case '昨日':
                    return date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')-1, date('y')));
                    break;
                case 'tomorrow':
                case '明日':
                    return date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('y')));
                    break;
                default:
                    return date('Y-m-d', time());
            }
        }
    }


    /*
     *  separateLineTask
       @param string
       @return array
     */
    public function separateLineTask($linetask)
    {
        $artasks = explode(' ', $linetask);
        foreach ($artasks as $task) {
            // set rank
            if (substr($task, 0, 1) === '!'){
                $tasks['rank'] = substr($task, 1);
            }
            //  set tag
            elseif (substr($task, 0, 1) === '#'){
                $tasks['tag'] = substr($task, 1);
            }
            // set area
            elseif (substr($task, 0, 1) === '@'){
                $tasks['area'] = substr($task, 1);
            }
            // set date
            elseif (substr($task, 0, 1) === '^'){
                $tasks['date'] = substr($task, 1);
            } else {
                $tasks['work'] = $task;
            }
        }

        $tasks['rank'] = isset($tasks['rank'])? $tasks['rank'] : '';
        $tasks['tag'] = isset($tasks['tag'])? $tasks['tag'] : '';
        $tasks['area'] = isset($tasks['area'])? $tasks['area'] : '';
        $tasks['date'] = isset($tasks['date'])? $tasks['date'] : '';
        $tasks['work'] = isset($tasks['work'])? $tasks['work'] : '';

        return $tasks;
    }

    public function rankChk($rank)
    {
        if ( strlen($rank) !== 1){
            return '';
        }

        if (preg_match('/[0-3]/', $rank)) {
            return $rank;
        }

        return '';
    }
}
