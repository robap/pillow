<?php
require_once 'PHPUnit/Framework.php';
require_once 'Mockery/Framework.php';
include_once(dirname(__FILE__) . '/../lib/pillow/Base.php');
include_once(dirname(__FILE__) . '/../lib/pillow/Property.php');


class PropertyTest extends PHPUnit_Framework_TestCase
{
    public function testGetMethods()
    {
        $zestimate = mockery('pz', 'Pillow_Zestimate');
        $chart = mockery('pc', 'Pillow_Chart');

        $factory = mockery('Pillow_Factory', array(
            'createZestimate' => $zestimate,
            'createChart' => $chart
        ));

        $property = new Pillow_Property;
        $property->setFactory($factory);

        $ze = $property->getZestimate();
        $this->assertSame($zestimate, $ze);

        $ch = $property->getChart(Pillow_Property::CHART_UNIT_DOLLAR);
        $this->assertSame($chart, $ch);
        
    }
 
}

?>
