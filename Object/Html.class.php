<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_Object_Html.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_Object_Html
 */

/**
 * Class RRoEmbed_Object_Html.
 * 
 * @todo       Description for class RRoEmbed_Object_Html.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_Object_Html extends RRoEmbed_Object_AbstractObject
{
    
    /**
     * HTML
     *
     * @var string
     */
    protected $_html   = 0;
    
    /**
     * Width
     *
     * @var integer
     */
    protected $_width  = 0;
    
    /**
     * Height
     *
     * @var integer
     */
    protected $_height = 0;
    
    public function getAsString()
    {
        return $this->_html;
    }
    
    public function getHtml()
    {
        return $this->_html;
    }
    
    public function setHtml( $html )
    {
        $this->_html = $html;
         
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
        
}