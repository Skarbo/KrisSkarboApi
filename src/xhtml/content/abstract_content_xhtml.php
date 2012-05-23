<?php

/**
 * Abstract Xhtml elements with content as parameter
 *
 * @author Kris Skarbo
 *
 */
abstract class AbstractContentXhtml extends AbstractXhtml
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @param string $content Content [, content]
     */
    public function __construct( $content = "", $_ = NULL )
    {
        parent::__construct();
        $this->content( implode( "", func_get_args() ) );
    }

    // /CONSTRUCTOR


// FUNCTIONS


// /FUNCTIONS


}

?>