<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$config = new ftech\Config;
$session = new ftech\Session;
$task = new ftech\Task;

$session->start();
$session->set('token', session_id());

$taskcd = filter_get('taskcd');

$arTask = $task->getOneTask( $session->get('userid'), $taskcd );

$smarty->assign('task', $arTask[0]);
$smarty->assign('token', $session->get('token'));
$smarty->display('taskline.tpl');
