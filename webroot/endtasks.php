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

if (empty($queryString['rangemode'])) {
    $queryString['rangemode'] = $session->get('rangemode');
} else {
    $session->set('rangemode', $queryString['rangemode']);
}

$arTask = $task->getTask( $session->get('userid'), $queryString );

$smarty->assign('mode', $mode);
$smarty->assign('rangemode', $queryString['rangemode']);
$smarty->assign('token', $session->get('token'));
$smarty->assign('arTask', $arTask);
$smarty->display('endtasks.tpl');
