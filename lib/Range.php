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
    
    $r->low = Xml::xstring($xml, './/zestimate/valuationRange/low');
    $r->high = Xml::xstring($xml, './/zestimate/valuationRange/high');
    
    return $r;
  }
}