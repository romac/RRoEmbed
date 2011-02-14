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
 * Source file containing class Autoloader.
 * 
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 * @see        RRoEmbed\Autoloader
 */
 
// Namespace declaration.
namespace RRoEmbed;

/**
 * Class  RRoEmbed\Autoloader.
 * 
 * @todo       Description for class Autoloader.
 *
 * @package    RRoEmbed
 * @license    http://opensource.org/licenses/mit-license.html MIT License
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    0.1
 */
class Autoloader
{
    
    /**
     * A reference to the unique class instance.
    *
     * @var RRoEmbed\Autoloader object.
     */
    private static $_instance    = NULL;
    
    /**
     * The path to the directory where the classes are stored.
     *
     * @var string
     */
    protected $_classesDirectory = '';
    
    /**
     * Class constructor.
     * The constructor of this class cannot be used to instanciate a RRoEmbed\Autoloader object.
     * This class is a singleton class, this means that there is only one instance
     * of the RRoEmbed\Autoloader class and this instance is shared by every one who does a call
     * to RRoEmbed\Autoloader::getInstance().
     *
     * @see getInstance to know how to create the RRoEmbed\Autoloader instance or to get a reference to it.
     */
    private function __construct()
    {
        $this->_classesDirectory = __DIR__ . DIRECTORY_SEPARATOR;
    }
    
    /**
     * Creates or returns the only instance of the RRoEmbed\Autoloader class.
     *
     * @return RRoEmbed\Autoloader the only instance of the RRoEmbed\Autoloader class.
     */
    public static function getInstance()
    {
        if( !is_object( self::$_instance ) )
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    /**
     * Create a clone of the instance.
     * Because this class is a singleton class, there can exists only one
     * instance of this class.
     * So this method will throw an exception if someone tries to call it.
     *
     * @throws BadMethodCallException An new BadMethodCallException instance
     * @return void
     */
    final public function __clone()
    {
        throw new \BadMethodCallException(
            'This class is a singleton class, you are not allowed to clone it.' . "\n" .
            'Please call ' . get_class( $this ) . '::getInstance() to get a reference to ' .
            'the only instance of this class.'
        );
    }

    /**
     * This method is called when unserialize is called on a serialized representation
     * of an instance of this class.
     * Because this class is a singleton class, there can exists only one
     * instance of this class.
     * So this method will throw an exception if someone tries to call it.
     *
     * @throws BadMethodCallException An new BadMethodCallException instance
     * @return void
     */
    final public function __wakeup()
    {
        throw new \BadMethodCallException(
            'This class is a singleton class, you are not allowed to unserialize ' .
            'it as this could create a new instance of it.' . "\n" .
            'Please call ' . get_class( $this ) . '::getInstance() to get a reference to ' .
            'the only instance of this class.'
        );
    }
    
    /**
     * Register the loadClass method of this class as an SPL Autoload callback.
     *
     * @return boolean
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function register()
    {
        if( !function_exists( 'spl_autoload_register' ) )
        {
            require_once( $this->_classesDirectory . 'Exception.class.php' );
            
            throw new \RuntimeException(
                'The SPL extension is not loaded, you need to load it in order '
              . 'to use this library.'
            );
        }
        
        return spl_autoload_register( array( $this, 'loadClass' ) );
    }
    
    /**
     * Unregister the SPL Autoload callback.
     *
     * @return boolean
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function unregister()
    {
        if( !function_exists( 'spl_autoload_unregister' ) )
        {
            require_once( $this->_classesDirectory . 'Exception.class.php' );
            
            throw new \RuntimeException(
                'The SPL extension is not loaded, you need to load it in order '
              . 'to use this library.'
            );
        }
        
        return spl_autoload_unregister( array( $this, 'loadClass' ) );
    }
    
    /**
     * Load the specified RRoEmbed class.
     *
     * @param  string $className The name of the class to load.
     * @return boolean TRUE if the class has been successfully loaded, FAlSE otherwise.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function loadClass( $className )
    {
        if( strpos( $className, 'RRoEmbed' ) !== 0 )
        {
            return FALSE;
        }
        
        if( class_exists( $className, FALSE ) || interface_exists( $className, FALSE ) )
        {
            return TRUE;
        }
        
        $fileName = $this->_classesDirectory
                  . str_replace( '\\', DIRECTORY_SEPARATOR, substr( $className, 9 ) )
                  . '.class.php';
        
        if( !file_exists( $fileName ) )
        {
            return FALSE;
        }
        
        require_once( $fileName );
        
        return class_exists( $className, FALSE ) || interface_exists( $className, FALSE );
    }
    
}