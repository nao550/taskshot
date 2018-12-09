<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ftech\Querystr;

class QuerystrTest extends TestCase
{
    private $target;
    private $linetask;

    public function Setup()
    {
        $this->target = new Querystr;
        $this->linetask = "hogahoga #tag ^2018-11-15 @京都 !1";
        $this->taskonly = "hogahoga";


//    return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/QstDB.xml');
    }

    public function testchkDate()
    {
        $date = date('Y-m-d',time());
        $date2sla = date('m/d',time());
        $date2hyp = date('m-d',time());


        // 日付を直接入力
        // 0000-00-00 形式
        $this->assertEquals($date, $this->target->chkDate(date('Y-m-d',time())));

        // 0000/00/00 形式
        $this->assertEquals($date, $this->target->chkDate(date("Y\/m\/d",time())));

        // 12/12 形式
        $this->assertEquals($date, $this->target->chkDate($date2sla));

        // 12-12 形式
        $this->assertEquals($date, $this->target->chkDate($date2hyp));

        // today を引数、今日の日付が返り値
        $this->assertEquals($date, $this->target->chkDate('today'));

        // yestarday が引数、昨日の日付が返り値
        $this->assertEquals(date('Y-m-d', mktime(0,0,0,date('m'), date('d')-1, date('y'))), $this->target->chkDate('yestarday'));

        // tomorrow が引数、明日の日付が返り値
        $this->assertEquals(date('Y-m-d',mktime(0,0,0,date('m'), date('d')+1, date('y'))), $this->target->chkDate('tomorrow'));
    }

    public function testsCompareDate(){
        $now = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('y')));
        $olddate =  date('Y-m-d', mktime(0,0,0,date('m'),date('d')-10,date('y')));
        $oneyeardate =  date('Y-m-d', mktime(0,0,0,date('m'),date('d')-10,date('y')+1));
        $future = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+1,date('y')));


        $this->assertEquals($now, $this->target->compareDate($now));
        $this->assertEquals($oneyeardate, $this->target->compareDate($olddate));
        $this->assertEquals($future, $this->target->compareDate($future));
    }

    public function testSeparateLineTask()
    {
        $tasks = $this->target->separateLineTask( $this->linetask );
        $this->assertEquals ($tasks['rank'], '1');
        $this->assertEquals ($tasks['work'], 'hogahoga');
        $this->assertEquals ($tasks['tag'], 'tag');
        $this->assertEquals ($tasks['date'], '2018-11-15');
        $this->assertEquals ($tasks['area'], '京都');

        $tasks = $this->target->separateLineTask($this->taskonly);
        $this->assertEquals ($tasks['rank'], '');
        $this->assertEquals ($tasks['work'], 'hogahoga');
        $this->assertEquals ($tasks['tag'], '');
        $this->assertEquals ($tasks['date'], '');
        $this->assertEquals ($tasks['area'], '');
    }

    public function testrankChk()
    {
        $this->assertEquals ('1', $this->target->rankChk('1'));
        $this->assertEquals ('0', $this->target->rankChk('0'));
        $this->assertEquals ('', $this->target->rankChk('hoge'));
    }
/*
  public function testGetRowCount()
  {
    $this->assertEquals(4, $this->getConnection()->getRowCount( 'Qst'));
  }

  public function testGetAllQstDataset()
  {
    $queryTable = $this->getConnection()->createQueryTable('Qst', 'SELECT * FROM Qst;');
    $expectedTable = $this->createFlatXmlDataSet( __DIR__.'/_files/QstDB.xml')->getTable('Qst');
    $this->assertTablesEqual($expectedTable, $queryTable);
  }
 */
}
