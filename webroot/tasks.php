<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$session->start();

if (empty($session->get('token')) || empty($session->get('userid'))) {
    header('location: '. $url . 'index.php');
}

$task = new ftech\Task;
$i = 0;

$mode = filter_post('mode');

if ($mode == 'add') {
    if ($session->get('token') == filter_post('token')) {
        $tasks = [
        'lank' => filter_post('lank'),
        'tag' => filter_post('tag'),
        'date' => filter_post('date'),
        'work' => filter_post('work'),
        ];
        $session->regenerate();
        $session->set('token', session_id());
        $task->addTask($tasks);
    }
}

if ($mode == 'up') {
}

if ($mode == 'end') {
    $task->endTask(filter_post('cd'));
}

if ($mode == 'logout') {
    $session->clear();
    header('location: '. $url . 'index.php');
}

$arTask = array();
foreach ($task->getAllTask() as $row) {
    $arTask[$i] = ['cd' => $row['cd'], 'lank' => $row['lank'],
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
