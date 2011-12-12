<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Zestimate
{
  /**
   * Zestimate Amount
   * @var string $amount
   */
  public $amount;

  /**
   * Last updated
   * @var Date $lastUpdated
   */
  public $lastUpdated;

  /**
   * Value Change in last 30 days
   * @var string $valueChange
   */
  public $thirtyDayChange;

  /**
   * Valuation Range (low, high)
   * @var Range $range
   */
  public $range;

  /**
   * Percentile
   * @var string $percentile
   */
  public $percentile;

  public static function createFromXml($xml)
  {
      $z = new Zestimate();
      
      if(is_array($xml) && count($xml) == 1) {
        $xml = $xml[0];
      }
      
      $z->amount = Xml::xstring($xml, './/amount');
      $z->lastUpdated = new Date(Xml::xstring($xml, './/last-updated'));
      $z->thirtyDayChange = Xml::xstring($xml, './/valueChange[@duration="30"]');
      $z->percentile = Xml::xstring($xml, './/percentile');
      $z->range = Range::createFromXml($xml->xpath('.//valuationRange'));
      
      return $z;
  }
}

