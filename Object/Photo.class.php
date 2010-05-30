<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Object_Photo.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Object_Photo
 */

/**
 * Class RRoEmbed_Object_Photo.
 * 
 * @todo       Description for class RRoEmbed_Object_Photo.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Object_Photo extends RRoEmbed_Object_AbstractObject
{

    /**
     * URL
     *
     * @var string
     */
    protected $_url = '';
    
    /**
     * Width
     *
     * @var integer
     */
    protected $_width = 0;
    
    /**
     * Height
     *
     * @var integer
     */
    protected $_height = 0;
    
    public function getUrl()
    {
        return $this->_url;
    }
    
    public function setUrl( $url )
    {
        $this->_url = $url;
         
        return $this;
    }
    
    public function getWidth()
    {
        return $this->_width;
    }
    
    public function setWidth( $width )
    {
        $this->_width = $width;
         
        return $this;
    }
    
    public function getHeight()
    {
        return $this->_height;
    }
    
    public function setHeight( $height )
    {
        $this->_height = $height;
         
        return $this;
    }
    
    public function getAsString()
    {
        $attributes = array(
            'src'    => $this->_url,
            'alt'    => $this->_title,
            'height' => ( $this->_height ) ? $this->_height : '',
            'width'  => ( $this->_width ) ? $this->_width   : ''
        );
        
        $html = '<img ';
        
        foreach( $attributes as $attribute => $value )
        {
            $html .= $attribute . '="' . $value . '" ';
        }
        
        $html .= '/>';
        
        return $html;
    }
    
}
