<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \SimpleXMLElement;
use \SplObjectStorage;
use \Iterator;
use \ArrayAccess;
use \Exception;

class SearchResults implements Iterator, ArrayAccess
{
  /**
   *
   * @var array[int]Property 
   */
  private $properties;
  
  private $key;
  
  public function __construct() {
    $this->properties = array();
    $this->key = 0;
  }
  
  /**
   *
   * @return Property 
   */
  public function current() {
    if(isset($this->properties[$this->key])) {
      return $this->properties[$this->key];
    } else {
      return new Property;
    }
  }

  public function key() {
    return $this->key;
  }

  public function next() {
    $this->key++;
  }

  public function rewind() {
    $this->key = 0;
  }

  public function valid() {
    return (isset($this->properties[$this->key]));
  }
  
  public function offsetExists($offset) {
    return (isset($this->properties[$offset]));
  }

  public function offsetGet($offset) {
    return $this->properties[$offset];
  }

  public function offsetSet($offset, $value) {
    throw new Exception('Unable to set ArrayAccess offset; read-only object');
  }

  public function offsetUnset($offset) {
    throw new Exception('Unable to unset ArrayAccess offset; read-only object');
  }

  
  /**
   *
   * @param SimpleXMLElement $xml 
   * @return SearchResults
   */
  public static function createFromXml($xml) {
    $results = new SearchResults();
    
    foreach($xml->xpath('//response/results') as $xmlResult) {
      $results->properties[] = Property::createFromXml($xmlResult);
    }
    
    return $results;
  }
}