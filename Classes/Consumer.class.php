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
 * Source file containing class RRoEmbed_Consumer.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Consumer
 */

/**
 * Class RRoEmbed_Consumer.
 * 
 * @todo       Description for class RRoEmbed_Consumer.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Consumer
{
    
    const FORMAT_JSON    = 'json';
    const FORMAT_XML     = 'xml';
    const FORMAT_DEFAULT = self::FORMAT_JSON;
    
    /**
     * Providers
     *
     * @var Provider[]
     */
    protected $_providers = array();
    
    public function setProviders( array $providers )
    {
        $this->_providers = $providers;
         
        return $this;
    }
    
    public function consume( $url, RRoEmbed_Provider $provider = NULL, $format = self::FORMAT_DEFAULT )
    {
        if( !$provider )
        {
            $provider = $this->_findProviderForUrl( $url );
        }
        
        if( $provider )
        {
            $endPoint = $provider->getEndpoint();
        }
        else
        {
            $discover = new RRoEmbed_Discover();
            $endPoint = $discover->getEndpointForUrl( $url );
        }
        
        $requestUrl = $this->_buildOEmbedRequestUrl( $url, $endPoint, $format );
        $request    = new RRoEmbed_Request( $requestUrl );
        $body       = $request->send();
        
        $methodName = '_process' . ucfirst( strtolower( $format ) ) . 'Response';
        
        return $this->$methodName( $body );
    }
    
    protected function _processJsonResponse( $response )
    {
        return RRoEmbed_Object_AbstractObject::factory(
            json_decode( $response )
        );
    }
    
    protected function _processXmlResponse( $response )
    {
        return RRoEmbed_Object_AbstractObject::factory(
            simplexml_load_string( $response )
        );
    }
    
    protected function _buildOEmbedRequestUrl( $resource, $endPoint, $format = self::FORMAT_DEFAULT )
    {
        $parameters = array(
            'url'    => $resource,
            'format' => $format
        );
        
        $uriParams  = http_build_query( $parameters, '', '&' );
        
        return http_build_url( $endPoint, array( 'query' => $uriParams ) );
    }
    
    protected function _findProviderForUrl( $url )
    {
        foreach( $this->_providers as $provider )
        {
            if( $provider->match( $url ) )
            {
                return $provider;
            }
        }
        
        return NULL;
    }
    
}
