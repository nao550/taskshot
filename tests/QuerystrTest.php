<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use ftech\Querystr;

class QuerystrTest extends TestCase
{
    private $target;
    private $date;

    public function Setup()
    {
        $this->target = new Querystr;
        $this->date = date('Y-m-d',time());


//    return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/QstDB.xml');
    }

    public function testchkDate()
    {
        // 日付を直接入力
        $this->assertEquals(date('Y-m-d',time()), $this->target->chkDate($this->date));
        // today を引数、今日の日付が返り値
        $this->assertEquals(date('Y-m-d',time()), $this->target->chkDate('today'));
        // yestarday が引数、昨日の日付が返り値
        $this->assertEquals(date('Y-m-d', mktime(0,0,0,date('m'), date('d')-1, date('y'))), $this->target->chkDate('yestarday'));
        // tomorrow が引数、明日の日付が返り値
        $this->assertEquals(date('Y-m-d',mktime(0,0,0,date('m'), date('d')+1, date('y'))), $this->target->chkDate('tomorrow'));

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
