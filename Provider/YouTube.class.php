<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Provider_YouTube.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider_YouTube
 */

/**
 * Class RRoEmbed_Provider_YouTube.
 * 
 * @todo       Description for class RRoEmbed_Provider_YouTube.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider_YouTube extends RRoEmbed_Provider
{
    
    public function __construct()
    {
        parent::__construct(
            'http://www.youtube.com/oembed',
            array(
                'http://*.youtube.com/*'
            ),
            'http://www.youtube.com',
            'YouTube'
        );
    }
    
}
