<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Service
{
  /**
   *
   * @var string
   */
  private $zwsId;
  
  /**
   *
   * @var HttpClient 
   */
  private $httpClient;
  
  /**
   *
   * @var array[string]string
   */
  private $cache;
  
  /**
   *
   * @param string $zwsId
   * @param HttpClient $opt_httpClient 
   */
  public function __construct($zwsId, $opt_httpClient = null) {
    $this->zwsId = $zwsId;
    $this->httpClient = ($opt_httpClient) ? $opt_httpClient : new HttpClient();
    $this->cache = array();
  }
  
  /**
   *
   * @param string $address
   * @param string $cityStateZip
   * @return SearchResults 
   */
  public function getSearchResults($address, $cityStateZip) {
    $url = '/webservice/GetSearchResults.htm?'
         . 'zws-id='       . $this->zwsId . '&'
         . 'address='      . urlencode( $address ) . '&'
         . 'citystatezip=' . urlencode( $cityStateZip );
    
    return $this->fetch($url, 'Pillow\SearchResults');
  }
  
  /**
   *
   * @param string $zpid
   * @param number $width
   * @param number $height
   * @param string $unitType
   * @param string $chartDuration
   * @return Chart 
   */
  public function getChart($zpid, $width, $height, $unitType, $chartDuration) {
    $url = '/webservice/GetChart.htm?'
         . 'zws-id='       . $this->zwsId . '&'
         . 'zpid='           . $zpid . '&'
         . 'unit-type='      . $unitType . '&'
         . 'width='          . $width . '&'
         . 'height='         . $height . '&'
         . 'chartDuration='  . $chartDuration;
    
    return $this->fetch($url, 'Pillow\Chart');
  }
  
  private function fetch($url, $className) {
    $key = sha1($url);
    
    if(! isset($this->cache[$key])) {
      $xml = $this->httpClient->get($url);
      $this->cache[$key] = call_user_func_array(
              array($className, 'createFromXml'), array($xml, $this));
    }
    
    return $this->cache[$key];
  }
}