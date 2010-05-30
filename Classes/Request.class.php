<?php

/*
 * Copyright (c) 2010 Romain Ruetschi <romain.ruetschi@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Source file containing class RRoEmbed_Request.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
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
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
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