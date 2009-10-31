<?php
require_once('PHPUnit/Framework.php');
include_once(dirname(__FILE__) . '/../lib/pillow/Base.php');
include_once(dirname(__FILE__) . '/../lib/pillow/Zestimate.php');


class ZestimateTest extends PHPUnit_Framework_TestCase
{
    public $zestimate;
    
    public function setUp()
    {
        $this->zestimate = new Pillow_Zestimate;

        $this->zestimate->amount                = 'amount';
        $this->zestimate->lastUpdated           = 'lastUpdated';
        $this->zestimate->valueChange           = 'valueChange';
        $this->zestimate->valuationRange->low   = 'low';
        $this->zestimate->valuationRange->high  = 'high';
        $this->zestimate->percentile            = 'percentile';
    }

    public function testZestimateCreate()
    {
        $this->assertTrue('Pillow_Zestimate' == get_class($this->zestimate));
    }

    public function testAmount()
    {
        $this->assertSame('amount', $this->zestimate->amount);
    }

    public function testlastUpdated()
    {
        $this->assertSame('lastUpdated', $this->zestimate->lastUpdated);
    }

    public function testValueChange()
    {
        $this->assertSame('valueChange', $this->zestimate->valueChange);
    }

    public function testValuaionRangeLow()
    {
        $this->assertSame('low', $this->zestimate->valuationRange->low);
    }

    public function testValuaionRangeHigh()
    {
        $this->assertSame('high', $this->zestimate->valuationRange->high);
    }

    public function testPercentile()
    {
        $this->assertSame('percentile', $this->zestimate->percentile);
    }
}

?>
