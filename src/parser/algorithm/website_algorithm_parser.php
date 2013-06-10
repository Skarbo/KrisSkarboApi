<?php

abstract class WebsiteAlgorithmParser extends ClassCore {
    
    // VARIABLES
    

    /** Parse raw html */
    const PARSER_TYPE_HTML = "html";
    /** Parse html with HTML DOM parser */
    const PARSER_TYPE_HTMLDOM = "htmldom";
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    /**
     * @return String Parser type
     */
    public abstract function getParseType();

    /**
     * @param unknown_type $dom
     * @param string $function
     * @param mixed $default
     */
    protected function parseDom( $dom, $function, $default = null ) {
        return $dom != null ? Core::empty_( Core::trimWhitespace( $dom->$function ), $default ) : $default;
    }

    /**
     * Parse webpage with HTML DOM result
     *
     * @param simple_html_dom $html HTML Dom to parse
     */
    public function parseHtmlDom( simple_html_dom $html ) {
    
    }

    /**
     * Parse webpage with raw HTML result
     *
     * @param string $html
     */
    public function parseHtmlRaw( $html ) {
    
    }
    
    // /FUNCTIONS


}

?>