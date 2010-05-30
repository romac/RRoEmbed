<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Provider_Vimeo.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider_Vimeo
 */

/**
 * Class RRoEmbed_Provider_Vimeo.
 * 
 * @todo       Description for class RRoEmbed_Provider_Vimeo.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider_Vimeo extends RRoEmbed_Provider
{
    
    public function __construct()
    {
        parent::__construct(
            'http://www.vimeo.com/api/oembed.json',
            array(
                'http://*.vimeo.com/*',
                'http://*.vimeo.com/groups/*/*'
            ),
            'http://www.vimeo.com',
            'Vimeo'
        );
    }
    
}
