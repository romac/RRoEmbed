<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Request.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Request
 */

/**
 * Class RRoEmbed_Request.
 * 
 * @todo       Description for class RRoEmbed_Request.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Request
{
    
    const OPTION_TIMEOUT    = 'http_timeout';
    const OPTION_USER_AGENT = 'http_user_agent';
    
    /**
     * URL
     *
     * @var string
     */
    protected $_url     = '';
    
    /**
     * Options
     *
     * @var array
     */
    protected $_options = array(
        self::OPTION_TIMEOUT    => 5,
        self::OPTION_USER_AGENT => 'RRoEmbed 0.1'
    );
    
    public function __construct( $url, array $options = array() )
    {
        $this->_url = $url;
        
        if( $options )
        {
            $this->_options = array_merge( $this->_options, $options );
        }
    }
    
    public function send()
    {
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_URL,            $this->_url );
        curl_setopt( $ch, CURLOPT_HEADER,         FALSE );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $this->_options[ self::OPTION_TIMEOUT ] );
        curl_setopt( $ch, CURLOPT_USERAGENT,      $this->_options[ self::OPTION_USER_AGENT ] );
        
        $body = curl_exec( $ch );
        
        if( curl_errno( $ch ) ) {
            
            throw new Exception(
                curl_error( $ch ), curl_errno( $ch )
            );
        }
        
        $code = ( int )curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        
        if ( !$this->_isValidResponseCode( $code ) )
        {
            throw new Exception( 'Expecting a 2XX HTTP status, got ' . $code . '.' );
        }
        
        return $body;
    }
    
    protected function _isValidResponseCode( $code )
    {
        return ( int )floor( $code / 100 ) === 2;
    }
    
}