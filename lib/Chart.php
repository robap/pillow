<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \SimpleXMLElement;

class Chart
{
  /**
   *
   * @var number
   */
  public $width;
  
  /**
   *
   * @var number
   */
  public $height;
  
  /**
   *
   * @var string
   */
  public $unitType;
  
  /**
   *
   * @var url $url
   */
  public $url;
  
  /**
   *
   * @param SimpleXMLElement $xml 
   */
  public static function createFromXml($xml) {
    $c = new Chart();
    
    $c->width = Xml::xstring($xml, '//request/width');
    $c->height = Xml::xstring($xml, '//request/height');
    $c->unitType = Xml::xstring($xml, '//request/unit-type');
    $c->url = Xml::xstring($xml, '//response/url');
    
    return $c;
  }
}

