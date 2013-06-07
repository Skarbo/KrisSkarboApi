<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_html.asp
 */
class HtmlXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $xmlns;

    // CONSTRUCT


    // FUNCTIONS


    function getXmlns()
    {
        return $this->xmlns;
    }

    /**
     * @return HtmlXhtml
     */
    function xmlns( $xmlns )
    {
        $this->xmlns = $xmlns;
        return $this;
    }

}

?>