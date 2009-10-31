<?php
require_once('PHPUnit/Framework.php');
require_once 'Mockery/Framework.php';
include_once(dirname(__FILE__) . '/../lib/pillow/Base.php');


class BaseTest extends PHPUnit_Framework_TestCase
{

    public function testBase()
    {
        $factory = mockery('Pillow_Factory');

        $base = new Pillow_Base();
        $base->setFactory( $factory );

        $this->assertSame( $factory, $base->getFactory());
    }
}

?>
