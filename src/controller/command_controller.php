<?php

abstract class CommandController extends Controller
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function render( AbstractXhtml $root )
    {

        // Set Status
        @header( sprintf( "HTTP/1.0 %d", $this->getStatusCode() ) );

    }

    // /FUNCTIONS


}

?>