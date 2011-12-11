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
    
    $this->assertEquals(1, count($results));
    $this->assertInstanceOf('\Pillow\Property', $results->current());
  }
}