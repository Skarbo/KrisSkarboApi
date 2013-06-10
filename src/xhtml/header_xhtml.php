<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_hn.asp
 */
class HeaderXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    // CONSTRUCT
    

    /**
     * @param int $size
     * @param string $content
     */
    function __construct( $size, $content = "" ) {
        parent::__construct( $content );
        $this->set_code( "h" . $size );
    }
    
    // FUNCTIONS


}

?>