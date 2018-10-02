<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$config = new ftech\Config;
$session->start();
$url = $config->getBaseUrl();

if (empty($session->get('token')) || empty($session->get('userid'))) {
    header('location: '. $url . 'index.php');
}

$task = new ftech\Task;
$i = 0;

$mode = filter_post('mode');

if ($mode == 'add') {
    if ($session->get('token') == filter_post('token')) {
        $tasks = [
            'userid' => $session->get('userid'),
            'rank' => filter_post('rank'),
            'tag' => filter_post('tag'),
            'date' => filter_post('date'),
            'work' => filter_post('work'),
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
            'idclass' => filter_post('idclass'),
            'idvalue' => filter_post('idvalue'),
        ];
        $session->regenerate();
        $session->set('token', session_id());
        $task->upTask($tasks);
    }
}

if ($mode == 'end') {
    $task->endTask(filter_post('taskcd'));
}

if ($mode == 'logout') {
    $session->clear();
    header('location: '. $url . 'index.php');
}

$arTask = array();
foreach ($task->getAllTask($session->get('userid')) as $row) {
    $arTask[$i] = ['cd' => $row['cd'], 'rank' => $row['rank'],
                 'tag' => $row['tag'], 'date' => $row['date'],
                 'sttime' => $row['sttime'], 'edtime' => $row['edtime'],
                 'work' => $row['work'], 'pid' =>  $row['pid'],
                 'compflg' => $row['compflg'],
    ];
    $i++;
}


$smarty->assign('token', $session->get('token'));
$smarty->assign('arTask', $arTask);
$smarty->display('tasks.tpl');
