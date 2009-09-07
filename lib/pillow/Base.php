<?php
/**
 * @author Rob Apodaca <rob.apodaca@gmail.com>
 * @copyright Copyright (c) 2009, Rob Apodaca
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class Pillow_Base
{
    /**
     * The factory object used to create new object inside this object
     * @var Pillow_Factory $_factory
     */
    protected $_factory;

    /**
     * Sets the factory object
     * @param Pillow_Factory $factory
     */
    public function setFactory( Pillow_Factory $factory )
    {
        $this->_factory = $factory;
    }

    
}


