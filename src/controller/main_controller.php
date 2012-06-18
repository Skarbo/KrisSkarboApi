<?php

abstract class MainController extends Controller
{

    // VARIABLES


    /**
     * Represents the Javascript files
     *
     * @var array
     */
    private $javascriptFiles = array ();
    /**
     * Represents the Javascript codes
     *
     * @var array
     */
    private $javascriptCodes = array ();
    /**
     * Represents the CSS files
     *
     * @var array
     */
    private $cssFiles = array ();
    private $metaTags = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... ADD


    protected function addJavascriptFile( $javascript_file )
    {
        if ( !in_array( $javascript_file, $this->javascriptFiles ) )
        {
            $this->javascriptFiles[] = $javascript_file;
        }
    }

    protected function addJavascriptCode( $javascript_code )
    {
        $this->javascriptCodes[] = $javascript_code;
    }

    protected function addCssFile( $css_file )
    {
        if ( !in_array( $css_file, $this->cssFiles ) )
        {
            $this->cssFiles[] = $css_file;
        }
    }

    protected function addMetaTag( MetaXhtml $meta )
    {
        $this->metaTags[] = $meta;
    }

    // ... /ADD


    // ... GET


    /**
     * @return string Site title
     */
    protected abstract function getTitle();

    // ... /GET


    /**
     * @see Controller::after()
     */
    public function after()
    {
    }

    /**
     * @see Controller::render()
     */
    public function render( AbstractXhtml &$root )
    {
        parent::render( &$root );

        // Create HTML element
        $html = Xhtml::html();
        //$html->xmlns( "http://www.w3.org/1999/xhtml" );

        // Create Head element
        $head = Xhtml::head();

        // Add content type meta to head
        $content_type_meta = Xhtml::meta();
        $content_type_meta->http_equiv( MetaXhtml::$EQUIV_CONTENT_TYPE );
        $content_type_meta->content( MetaXhtml::contentType( "text/html", "UTF-8" ) );

        $head->addContent( $content_type_meta );

        // Add robots noindex to head
        $noindex_meta = Xhtml::meta();
        $noindex_meta->content( "noindex" );
        $noindex_meta->name( "robots" );

        $head->addContent( $noindex_meta );

        // Append meta tags to Head
        $this->appendMetaTags( $head );

        // Append Javascripts to Head
        $this->appendJavascriptFiles( $head );

        // Append Javascript code to Head
        $this->appendJavascriptCodes( $head );

        // Append CSS files to Head
        $this->appendCssFiles( $head );

        // Add Title element to Head
        $head->addContent( Xhtml::title( $this->getTitle() ) );

        // Add Head to HTML
        $html->addContent( $head );

        // Create wrapper div
        $wrapper = Xhtml::div( $root->get_content() )->id( MainView::$ID_WRAPPER );

        // Create Body element
        $body = Xhtml::body();

        // Add wrapper to Body
        $body->addContent( $wrapper );

        // Add Body to HTML
        $html->addContent( $body );

        // Set HTML as root
        $root = $html;
    }

    /**
     * Adds Javascript files to head element
     *
     * @param AbstractXhtml $head Head element
     */
    private function appendJavascriptFiles( AbstractXhtml &$head )
    {
        foreach ( $this->javascriptFiles as $javascriptFile )
        {
            // Create Script element
            $script = Xhtml::script();

            $script->src( $javascriptFile );

            $script->type( ScriptXhtml::$TYPE_JAVASCRIPT );

            // Add Script to Head
            $head->addContent( $script );
        }
    }

    /**
     * Adds Javascript codes to head element
     *
     * @param AbstractXhtml $head Head element
     */
    private function appendJavascriptCodes( AbstractXhtml &$head )
    {

        // Create Script element
        $script = Xhtml::script();
        $script->type( ScriptXhtml::$TYPE_JAVASCRIPT );

        foreach ( $this->javascriptCodes as $javascriptCode )
        {
            $script->addContent( sprintf( "%s\n", $javascriptCode ) );
        }

        // Add Script to Head
        $head->addContent( $script );

    }

    /**
     * Adds CSS files to head element
     *
     * @param AbstractXhtml $head Head element
     */
    private function appendCssFiles( AbstractXhtml &$head )
    {
        foreach ( $this->cssFiles as $cssFile )
        {
            // Create Link element
            $link = Xhtml::link();

            $link->href( $cssFile );

            $link->type( LinkXhtml::$TYPE_CSS );
            $link->rel( LinkXhtml::$REL_STYLESHEET );

            // Add Script to Head
            $head->addContent( $link );
        }
    }

    /**
     * Adds meta tags to head element
     *
     * @param AbstractXhtml $head
     */
    private function appendMetaTags( AbstractXhtml &$head )
    {
        foreach ( $this->metaTags as $meta )
        {
            $head->addContent( $meta );
        }
    }

    // /FUNCTIONS


}

?>