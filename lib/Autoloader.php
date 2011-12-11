<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2011, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

class Autoloader
{
  private $basePath;
  
  public function __construct($basePath) {
    $this->basePath = $basePath;
  }
  
  public function autoLoad($className) {
    $filename = $this->basePath . '/' 
      . str_replace('\\', '/', str_replace('Pillow', '', $className)) 
      . '.php';
    if(file_exists($filename)) {
      require $filename;
    }
  }
}

$pillowAutoLoader = new Autoloader(__DIR__);
spl_autoload_register(array($pillowAutoLoader, 'autoload'));