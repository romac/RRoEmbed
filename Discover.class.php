<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Discover.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Discover
 */

/**
 * Class RRoEmbed_Discover.
 * 
 * @todo       Description for class RRoEmbed_Discover.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Discover
{
    
    /**
     * From Services_oEmbed (Services/oEmbed.php:304).
     */
    const LINK_REGEX = '#<link(?:[^>]*)type="(?P<Format>@formats@)\+oembed"(?P<Attributes>[^>]*)>#i';
    
    /**
     * Cached endpoints.
     *
     * @var string[]
     */
    protected $_cachedEndpoints = array();
    
    /**
     * Supported formats
     *
     * @var string
     */
    protected $_supportedFormats = array(
        'application/json',
        'text/xml'
    );
    
    /**
     * Preferred format
     *
     * @var string
     */
    protected $_preferredFormat = 'application/json';
    
    public function getEndpointForUrl( $url )
    {
        if( !isset( $this->_cachedEndpoints[ $url ] ) ) {
            
            $this->_cachedEndpoints[ $url ] = $this->_fetchEndpointForUrl( $url );
        }
        
        return $this->_cachedEndpoints[ $url ];
    }
    
    protected function _fetchEndpointForUrl( $url )
    {
        $request = new RRoEmbed_Request( $url );
        
        try {
            
            $body = $request->send();
        
        } catch( Exception $e ) {
            
            throw new Exception(
                'Unable to fetch the page body for "' . $url . '".'
            );
        }
        
        $regEx = str_replace(
            '@formats@',
            implode( '|', $this->_supportedFormats ),
            self::LINK_REGEX
        );
        
        if( !preg_match_all( $regEx, $body, $matches, PREG_SET_ORDER ) ) {
            
            throw new Exception(
                'No valid oEmbed links found on page.'
            );
        }
        
        foreach( $matches as $match ) {
            
            if( $match[ 'Format' ] === $this->_preferredFormat ) {
                
                return $this->_extractEndpointFromAttributes( $match[ 'Attributes' ] );
            }
        }
        
        return $this->_extractEndpointFromAttributes( $match[ 'Attributes' ] );
    }
    
    protected function _extractEndpointFromAttributes( $attributes )
    {
        if( !preg_match( '/href="([^"]+)"/i', $attributes, $matches ) ) {
            
            throw new Exception(
                'No "href" attribute in <link> tag.'
            );
        }
        
        return $matches[ 1 ];
    }
    
}