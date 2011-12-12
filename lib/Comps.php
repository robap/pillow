<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \SimpleXMLElement;

class Comps extends ResultSet
{
  
  /**
   *
   * @return Property 
   */
  public function current() {
    $current = parent::current();
    
    if(!$current) {
      return new Property();
    } else {
      return $current;
    }
  }
  
  /**
   *
   * @param SimpleXMLElement $xml
   * @param Service $service
   * @return Comps
   */
  public static function createFromXml($xml, $service) {
    $comps = new Comps;
    
    foreach($xml->xpath('//response/properties/comparables/comp') as $xmlResult) {
      $comps[] = Property::createFromXml($xmlResult, $service);
    }
    
    return $comps;
  }
}