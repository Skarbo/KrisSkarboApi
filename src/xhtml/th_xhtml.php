<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_th.asp
 */
class ThXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    protected $align;
    protected $colspan;
    protected $rowspan;
    protected $valign;
    
    // CONSTRUCT
    

    // FUNCTIONS
    

    function getAlign() {
        return $this->align;
    }

    /**
     * @return ThXhtml
     */
    function align( $align ) {
        $this->align = $align;
        return $this;
    }

    function getColspan() {
        return $this->colspan;
    }

    /**
     * @return ThXhtml
     */
    function colspan( $colspan ) {
        $this->colspan = $colspan;
        return $this;
    }

    function getRowspan() {
        return $this->rowspan;
    }

    /**
     * @return ThXhtml
     */
    function rowspan( $rowspan ) {
        $this->rowspan = $rowspan;
        return $this;
    }

    function getValign() {
        return $this->valign;
    }

    /**
     * @return ThXhtml
     */
    function valign( $valign ) {
        $this->valign = $valign;
        return $this;
    }

}

?>