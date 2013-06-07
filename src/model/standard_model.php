<?php

interface StandardModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getId();

    public function setId( $id );

    public function getForeignId();

    /**
     * @return integer Last time modified
     */
    public function getLastModified();

    // /FUNCTIONS


}

?>