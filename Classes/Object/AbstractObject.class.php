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
 * Source file containing class RRoEmbed_Object_AbstractObject.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Object_AbstractObject
 */

/**
 * Class RRoEmbed_Object_AbstractObject.
 * 
 * @todo       Description for class RRoEmbed_Object_AbstractObject.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
abstract class RRoEmbed_Object_AbstractObject
{
    
    /**
     * The resource type
     *
     * @var string
     */
    protected $_type = '';
    
    /**
     * Version
     *
     * @var string
     */
    protected $_version = '1.0';
    
    /**
     * Title
     *
     * @var string
     */
    protected $_title = '';
    
    /**
     * Author Name
     *
     * @var string
     */
    protected $_authorName = '';
    
    /**
     * Author URL
     *
     * @var string
     */
    protected $_authorUrl = '';
    
    /**
     * ProviderName
     *
     * @var string
     */
    protected $_providerName = '';
    
    /**
     * ProviderUrl
     *
     * @var string
     */
    protected $_providerUrl = '';
    
    /**
     * Cache Age
     *
     * @var integer+
     */
    protected $_cacheAge = 0;
    
    /**
     * Thumbnail URL
     *
     * @var string
     */
    protected $_thumbnailUrl = '';
    
    /**
     * Thumbnail Width
     *
     * @var integer
     */
    protected $_thumbnailWidth = 0;
    
    /**
     * Thumbnail Height
     *
     * @var integer
     */
    protected $_thumbnailHeight = '';
    
    abstract public function getAsString();
    
    public function __toString()
    {
        return $this->getAsString();
    }
    
    public function getType()
    {
        return $this->_type;
    }
    
    public function setType( $type )
    {
        $this->_type = $type;
         
        return $this;
    }
    
    public function getVersion()
    {
        return $this->_version;
    }

    public function setVersion( $version )
    {
        $this->_version = $version;
         
        return $this;
    }
    
    public function getTitle()
    {
        return $this->_title;
    }
    
    public function setTitle( $title )
    {
        $this->_title = $title;
         
        return $this;
    }
    
    public function getAuthorName()
    {
        return $this->_authorName;
    }
    
    public function setAuthorName( $authorName )
    {
        $this->_authorName = $authorName;
         
        return $this;
    }
    
    public function getAuthorUrl()
    {
        return $this->_authorUrl;
    }
    
    public function setAuthorUrl( $authorUrl )
    {
        $this->_authorUrl = $authorUrl;
         
        return $this;
    }
    
    public function getProviderName()
    {
        return $this->_providerName;
    }

    public function setProviderName( $providerName )
    {
        $this->_providerName = $providerName;
         
        return $this;
    }
    
    public function getProviderUrl()
    {
        return $this->_providerUrl;
    }

    public function setProviderUrl( $providerUrl )
    {
        $this->_providerUrl = $providerUrl;
         
        return $this;
    }
    
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    public function setThumbnailUrl( $thumbnailUrl )
    {
        $this->_thumbnailUrl = $thumbnailUrl;
         
        return $this;
    }
    
    public function getThumbnailWidth()
    {
        return $this->_thumbnailWidth;
    }
    
    public function setThumbnailWidth( $thumbnailWidth )
    {
        $this->_thumbnailWidth = $thumbnailWidth;
         
        return $this;
    }
    
    public function getThumbnailHeight()
    {
        return $this->_thumbnailHeight;
    }
    
    public function setThumbnailHeight( $thumbnailHeight )
    {
        $this->_thumbnailHeight = $thumbnailHeight;
         
        return $this;
    }
    
    public static function factory( $resource )
    {
        $type      = $resource->type;
        $className = 'RRoEmbed_Object_' . ucfirst( strtolower( $type ) );
        
        if( !class_exists( $className ) )
        {
            throw new Exception(
                'Unknown resource type "' . $type .'".'
            );
        }
        
        $object = new $className();
        
        foreach( $resource as $property => $value )
        {
            $setterMethodName = 'set' . self::_underscoreToUpperCamelCase( $property );
            
            if( !method_exists( $object, $setterMethodName ) && !method_exists( $object, '__call' )  ) {
                
                continue;
            }
            
            $object->$setterMethodName( $value );
        }
        
        return $object;
    }
    
    protected function _underscoreToCamelCase( $string )
    {
        return lcfirst( self::_underscoreToCamelCase( $string ) );
    }
    
    protected static function _underscoreToUpperCamelCase( $string )
    {
        return str_replace( ' ', '', ucwords( str_replace( '_', ' ', $string ) ) );
    }
    
}