<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Pillow;

use \DateTime;

class Date extends DateTime
{
  public function __toString() {
    return $this->format('m/d/Y');
  }
}