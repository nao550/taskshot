<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
$config = new ftech\Config;
$setting = new ftech\Setting;
$session->start();
$url = $config->getBaseUrl();

if (empty($session->get('token')) || empty($session->get('userid'))) {
    header('location: '. $url . 'index.php');
}

$mode = filter_post('mode');
$arSettigns = $setting->getSettings($session->get('userid'));

$smarty->assign('token', $session->get('token'));
$smarty->assign('arSettings', $arSettings);
$smarty->display('setting.tpl');
if ($_SERVER['SERVER_NAME'] == 'www.kyo-to.net') var_dump($_POST);
