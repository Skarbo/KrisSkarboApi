<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_legend.asp
 */
class LegendXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $align;

    // CONSTRUCT


    // FUNCTIONS


    function getAlign()
    {
        return $this->align;
    }

    function align( $align )
    {
        $this->align = $align;
        return $this;
    }

}

?>