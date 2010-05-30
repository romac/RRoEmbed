<?php

/*
 * Copyright (c) 2009, Romain Ruetschi <romain.ruetschi@gmail.com>
 * Code licensed under the BSD License:
 * See http://opensource.org/licenses/bsd-license.php
 */

/**
 * Source file containing class RRoEmbed_URLScheme.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
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
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
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