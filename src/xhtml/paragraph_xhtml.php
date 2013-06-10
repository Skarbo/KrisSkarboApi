<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_p.asp
 */
class ParagraphXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    protected $align;
    
    // CONSTRUCT
    

    public function __construct( $content = "" ) {
        $this->set_code( "p" );
        parent::__construct( $content );
    }
    
    // FUNCTIONS
    

    function getAlign() {
        return $this->align;
    }

    /**
     * @param string $align
     * @return ParagraphXhtml
     */
    function align( $align ) {
        $this->align = $align;
        return $this;
    }

}

?>