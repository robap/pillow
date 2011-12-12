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
      
      $z->amount = Xml::xstring($xml, './/zestimate/amount');
      $z->lastUpdated = new Date(Xml::xstring($xml, './/zestimate/last-updated'));
      $z->thirtyDayChange = Xml::xstring($xml, './/zestimate/valueChange[@duration="30"]');
      $z->percentile = Xml::xstring($xml, './/zestimate/percentile');
      $z->range = Range::createFromXml($xml);
      
      return $z;
  }
}

