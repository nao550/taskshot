<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$session->start();
$session->set('token', session_id());

var_dump( $_POST );

$smarty->assign('token', $session->get('token'));
$smarty->display('index.tpl');
