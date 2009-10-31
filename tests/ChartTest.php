<?php
require_once('PHPUnit/Framework.php');
include_once(dirname(__FILE__) . '/../lib/pillow/Base.php');
include_once(dirname(__FILE__) . '/../lib/pillow/Chart.php');


class ChartTest extends PHPUnit_Framework_TestCase
{
    public $chart;
    
    public function setUp()
    {
        $this->chart = new Pillow_Chart;

        $this->chart->url = 'url';
        $this->chart->graphsAndData = 'graphsAndData';
    }

    public function testChartCreate()
    {
        $this->assertTrue('Pillow_Chart' == get_class($this->chart));
    }

    public function testUrl()
    {
        $this->assertSame('url', $this->chart->url);
    }

    public function testGraphsAndData()
    {
        $this->assertSame('graphsAndData', $this->chart->graphsAndData);
    }
}

?>
