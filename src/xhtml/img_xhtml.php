<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/html_img.asp
 */
class ImgXhtml extends AbstractXhtml
{

    // VARIABLES


    protected $src;
    protected $alt;

    // CONSTRUCT


    function __construct( $src = "", $alt = "" )
    {
        $this->set_endTag( false );
        $this->src( $src );
        $this->alt( $alt );
        parent::__construct();
    }

    // FUNCTIONS


    function getSrc()
    {
        return $this->src;
    }

    /**
     * @return ImgXhtml
     */
    function src( $src )
    {
        $this->src = $src;
        return $this;
    }

    function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return ImgXhtml
     */
    function alt( $alt )
    {
        $this->alt = $alt;
        return $this;
    }

}

?>