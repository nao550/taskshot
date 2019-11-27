<?php
/**
 * Created by PhpStorm.
 * User: ikeno
 * Date: 2018/10/18
 * Time: 10:31
 */
namespace ftech;

mb_internal_encoding("UTF-8");

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
     * @return string 0000-00-00
     */
    public function chkDate($str = "")
    {

        if (preg_match('#^(\d{1,4})[-/](\d{1,2})[-/](\d{1,2})$#', $str, $matches)) {
            $year = $matches[1];
            $month = $matches[2];
            $day = $matches[3];

            if (checkdate($month, $day, $year)) {
                $date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            } else {
                $date = date('Y-m-d', time());
            }
        }

        if (preg_match('#^(\d{1,2})[-/](\d{1,2})$#', $str, $matches)) {
            $year = date('Y',mktime(0, 0, 0, date('m'), date('d'), date('y')));
            $month = $matches[1];
            $day = $matches[2];

            if (checkdate($month, $day, $year)) {
                $date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            } else {
                $date = date('Y-m-d', time());
            }

            // 日付が今日より古ければ来年の日付
            $date = $this->compareDate($date);
        }

        // today, yestarday, tomorrow
        if (empty($date)) {
            $date = $this->chkDateString($str);
        }

        if (empty($date)) {
            $date = date('Y-m-d', time());
        }
        return $date;
    }


    /* chkDateString
     * 文字列の日付指定を処理
     * @param $string
     * @return date
     */
    public function chkDateString($str)
    {
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
    }

    /*
     * compareDate
     * 日付の比較、与えられた日付が古ければ、1年プラス
     * @param date 0000-00-00
     * @return date 0000-00-00
     */
    public function compareDate( $strdate )
    {
        $now = new \DateTime(date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('y'))));
        $date = new \DateTime($strdate);

        if ( $now > $date) {
            return $date->modify('+1 year')->format('Y-m-d');
        } else {
            return $date->format('Y-m-d');
        }
    }

    /*
     * 入力されたタスクを分割
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

        $tasks['rank'] = isset($tasks['rank'])? $tasks['rank'] : '9';
        $tasks['tag'] = isset($tasks['tag'])? $tasks['tag'] : '';
        $tasks['area'] = isset($tasks['area'])? $tasks['area'] : '';
        $tasks['date'] = isset($tasks['date'])? $tasks['date'] : '';
        $tasks['work'] = isset($tasks['work'])? $tasks['work'] : '';

        return $tasks;
    }

    /*
     * rankChk($rank)
     * ランクの範囲(0-3)をチェック
     * @param int $rank
     * @return int
     */
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
