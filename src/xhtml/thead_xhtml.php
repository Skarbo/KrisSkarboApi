<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_thead.asp
 */
class TheadXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    protected $align;
    protected $valign;
    
    // CONSTRUCT
    

    // FUNCTIONS
    

    function getAlign() {
        return $this->align;
    }

    /**
     * @param string $align
     * @return TheadXhtml
     */
    function align( $align ) {
        $this->align = $align;
        return $this;
    }

    function getValign() {
        return $this->valign;
    }

    /**
     * @param string $valign
     * @return TheadXhtml
     */
    function valign( $valign ) {
        $this->valign = $valign;
        return $this;
    }

}

?>