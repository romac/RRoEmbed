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
 * Source file containing class Resource\Photo.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed\Resource\Photo
 */
 
// Namespace declaration.
namespace RRoEmbed\Resource;

/**
 * Class  RRoEmbed\Resource\Photo.
 * 
 * @todo       Description for class Resource\Photo.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class Photo extends AbstractResource
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
