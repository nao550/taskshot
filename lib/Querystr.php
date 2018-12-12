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
        $date = '';

        if (! isset($str)) {
            return '';
        }

        // 0000-00-00 形式
        if (preg_match('/^20[0-9][0-9]-[0-1][1-9]-[0-3][0-9]/', $str)) {
            $date = $str;
        }

        // 0000/00/00 形式
        if (preg_match('#^20\d{1,2}/\d{1,2}/\d{1,2}#', $str)) {
            $date = str_replace('/', '-', $str);
        }

        // 00/00 形式
        if (preg_match('#^\d{1,2}/\d{1,2}#', $str)) {
            $date = str_replace('/', '-', $str);
            $date = '2018-'.$date;
        }

        // 00-00 形式
        if (preg_match('#^\d{1,2}-\d{1,2}#', $str)) {
            $date = '2018-'.$str;
        }

        $date = $this->compareDate($date);

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
        }

        return $date;
    }


    /*
     * compareDate
     * 日付の比較、与えられた日付が古ければ、1年プラス
     * @param date 0000-00-00
     * @return date 0000-00-00
     */
    public function compareDate( $strdate )
    {
        $date = new \DateTime($strdate);
        $now = new \DateTime();
        $diff = $date->diff($now);

        // echo $strdate.':diff'.$diff->format('%a').PHP_EOL;
        if ((int)$diff->format('%a')) {
            return $date->modify('+1 year')->format('Y-m-d');
        } else {
            return $date->format('Y-m-d');
        }
    }

    /*
     * separateLineTask
     * @param string
     * @return array
     */
    public function separateLineTask($linetask)
    {
        $flg = '';
        $tasks = array(
            'work' => '',
            'rank' => '',
            'area' => '',
            'tag' => '',
            'date' => '',
            'time' => ''
        );

        $artasks = explode(' ', $linetask);
        foreach ($artasks as $task) {
            if ($flg = '^') {
                if ( preg_match('#\d{1,2}:\d{1,2}#', $task)) {
                    $tasks['time'] = $task;
                    continue;
                }
            }
            // set rank
            if (substr($task, 0, 1) === '!'){
                $tasks['rank'] = substr($task, 1);
                $flg = '!';
            }
            //  set tag
            elseif (substr($task, 0, 1) === '#'){
                $tasks['tag'] = substr($task, 1);
                $flg = '#';
            }
            // set area
            elseif (substr($task, 0, 1) === '@'){
                $tasks['area'] = substr($task, 1);
                $flg = '@';
            }
            // set date
            elseif (substr($task, 0, 1) === '^'){
                $tasks['date'] = substr($task, 1);
                $flg = '^';
            } else {
                if ($tasks['work'] == ''){
                    $tasks['work'] = $task;
                } else {
                    $tasks['work'] .= ' '. $task;
                }
                $flg = 'w';
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
