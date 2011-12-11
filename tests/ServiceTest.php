<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require __DIR__ . '/../lib/Autoloader.php';

use Pillow\Service;

class ServiceTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->address = '555test';
    $this->zip = '444';
    $url = "/webservice/GetSearchResults.htm?zws-id=foo&address={$this->address}&citystatezip={$this->zip}";
    
    $this->mockHttpClient = $this->getMock('\Pillow\HttpClient');
    $this->service = new Service('foo', $this->mockHttpClient);
    $response = simplexml_load_string(file_get_contents(__DIR__ .'/responses/search_results.xml'));
    $this->mockHttpClient->expects($this->once())
            ->method('get')
            ->with($this->equalTo($url))
            ->will($this->returnValue($response));
  }
  
  /**
   * getSearchResults
   * 
   * @test
   */
  public function createResultSetWithOneResult() {
    $results = $this->service->getSearchResults($this->address, $this->zip);
    
    $this->assertSame(1, count($results));
  }
  
  /**
   * getSearchResults
   * 
   * @test
   */
  public function resultIsMappedCorrectly() {
    $results = $this->service->getSearchResults($this->address, $this->zip);
    $prop = $results->current();
    
    $this->assertEquals('48749425', $prop->zpid);
    
    $this->assertEquals('2114 Bigelow Ave N', $prop->street);
    $this->assertEquals('98109', $prop->zipcode);
    $this->assertEquals('Seattle', $prop->city);
    $this->assertEquals('WA', $prop->state);
    $this->assertEquals('47.63793', $prop->latitude);
    $this->assertEquals('-122.347936', $prop->longitude);
    
    $this->assertInstanceOf('\Pillow\Links', $prop->links);
    $this->assertEquals("http://www.zillow.com/homedetails/2114-Bigelow-Ave-N-Seattle-WA-98109/48749425_zpid/", $prop->links->homedetails);
    $this->assertEquals('http://www.zillow.com/homedetails/charts/48749425_zpid,1year_chartDuration/?cbt=7522682882544325802%7E9%7EY2EzX18jtvYTCel5PgJtPY1pmDDLxGDZXzsfRy49lJvCnZ4bh7Fi9w**', $prop->links->graphsanddata);
    $this->assertEquals('http://www.zillow.com/homes/map/48749425_zpid/', $prop->links->mapthishome);
    $this->assertEquals('http://www.zillow.com/myestimator/Edit.htm?zprop=48749425', $prop->links->myestimator);
    $this->assertEquals('http://www.zillow.com/homes/comps/48749425_zpid/', $prop->links->comparables);
  }
}