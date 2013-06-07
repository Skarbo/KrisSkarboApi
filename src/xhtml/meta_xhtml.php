<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_meta.asp
 */
class MetaXhtml extends AbstractXhtml
{

    // VARIABLES


    static $EQUIV_EXPIRES = "expires";
    static $EQUIV_PRAGMA = "pragma";
    static $EQUIV_CACHE_CONTROL = "cache-control";
    static $EQUIV_CONTENT_TYPE = "Content-Type";
    static $EQUIV_CONTENT_DISPOSITION = "Content-Disposition";
    static $CONTENT_NO_CACHE = "no-cache";
    static $CONTENT_TEXT_HTML = "text/html";
    static $CONTENT_APPLICATION_EXCEL = "application/vnd.ms-excel";
    static $CONTENT_VIEWPORT_WIDTH_DEVICEWIDTH = "width=device-width";
    static $CONTENT_VIEWPORT_MINCALE_1 = "minimum-scale=1";
    static $CONTENT_VIEWPORT_MAXSCALE_1 = "maximum-scale=1";
    static $CONTENT_VIEWPORT_USERSCALABLE_NO = "user-scalable=no";
    static $CONTENT_VIEWPORT_INITIALSCALE_1 = "initial-scale=1";
    static $NAME_VIEWPORT = "viewport";

    protected $content;
    protected $http_equiv;
    protected $name;
    protected $scheme;

    // CONSTRUCT


    function __construct()
    {
        parent::__construct();
        $this->set_endTag( false );
    }

    // FUNCTIONS


    function getContent()
    {
        return $this->content;
    }

    /**
     * @return MetaXhtml
     */
    function content( $content )
    {
        $this->content = $content;
        return $this;
    }

    function getHttpEquiv()
    {
        return $this->http_equiv;
    }

    /**
     * @return MetaXhtml
     */
    function http_equiv( $http_equiv )
    {
        $this->http_equiv = $http_equiv;
        return $this;
    }

    function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return MetaXhtml
     */
    function scheme( $scheme )
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return MetaXhtml
     */
    function name( $name )
    {
        $this->name = $name;
        return $this;
    }

    //	STATIC


    /**
     * @param string $content_type text/html
     * @param string $charset ISO-8859-1
     * @return string "text/html;charset=ISO-8859-1"
     */
    static function contentType( $content_type, $charset )
    {
        return "$content_type; charset=$charset";
    }

    /**
     * @param string $filename test.html
     * @return string "inline; filename=test.html"
     */
    static function contentDisposition( $filename )
    {
        return "inline; filename=$filename";
    }

    //	/STATIC


}

?>