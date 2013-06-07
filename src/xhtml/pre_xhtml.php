<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_pre.asp
 */
class PreXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $width;

    // CONSTRUCT


    // FUNCTIONS


    function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return PreXhtml
     */
    function width( $width )
    {
        $this->width = $width;
        return $this;
    }

}

?>