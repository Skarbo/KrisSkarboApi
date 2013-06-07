<?php

abstract class AbstractView extends ClassCore implements InterfaceView
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
     * @see InterfaceView::getController()
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController( AbstractController $controller )
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

    public function getMode( $force = false )
    {
        return $this->getController()->getMode( !$force );
    }

    public function getLocale()
    {
        return $this->getController()->getLocale();
    }

    // ... /GET


    // ... IS


    protected function isNoCache()
    {
        return array_key_exists( self::QUERY_NOCACHE, AbstractController::getQuery() );
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
//             $expires = 60 * 60 * 24;
            @header( sprintf( "Last-Modified: %s GMT", gmdate( "D, d M Y H:i:s", $last_modified_time ) ) );
//             @header( "Cache-Control: maxage=" . $expires );
//             @header( "Pragma: public" );
//             @header( sprintf( "Expires: %s GMT", gmdate( 'D, d M Y H:i:s', time() + $expires ) ) );

            // Get if modified since
            $if_modified_since = AbstractController::getIfModifiedSinceHeader();

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