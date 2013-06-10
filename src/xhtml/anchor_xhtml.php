<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_a.asp
 */
class AnchorXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    static $TARGET_BLANK = "_blank";
    
    protected $href;
    protected $target;
    protected $name;
    
    // CONSTRUCT
    

    public function __construct( $content = "", $href = "" ) {
        $this->set_code( "a" );
        if ( $href )
            $this->href( $href );
        parent::__construct( $content );
    }
    
    // FUNCTIONS
    

    function getHref() {
        return $this->href;
    }

    /**
     * @return AnchorXhtml
     */
    function href( $href ) {
        $this->href = $href;
        return $this;
    }

    function getTarget() {
        return $this->target;
    }

    /**
     * @return AnchorXhtml
     */
    function target( $target ) {
        $this->target = $target;
        return $this;
    }

    function getName() {
        return $this->name;
    }

    /**
     * @return AnchorXhtml
     */
    function name( $name ) {
        $this->name = $name;
        return $this;
    }

}

?>