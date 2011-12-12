<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Range
{
  public $low;
  
  public $high;
  
  public static function createFromXml($xml) {
    $r = new Range;
    
    if(is_array($xml) && count($xml) == 1) {
      $xml = $xml[0];
    }
    
    $r->low = Xml::xstring($xml, './/low');
    $r->high = Xml::xstring($xml, './/high');
    
    return $r;
  }
}