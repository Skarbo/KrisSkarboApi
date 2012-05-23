<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_tfoot.asp
 */
class TfootXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $align;
    protected $valign;

    // CONSTRUCT


    // FUNCTIONS


    function getAlign()
    {
        return $this->align;
    }

    /**
     * @param string $align
     * @return TfootXhtml
     */
    function align( $align )
    {
        $this->align = $align;
        return $this;
    }

    function getValign()
    {
        return $this->valign;
    }

    /**
     * @param string $valign
     * @return TfootXhtml
     */
    function valign( $valign )
    {
        $this->valign = $valign;
        return $this;
    }

}

?>