<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_td.asp
 */
class TdXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $abbr;
    protected $align;
    protected $colspan;
    protected $rowspan;
    protected $valign;

    // CONSTRUCT


    // FUNCTIONS


    function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * @return XHTMLtd
     */
    function abbr( $abbr )
    {
        $this->abbr = $abbr;
        return $this;
    }

    function getAlign()
    {
        return $this->align;
    }

    /**
     * @return XHTMLtd
     */
    function align( $align )
    {
        $this->align = $align;
        return $this;
    }

    function getColspan()
    {
        return $this->colspan;
    }

    /**
     * @return XHTMLtd
     */
    function colspan( $colspan )
    {
        $this->colspan = $colspan;
        return $this;
    }

    function getRowspan()
    {
        return $this->rowspan;
    }

    /**
     * @return XHTMLtd
     */
    function rowspan( $rowspan )
    {
        $this->rowspan = $rowspan;
        return $this;
    }

    function getValign()
    {
        return $this->valign;
    }

    /**
     * @return XHTMLtd
     */
    function valign( $valign )
    {
        $this->valign = $valign;
        return $this;
    }

}

?>