<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_table.asp
 */
class TableXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    protected $border;
    protected $cellpadding = 0;
    protected $cellspacing = 0;
    protected $width;
    
    // CONSTRUCT
    

    // FUNCTIONS
    

    function getBorder() {
        return $this->border;
    }

    /**
     * @return XHTMLtable
     */
    function border( $border ) {
        $this->border = $border;
        return $this;
    }

    function getCellpadding() {
        return $this->cellpadding;
    }

    /**
     * @return XHTMLtable
     */
    function cellpadding( $cellpadding ) {
        $this->cellpadding = $cellpadding;
        return $this;
    }

    function getCellspacing() {
        return $this->cellspacing;
    }

    /**
     * @return XHTMLtable
     */
    function cellspacing( $cellspacing ) {
        $this->cellspacing = $cellspacing;
        return $this;
    }

    function getWidth() {
        return $this->width;
    }

    /**
     * @return XHTMLtable
     */
    function width( $width ) {
        $this->width = $width;
        return $this;
    }

}

?>