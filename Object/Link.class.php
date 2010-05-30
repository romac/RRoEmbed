<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Object_Link.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Object_Link
 */

/**
 * Class RRoEmbed_Object_Link.
 * 
 * @todo       Description for class RRoEmbed_Object_Link.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Object_Link extends RRoEmbed_Object_AbstractObject
{
    
    public function getAsString()
    {
        return $this->_title;
    }
    
}