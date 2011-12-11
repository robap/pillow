<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \SimpleXMLElement;

class SearchResult
{
  private $zpid;
  
  private $links;
  
  private $address;
  
  private $zestimate;
  
  /**
   *
   * @param SimpleXMLElement $xml 
   */
  public static function createFromXml($xml) {
    $result = new SearchResult();
    
    $result->zpid = Xml::xstring($xml, '//result/zpid');
    
    return $result;
  }
}