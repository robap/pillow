<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Links
{
  public $homedetails;
  
  public $graphsanddata;
  
  public $mapthishome;
  
  public $myestimator;
  
  public $comparables;
  
  /**
   *
   * @param SimpleXMLElement $xml
   * @return Links 
   */
  public static function createFromXml($xml) {
    $links = new Links;
    
    if(is_array($xml) && count($xml) > 0) {
      $xml = $xml[0];
    }
    
    if($xml) {
      $links->homedetails = Xml::xstring($xml, './/homedetails');
      $links->graphsanddata = Xml::xstring($xml, './/graphsanddata');
      $links->mapthishome = Xml::xstring($xml, './/mapthishome');
      $links->myestimator = Xml::xstring($xml, './/myestimator');
      $links->comparables = Xml::xstring($xml, './/comparables');
    }
    
    return $links;
  }
}