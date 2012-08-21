<?php

abstract class View extends ClassCore
{

    // VARIABLES


    const QUERY_NOCACHE = "nocache";

    /**
     * @var Controller
     */
    private $controller;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController( Controller $controller )
    {
        $this->controller = $controller;
    }

    // ... GETTERS/SETTERS


    // ... GET


    /**
     * Last time modified
     *
     * @return integer Last modified, null if no date
     */
    protected function getLastModified()
    {
        return filemtime( __FILE__ );
    }

    /**
     * @param boolean $force True if not return null
     * @return int Mode, null if mode is default mode
     */
    protected function getMode( $force = false )
    {
        if ( $force )
        {
            return $this->getController()->getMode();
        }
        return $this->getController()->getMode() == $this->getController()->getModeDefault() ? null : $this->getController()->getMode();
    }

    /**
     * @return AbstractDefaultLocale
     */
    protected function getLocale()
    {
        return $this->getController()->getLocale();
    }

    // ... /GET


    // ... IS


    protected function isNoCache()
    {
        return array_key_exists( self::QUERY_NOCACHE, Controller::getQuery() );
    }

    // ... /IS


    /**
     * Called before draw
     */
    public function before()
    {
    }

    /**
     * Called at draw
     *
     * @param AbstractXhtml $root
     */
    public function draw( AbstractXhtml $root )
    {

        // Last modified
        $last_modified_time = $this->getLastModified();

        if ( $last_modified_time && !$this->isNoCache() )
        {
            // Set last modified
            @header( sprintf( "Last-Modified: %s GMT", gmdate( "D, d M Y H:i:s", $last_modified_time ) ) );

            // Get if modified since
            $if_modified_since = Controller::getIfModifiedSinceHeader();

            // Set status if not modified since
            if ( $last_modified_time <= $if_modified_since )
            {
                @header( "HTTP/1.1 304 Not Modified" );
                exit();
            }
        }

    }

    /**
     * Called after draw
     */
    public function after()
    {
    }

    /**
     * @see ClassCore::get_()
     * @return View
     */
    public static function get_( $get )
    {
        return $get;
    }

    // /FUNCTIONS


}

?>