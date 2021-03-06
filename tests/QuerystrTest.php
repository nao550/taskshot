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
        $this->linetask = "hoga hoga #tag ^2018-11-15 12:15 @京都 !1";
        $this->taskonly = "hoga hoga";


//    return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/QstDB.xml');
    }

    public function testChkDateNull()
    {
        $this->assertEquals(date('Y-m-d', time()), $this->target->chkDate());
    }

    public function testChkDate8haifun()
    {
        $this->assertEquals("2030-01-01", $this->target->chkDate("2030-01-01"));
    }

    public function testChkDay2sla()
    {
        $this->assertEquals("2030-01-01", $this->target->chkDate("2030-1-1"));
    }

    public function testchkDate()
    {
        $date = date('Y-m-d',time());
        $date2sla = date('m/d',time());
        $date2hyp = date('m-d',time());
        $dateerr = $date. "hoge";

        // 日付を直接入力
        // 0000-00-00 形式
        $this->assertEquals($date, $this->target->chkDate(date('Y-m-d',time())));

        // 0000/00/00 形式
        $this->assertEquals($date, $this->target->chkDate(date("Y\/m\/d",time())));

        // 12/12 形式
        $this->assertEquals($date, $this->target->chkDate($date2sla));

        // 12-12 形式
        $this->assertEquals($date, $this->target->chkDate($date2hyp));

        // 5/4 形式
        $this->assertEquals('2020-05-04', $this->target->chkDate("5/4"));
        $this->assertEquals("2019-11-11", $this->target->chkDate("11/11"));

        // 0000-00-00hoge 形式 日付としてエラなので、日付登録しない
        //        $this->assertEquals("0000-00-00", $this->target->chkDate($dateerr));
        $this->assertEquals($date, $this->target->chkDate($dateerr));


        // today を引数、今日の日付が返り値
        $this->assertEquals($date, $this->target->chkDate('today'));

        // yestarday が引数、昨日の日付が返り値
        $this->assertEquals(date('Y-m-d', mktime(0,0,0,date('m'), date('d')-1, date('y'))), $this->target->chkDate('yestarday'));

        // tomorrow が引数、明日の日付が返り値
        $this->assertEquals(date('Y-m-d',mktime(0,0,0,date('m'), date('d')+1, date('y'))), $this->target->chkDate('tomorrow'));
    }

    public function testsCompareDateNow()
    {
        $now = new \DateTime();
        $this->assertEquals($now->format('Y-m-d'), $this->target->compareDate($now->format('Y-m-d')));
    }

    public function testsCompareDateold()
    {
        $olddate =  date('Y-m-d', mktime(0,0,0,date('m'),date('d')-10,date('y')));
        $oneyeardate =  date('Y-m-d', mktime(0,0,0,date('m'),date('d')-10,date('y')+1));
        $future = date('Y-m-d', mktime(0,0,0,date('m'),date('d')+1,date('y')));


        $this->assertEquals($oneyeardate, $this->target->compareDate($olddate));
        $this->assertEquals($future, $this->target->compareDate($future));
    }

    public function testsCompareDateYear()
    {
        $future = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('y')+10));
        $this->assertEquals($future, $this->target->compareDate($future));
    }

    public function testSeparateLineTask()
    {
        $tasks = $this->target->separateLineTask( $this->linetask );
        $this->assertEquals ($tasks['rank'], '1');
        $this->assertEquals ($tasks['work'], 'hoga hoga');
        $this->assertEquals ($tasks['tag'], 'tag');
        $this->assertEquals ($tasks['date'], '2018-11-15');
        $this->assertEquals ($tasks['time'], '12:15');
        $this->assertEquals ($tasks['area'], '京都');

        $tasks = $this->target->separateLineTask($this->taskonly);
        $this->assertEquals ($tasks['rank'], '');
        $this->assertEquals ($tasks['work'], 'hoga hoga');
        $this->assertEquals ($tasks['tag'], '');
        $this->assertEquals ($tasks['date'], '');
        $this->assertEquals ($tasks['time'], '');
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
