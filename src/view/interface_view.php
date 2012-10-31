<?php

interface InterfaceView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    /**
     * @param boolean $force True if not return null
     * @return int Mode, null if mode is default mode
     */
    public function getMode( $force = false );

    /**
     * @return AbstractDefaultLocale
     */
    public function getLocale();

    // /FUNCTIONS


}

?>