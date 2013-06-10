<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_form.asp
 */
class FormXhtml extends AbstractContentXhtml {
    
    // VARIABLES
    

    static $METHOD_POST = "post";
    static $METHOD_GET = "get";
    static $AUTOCOMPLETE_OFF = "off";
    static $AUTOCOMPLETE_ON = "on";
    static $ENCTYPE_MULTIPART_FORM_DATA = "multipart/form-data";
    
    protected $action;
    protected $accept;
    protected $autocomplete;
    protected $enctype;
    protected $method;
    protected $name;
    protected $target;
    protected $onsubmit;
    
    // CONSTRUCT
    

    public function __construct( $content = "" ) {
        parent::__construct( $content );
    }
    
    // FUNCTIONS
    

    function getAction() {
        return $this->action;
    }

    /**
     * @return FormXhtml
     */
    function action( $action ) {
        $this->action = $action;
        return $this;
    }

    function getAccept() {
        return $this->accept;
    }

    /**
     * @return FormXhtml
     */
    function accept( $accept ) {
        $this->accept = $accept;
        return $this;
    }

    function getMethod() {
        return $this->method;
    }

    function getAutocomplete() {
        return $this->autocomplete;
    }

    /**
     * @return FormXhtml
     */
    function autocomplete( $autocomplete ) {
        $this->autocomplete = is_bool( $autocomplete ) ? ( $autocomplete ? "on" : "off" ) : $autocomplete;
        return $this;
    }

    function getEnctype() {
        return $this->enctype;
    }

    /**
     * @return FormXhtml
     */
    function enctype( $enctype ) {
        $this->enctype = $enctype;
        return $this;
    }

    /**
     * @return FormXhtml
     */
    function method( $method ) {
        $this->method = $method;
        return $this;
    }

    function getName() {
        return $this->name;
    }

    /**
     * @return FormXhtml
     */
    function name( $name ) {
        $this->name = $name;
        return $this;
    }

    function getTarget() {
        return $this->target;
    }

    /**
     * @return FormXhtml
     */
    function target( $target ) {
        $this->target = $target;
        return $this;
    }

    function getOnSubmit() {
        return $this->onsubmit;
    }

    /**
     * @return FormXhtml
     */
    function onsubmit( $onsubmit ) {
        $this->onsubmit = $onsubmit;
        return $this;
    }

}

?>