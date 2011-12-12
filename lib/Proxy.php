<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Proxy
{
  private $service;
  
  private $method;
  
  private $args;
  
  public function __construct($service, $method, $args) {
    $this->service = $service;
    $this->method = $method;
    $this->args = $args;
  }
  
  public function __get($name) {
    $obj = call_user_func_array(array($this->service, $this->method), $this->args);
    return $obj->$name;
  }
}