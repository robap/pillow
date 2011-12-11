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
   * @param string $zwsId
   * @param HttpClient $opt_httpClient 
   */
  public function __construct($zwsId, $opt_httpClient = null) {
    $this->zwsId = $zwsId;
    $this->httpClient = ($opt_httpClient) ? $opt_httpClient : new HttpClient();
  }
  
  /**
   *
   * @param string $address
   * @param string $cityStateZip
   * @return type 
   */
  public function getSearchResults($address, $cityStateZip) {
    $url = '/webservice/GetSearchResults.htm?'
         . 'zws-id='       . $this->zwsId        . '&'
         . 'address='      . urlencode( $address ) . '&'
         . 'citystatezip=' . urlencode( $cityStateZip );
    
    $xml = $this->httpClient->get($url);
    return SearchResults::createFromXml($xml);
  }
}