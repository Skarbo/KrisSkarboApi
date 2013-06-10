<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_script.asp
 */
class ScriptXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    static $TYPE_JAVASCRIPT = "text/javascript";
    
    protected $type;
    protected $charset;
    protected $defer;
    protected $src;
    
    // CONSTRUCT
    

    // FUNCTIONS
    

    function getType() {
        return $this->type;
    }

    /**
     * @return ScriptXhtml
     */
    function type( $type ) {
        $this->type = $type;
        return $this;
    }

    function getCharset() {
        return $this->charset;
    }

    /**
     * @return ScriptXhtml
     */
    function charset( $charset ) {
        $this->charset = $charset;
        return $this;
    }

    function getSrc() {
        return $this->src;
    }

    /**
     * @return ScriptXhtml
     */
    function src( $src ) {
        $this->src = $src;
        return $this;
    }

    function getDefer() {
        return $this->defer;
    }

    /**
     * @return ScriptXhtml
     */
    function defer( $defer ) {
        $this->defer = $defer;
        return $this;
    }

}

?>