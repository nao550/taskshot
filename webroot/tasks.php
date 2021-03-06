<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$config = new ftech\Config;
$task = new ftech\Task;
$session->start();
$url = $config->getBaseUrl();

if (empty($session->get('token')) || empty($session->get('userid'))) {
    header('location: '. $url . 'index.php');
}

$mode = filter_post('mode');

if ($mode == 'add') {
    if ($session->get('token') == filter_post('token')) {
        $tasks = [
            'userid' => $session->get('userid'),
            'linetask' => filter_post('linetask'),
            ];
        $session->regenerate();
        $session->set('token', session_id());
        $task->addTask($tasks);
    }
}

if ($mode == 'upTask') {
    if ($session->get('token') == filter_post('token')) {
        $tasks = [
            'cd' => filter_post('cd'),
            'work' => filter_post('work'),
            'date' => filter_post('date'),
            'rep' => filter_post('rep'),
            'rank' => filter_post('rank'),
            'tag' => filter_post('tag'),
            'memo' => $_POST['memo'],
            'userid' => $session->get('userid')
        ];
        $session->regenerate();
        $session->set('token', session_id());
        $task->upTask($tasks);
    }
}

if ($mode == 'endTask') {
    if ($session->get('token') == filter_post('token')) {
        $cd = filter_post('cd');

        $session->regenerate();
        $session->set('token', session_id());
        $task->endTask($session->get('userid'), $cd);
    }

}

if ($mode == 'delTask') {
    if ($session->get('token') == filter_post('token')) {
        $cd = filter_post('cd');

        $session->regenerate();
        $session->set('token', session_id());
        $task->endTask($session->get('userid'), $cd);
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

$smarty->assign('arDayrange', $arDayrange);
$smarty->assign('mode', $mode);
$smarty->assign('rangemode', $queryString['rangemode']);
$smarty->assign('token', $session->get('token'));
$smarty->assign('arTask', $arTask);
$smarty->display('tasks.tpl');
if ($_SERVER['SERVER_NAME'] == 'www.kyo-to.net'){var_dump($_POST);}
