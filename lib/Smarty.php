<?php

// Load Smarty and settings
$homedir = __DIR__;
$smarty = new SmartyBC();
$smarty->setTemplateDir($homedir . '/../templates/');
$smarty->setCompileDir($homedir . '/../templates_c/');
$smarty->setConfigDir($homedir . '/../configs/');
$smarty->setCacheDir($homedir . '/../cache/');
$smarty->escape_html = true;  // 全てのテンプレート変数出力にHTMLエスケープを適 用
$smarty->php_handling = \Smarty::PHP_ALLOW; // SmartyBC 用の設定 {php} を許可
// {$value nofilter} nofilter でエスケープが無効になる
// $smarty->setPluginsDir( $CFG['HOMEDIR'] . 'plugins/' )
// {{$value}|nl2br nofilter} でエスケープしてnl2brを設定
$smarty->debugging = false;
