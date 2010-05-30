<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Provider_Flickr.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider_Flickr
 */

/**
 * Class RRoEmbed_Provider_Flickr.
 * 
 * @todo       Description for class RRoEmbed_Provider_Flickr.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider_Flickr extends RRoEmbed_Provider
{
    
    public function __construct()
    {
        parent::__construct(
            'http://www.flickr.com/services/oembed',
            array(
                'http://*.flickr.com/*'
            ),
            'http://www.flickr.com',
            'Flickr'
        );
    }
    
}
