<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$config = new ftech\Config;

$session = new ftech\Session;
$session->start();
$session->set('token', session_id());

$mode = filter_post('mode');
$email = filter_post('inputEmail');
$password = filter_post('inputPassword');

// ログインボタンが押されたとき
if ($mode == "login") {
    $user = new ftech\User();
    $userId = $user->getUser($email, $password);
    if ($userId != '') {
        $session->set('userid', $userId);
        $session->regenerate();
        $session->set('token', session_id());
        $url = $config->getBaseUrl();
        header('location: '. $url . 'tasks.php');
    }
}

// ログイン済
if (!(empty($session->get('token'))) && !(empty($session->get('userid')))) {
    header('location: '. $url . 'tasks.php');
}

$smarty->display('index.tpl');
