<?php

abstract class WebsiteAlgorithmParser extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param unknown_type $dom
     * @param string $function
     * @param mixed $default
     */
    protected function parseDom( $dom, $function, $default = null )
    {
        return $dom != null ? Core::empty_(
                Core::trimWhitespace( $dom->$function ), $default ) : $default;
    }

    /**
     * Parse html in webpage
     *
     * @param simple_html_dom $html HTML Dom to parse
     * @return IteratorCore List of parsed objects
     */
    public abstract function parseHtml( simple_html_dom $html );

    // /FUNCTIONS


}

?>