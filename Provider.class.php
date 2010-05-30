<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Provider.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Provider
 */

/**
 * Class RRoEmbed_Provider.
 * 
 * @todo       Description for class RRoEmbed_Provider.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Provider
{

    /**
     * Name
     *
     * @var string
     */
    protected $_name     = '';
    
    /**
     * URL
     *
     * @var string
     */
    protected $_url      = '';
    
    /**
     * URL Scheme
     *
     * @var RRoEmbed_URLScheme[]
     */
    protected $_schemes  = array();
    
    /**
     * API Endpoint
     *
     * @var string
     */
    protected $_endpoint = '';
    
    public function __construct( $endpoint, array $schemes = array(), $url = '', $name = '' )
    {
        foreach( $schemes as $key => $scheme )
        {
            if( !is_object( $scheme ) || !( $scheme instanceof RRoEmbed_URLScheme ) )
            {
                if( is_string( $scheme ) )
                {
                    $schemes[ $key ] = new RRoEmbed_URLScheme( $scheme );
                }
                else
                {
                    unset( $schemes[ $key ] );
                }
            }
        }
        
        $this->_endpoint = $endpoint;
        $this->_schemes  = $schemes;
        $this->_url      = $url;
        $this->_name     = $name;
    }
    
    /**
     * Check whether the given URL match one of the provider's schemes.
     *
     * @param string $url The URL to check against.
     * @return boolean
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function match( $url )
    {
        if( !$this->_schemes )
        {
            return TRUE;
        }
        
        foreach( $this->_schemes as $scheme )
        {
            if( $scheme->match( $url ) )
            {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    /**
     * Get the provider's name.
     *
     * @return string
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Get the provider's URL.
     *
     * @return string
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Get the provider's URL schemes.
     *
     * @return RRoEmbed_URLScheme[]
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getSchemes()
    {
        return $this->_schemes;
    }
    
    /**
     * Get the provider's API endpoint.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function getEndpoint()
    {
        return $this->_endpoint;
    }
    
}
