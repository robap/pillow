<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \ArrayObject;

class Property
{
  const CHART_UNIT_DOLLAR = 'dollar';
  const CHART_UNIT_PERCENT = 'percent';

  /**
   * zpid
   * @var string $zpid
   */
  public $zpid;

  /**
   * Group of zillow links for the property
   * @var stdClass $links
   */
  public $links;

  /**
   * Street
   * @var string $street
   */
  public $street;

  /**
   * Zip
   * @var string $zipcode
   */
  public $zipcode;

  /**
   * City
   * @var string $city
   */
  public $city;

  /**
   * State
   * @var string $state
   */
  public $state;

  /**
   * latitude
   * @var string $latitude
   */
  public $latitude;

  /**
   * longitude
   * @var string $longitude
   */
  public $longitude;

  /**
   * fips county
   * @var string $fipsCounty
   */
  public $fipsCounty;

  /**
   * number of bathrooms
   * @var string $bathrooms
   */
  public $bathrooms;

  /**
   * number of bedrooms
   * @var string $bedrooms
   */
  public $bedrooms;

  /**
   * The use code
   * @var string $useCode
   */
  public $useCode;

  /**
   * year prop was built
   * @var string $yearBuilt
   */
  public $yearBuilt;

  /**
   * lot size
   * @var string $lotSizeSqFt
   */
  public $lotSizeSqFt;

  /**
   * finished size
   * @var string $finishedSqFt
   */
  public $finishedSqFt;

  /**
   * date last sold
   * @var string $lastSoldDate
   */
  public $lastSoldDate;

  /**
   * Price last sold
   * @var string $lastSoldPrice
   */
  public $lastSoldPrice;

  /**
   * The zestimate which accompanies the property
   * @var Pillow_Zestimate $zestimate
   */
  public $zestimate;
  
  /**
   *
   * @param SimpleXMLElement $xml
   * @return Property 
   */
  public static function createFromXml($xml) {
    $prop = new Property();
    
    $prop->zpid = Xml::xstring($xml, '//result/zpid');
    $prop->street = Xml::xstring($xml, '//result/address/street');
    $prop->zipcode = Xml::xstring($xml, '//result/address/zipcode');
    $prop->city = Xml::xstring($xml, '//result/address/city');
    $prop->state = Xml::xstring($xml, '//result/address/state');
    $prop->latitude = Xml::xstring($xml, '//result/address/latitude');
    $prop->longitude = Xml::xstring($xml, '//result/address/longitude');
    $prop->links = new ArrayObject(array(
        'homedetails' => Xml::xstring($xml, '//result/links/homedetails'),
        'graphsanddata' => Xml::xstring($xml, '//result/links/graphsanddata'),
        'mapthishome' => Xml::xstring($xml, '//result/links/mapthishome'),
        'myestimator' => Xml::xstring($xml, '//result/links/myestimator'),
        'comparables' => Xml::xstring($xml, '//result/links/comparables'),
    ), ArrayObject::ARRAY_AS_PROPS);
    
    return $prop;
  }
}
