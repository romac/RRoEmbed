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
 * Source file containing class RRoEmbed_URLScheme.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed_URLScheme
 */

/**
 * Class RRoEmbed_URLScheme.
 * 
 * @todo       Description for class RRoEmbed_URLScheme.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.html New BSD License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class RRoEmbed_URLScheme
{
    
    const WILDCARD_CHARACTER = '*';
    
    /**
     * Scheme
     *
     * @var string
     */
    protected $_scheme = '';
    
    /**
     * Regular Expression Pattern.
     *
     * @var string
     */
    protected $_pattern  = '';
    
    public function __construct( $scheme )
    {
        if( !is_string( $scheme ) )
        {
            throw new InvalidArgumentException(
                '$scheme must be a string.'
            );
        }
        
        $this->_scheme = $scheme;
    }
    
    public function __toString()
    {
        return $this->_scheme;
    }
    
    public function match( $url )
    {
        if( !$this->_pattern )
        {
            $this->_pattern = self::_buildPatternFromScheme( $this );
        }
        
        return ( bool )preg_match( $this->_pattern, $url );
    }
    
    static protected function _buildPatternFromScheme( self $scheme )
    {
        // Generate a unique random string.
        $uniq    = md5( mt_rand() );
        
        // Replace the wildcard sub-domain if exists.
        $scheme = str_replace(
            '://' . self::WILDCARD_CHARACTER . '.',
            '://' . $uniq,
            $scheme->getScheme()
        );
        
        // Replace the wildcards.
        $scheme = str_replace(
            self::WILDCARD_CHARACTER,
            $uniq,
            $scheme
        );
        
        // Set the pattern wrap.
        $wrap = '|';
        
        // Quote the pattern,
        $pattern = preg_quote( $scheme, $wrap );
        
        // Replace the unique string by the character class.
        $pattern = str_replace( $uniq, '.*', $pattern );
        
        // Return the wrapped pattern.
        return $wrap . $pattern . $wrap . 'iu';
    }
    
    public function getScheme()
    {
        return $this->_scheme;
    }
    
}