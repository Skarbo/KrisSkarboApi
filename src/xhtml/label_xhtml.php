<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_label.asp
 */
class LabelXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $for;

    // CONSTRUCT


    // FUNCTIONS


    function getFor()
    {
        return $this->for;
    }

    /**
     * @return LabelXhtml
     */
    function for_( $for )
    {
        $this->for = $for;
        return $this;
    }

}

?>