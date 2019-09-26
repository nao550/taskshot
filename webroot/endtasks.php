<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$config = new ftech\Config;
$task = new ftech\Task;
$session->start();
$url = $config->getBaseUrl();

if ($_SERVER['SERVER_NAME'] == 'www.kyo-to.net') var_dump($_POST);

if (empty($session->get('token')) || empty($session->get('userid'))) {
    header('location: '. $url . 'index.php');
}

$mode = filter_post('mode');
$getmode = filter_get('getmode');

if ($mode == 'RevertTask') {
    if ($session->get('token') == filter_post('token')) {
        $cd = filter_post('cd');
        $task->RevertTask($cd);
        $session->regenerate();
        $session->set('token', session_id());
        $task->RevertTask($cd);
    }
}

if ($mode == 'logout') {
    $session->clear();
    header('location: '. $url . 'index.php');
}

parse_str($_SERVER['QUERY_STRING'], $queryString);

$arTask = $task->getTask( $session->get('userid'), $queryString );

$arDayrange = [
    'endtask' => 'endtask',
    'all' => 'all',
    'runout' => [
            'ed' => date('Y-m-d', strtotime("-1 days"))
    ],
    'today' => [
        'st' => date('Y-m-d'),
        'ed' => date('Y-m-d')
    ],
    'next3day' => [
        'st' => date('Y-m-d'),
        'ed' => date('Y-m-d', strtotime("+3 days")),
    ],
    'thisweek' => [
        'st' => date('Y-m-d'),
        'ed' => date('Y-m-d', strtotime("+7 days")),

    ],
    'thismonth' => [
        'st' => date('Y-m-d'),
        'ed' => date('Y-m-d', strtotime("+30 days")),
    ],
];

$smarty->assign('arDayrange', $arDayrange);
$smarty->assign('mode', $mode);
$smarty->assign('getmode', $getmode);
$smarty->assign('token', $session->get('token'));
$smarty->assign('arTask', $arTask);
$smarty->display('endtasks.tpl');
