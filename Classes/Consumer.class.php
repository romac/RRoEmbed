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
 * @license    http://opensource.org/licenses/mit-license.html MIT License
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
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Consumer
{
    
    /**
     * JSON format.
     */
    const FORMAT_JSON    = 'json';
    
    /**
     * XML format.
     */
    const FORMAT_XML     = 'xml';
    
    /**
     * Default format.
     */
    const FORMAT_DEFAULT = self::FORMAT_JSON;
    
    /**
     * Providers
     *
     * @var Provider[]
     */
    protected $_providers = array();
    
    /**
     * Set the available providers.
     *
     * @param array $providers   An array of the available providers.
     *
     * @return RRoEmbed_Consumer A reference to this instance.
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function setProviders( array $providers )
    {
        $this->_providers = $providers;
         
        return $this;
    }
    
    /**
     * Consume an oEmbed resource using the specified provider if supplied
     * or try to discover the right one.
     *
     * @param  string            $url         The URL of the resource to consume.
     * @param  RRoEmbed_Provider $provider    The provider to use.
     * @param  string            $format      The format of the data to fetch.
     *
     * @return RRoEmbed_Resource_AbstractResource
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function consume( $url, RRoEmbed_Provider $provider = NULL, $format = self::FORMAT_DEFAULT )
    {
        // Try to find a provider matching the supplied URL if no one has been supplied.
        if( !$provider )
        {
            $provider = $this->_findProviderForUrl( $url );
        }
        
        if( $provider )
        {
            // If a provider was supplied or we found one, store the endpoint URL.
            $endPoint = $provider->getEndpoint();
        }
        else
        {
            // If no provider was found, try to discover the endpoint URL.
            $discover = new RRoEmbed_Discoverer();
            $endPoint = $discover->getEndpointForUrl( $url );
        }
        
        $requestUrl = $this->_buildOEmbedRequestUrl( $url, $endPoint, $format );
        $request    = new RRoEmbed_Request( $requestUrl );
        $body       = $request->send();
        
        $methodName = '_process' . ucfirst( strtolower( $format ) ) . 'Response';
        
        return $this->$methodName( $body );
    }
    
    /**
     * Process the JSON response returned by the provider.
     *
     * @param string $response The JSON data returned by the provider.
     *
     * @return RRoEmbed_Resource_AbstractResource
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function _processJsonResponse( $response )
    {
        return RRoEmbed_Resource_AbstractResource::factory(
            json_decode( $response )
        );
    }
    
    /**
     * Process the XML response returned by the provider.
     *
     * @param string $response The XML data returned by the provider.
     *
     * @return RRoEmbed_Resource_AbstractResource
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function _processXmlResponse( $response )
    {
        return RRoEmbed_Resource_AbstractResource::factory(
            simplexml_load_string( $response )
        );
    }
    
    /**
     * Build the oEmbed request URL according to the specification.
     *
     * @link  http://www.oembed.com/
     * 
     * @param string $resource The URL of the resource to fetch.
     * @param string $endPoint The provider endpoint URL
     * @param string $format   The format of the response we'd like to receive.
     * 
     * @return string
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function _buildOEmbedRequestUrl( $resource, $endPoint, $format = self::FORMAT_DEFAULT )
    {
        $parameters = array(
            'url'    => $resource,
            'format' => $format
        );
        
        $uriParams  = http_build_query( $parameters, '', '&' );
        
        return http_build_url( $endPoint, array( 'query' => $uriParams ) );
    }
    
    /**
     * Find an oEmbed provider matching the supplied URL.
     *
     * @param  string $url The URL to find an oEmbed provider for.
     * 
     * @return RRoEmbed_Provider
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
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
