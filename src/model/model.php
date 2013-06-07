<?php

abstract class Model extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    function __construct( $a = array() )
    {
        // Set fields to object
        foreach ( Core::empty_( $a, array () ) as $k => $v )
        {
            $this->$k = $v;
        }
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


}

?>