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
    
    $links->homedetails = Xml::xstring($xml, '//links/homedetails');
    $links->graphsanddata = Xml::xstring($xml, '//links/graphsanddata');
    $links->mapthishome = Xml::xstring($xml, '//links/mapthishome');
    $links->myestimator = Xml::xstring($xml, '//links/myestimator');
    $links->comparables = Xml::xstring($xml, '//links/comparables');
    
    return $links;
  }
}