<?php
require_once '../vendor/autoload.php';
require_once '../lib/functions.php';
require_once '../lib/Smarty.php';

$session = new ftech\Session;
if ($session->get('mode') == 'uped'){
  $session->remove('mode');
  $_POST = '';
}

var_dump ( $_POST );

$task = new ftech\Task;
$i = 0;

$mode = filter_post('mode');

if ($mode == 'add'){
  if ($session->get('mode') == ''){
    $session->set('mode','uped');

    $tasks = [
      'lank' => filter_post('lank'),
      'tag' => filter_post('tag'),
      'date' => filter_post('date'),
      'work' => filter_post('work'),
    ];
    var_dump( $tasks );
    $task->addTask( $tasks );
  }
}

if ($mode == 'up'){

}

if ($mode == 'end'){
  $task->endTask( filter_post('cd') );
}

foreach( $task->getAllTask() as $row){
  $arTask[$i] = ['cd' => $row['cd'], 'lank' => $row['lank'],
                 'tag' => $row['tag'], 'date' => $row['date'],
                 'sttime' => $row['sttime'], 'edtime' => $row['edtime'],
                 'work' => $row['work'], 'pid' =>  $row['pid'],
                 'compflg' => $row['compflg'],
  ];
  $i++;
}



$smarty->assign('arTask', $arTask);
$smarty->display('index.tpl');
