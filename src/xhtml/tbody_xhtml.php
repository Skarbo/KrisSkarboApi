<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_tbody.asp
 */
class TbodyXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    protected $align;
    protected $valign;
    
    // CONSTRUCT
    

    // FUNCTIONS
    

    function getAlign() {
        return $this->align;
    }

    function align( $align ) {
        $this->align = $align;
        return $this;
    }

    function getValign() {
        return $this->valign;
    }

    function valign( $valign ) {
        $this->valign = $valign;
        return $this;
    }

}

?>