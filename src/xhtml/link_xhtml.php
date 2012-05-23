<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_link.asp
 */
class LinkXhtml extends AbstractXhtml
{

    // VARIABLES


    public static $REL_STYLESHEET = "stylesheet";
    public static $TYPE_CSS = "text/css";

    protected $charset;
    protected $href;
    protected $hreflang;
    protected $media;
    protected $rel;
    protected $rev;
    protected $target;
    protected $type;

    // CONSTRUCT


    public function __construct()
    {
        parent::__construct();
        $this->set_endTag( false );
    }

    // FUNCTIONS


    function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return LinkXhtml
     */
    function charset( $charset )
    {
        $this->charset = $charset;
        return $this;
    }

    function getHref()
    {
        return $this->href;
    }

    /**
     * @return LinkXhtml
     */
    function href( $href )
    {
        $this->href = $href;
        return $this;
    }

    function getHreflang()
    {
        return $this->hreflang;
    }

    /**
     * @return LinkXhtml
     */
    function hreflang( $hreflang )
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    function getMedia()
    {
        return $this->media;
    }

    /**
     * @return LinkXhtml
     */
    function media( $media )
    {
        $this->media = $media;
        return $this;
    }

    function getRel()
    {
        return $this->rel;
    }

    /**
     * @return LinkXhtml
     */
    function rel( $rel )
    {
        $this->rel = $rel;
        return $this;
    }

    function getRev()
    {
        return $this->rev;
    }

    /**
     * @return LinkXhtml
     */
    function rev( $rev )
    {
        $this->rev = $rev;
        return $this;
    }

    function getTarget()
    {
        return $this->target;
    }

    /**
     * @return LinkXhtml
     */
    function target( $target )
    {
        $this->target = $target;
        return $this;
    }

    function getType()
    {
        return $this->type;
    }

    /**
     * @return LinkXhtml
     */
    function type( $type )
    {
        $this->type = $type;
        return $this;
    }

}

?>