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

class SearchResults implements Iterator
{
  /**
   *
   * @var SplObjectStorage 
   */
  private $results;
  
  public function __construct() {
    $this->results = new SplObjectStorage();
  }
  
  public function current() {
    return $this->results->current();
  }

  public function key() {
    return $this->results->key();
  }

  public function next() {
    return $this->results->next();
  }

  public function rewind() {
    return $this->results->rewind();
  }

  public function valid() {
    return $this->results->valid();
  }

  
  /**
   *
   * @param SimpleXMLElement $xml 
   */
  public static function createFromXml($xml) {
    $results = new SearchResults();
    
    foreach($xml->xpath('//response/results') as $xmlResult) {
      $results->results->attach(SearchResult::createFromXml($xmlResult));
    }
    
    return $results;
  }
}