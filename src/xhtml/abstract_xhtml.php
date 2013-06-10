<?php

abstract class AbstractXhtml {
    
    // VARIABLES
    

    const ATTR_ENCLOSE_DOUBLE = '"';
    const ATTR_ENCLOSE_SINGLE = "'";
    
    protected $_endTag = true;
    protected $_code;
    protected $_content;
    protected $_sanatize = false;
    protected $_attributes = array ();
    protected $_attribute_enclose = self::ATTR_ENCLOSE_DOUBLE;
    
    protected $class = array ();
    protected $style;
    protected $id;
    protected $title;
    
    protected $onclick;
    protected $ondblclick;
    protected $onmousedown;
    protected $onmousemove;
    protected $onmouseout;
    protected $onmouseover;
    protected $onmouseup;
    protected $onkeydown;
    protected $onkeypress;
    protected $onkeyup;
    protected $onblur;
    protected $onfocus;
    protected $onload;
    protected $onchange;
    
    // CONSTRUCT
    

    function __construct() {
        
        // Get object that called the class
        //$backtrack = debug_backtrace();
        //$object = $backtrack[ 0 ][ "object" ];
        

        // If code is not given, use class name
        if ( !$this->get_code() ) {
            
            // Get class name
            $class = get_called_class();
            
            // Get code from class name
            $code = str_replace( "xhtml", "", strtolower( $class ) );
            
            // Empty code
            if ( empty( $code ) ) {
                return !trigger_error( "Code is empty" );
            }
            
            // Set code
            $this->set_code( $code );
        
        }
    
    }
    
    // FUNCTIONS
    

    //	GETTERS/SETTERS
    

    public final function get_endTag() {
        return $this->_endTag;
    }

    public final function get_code() {
        return $this->_code;
    }

    public final function get_content() {
        return $this->_content;
    }

    public final function getClass() {
        return $this->class;
    }

    public final function getStyle() {
        return $this->style;
    }

    public final function getId() {
        return $this->id;
    }

    public final function getTitle() {
        return $this->title;
    }

    public final function set_endTag( $_endTag ) {
        $this->_endTag = $_endTag;
    }

    public final function set_code( $_code ) {
        $this->_code = $_code;
    }
    
    //	/GETTERS/SETTERS
    

    //	VARIABLES
    

    /**
     * @return AbstractXhtml
     */
    function content( $content ) {
        $this->_content = $content;
        return $this;
    }

    /**
     * @param mixed $content
     * @param mixed $_ [NULL]
     * @return AbstractXhtml
     */
    function addContent( $content, $_ = NULL ) {
        $this->_content .= implode( func_get_args() );
        return $this;
    }

    /**
     * @param string $class
     * @param string $_ [NULL]
     * @return AbstractXhtml
     */
    function class_( $class, $_ = NULL ) {
        $this->class = ( array ) func_get_args();
        return $this;
    }

    /**
     * @param string $class
     * @param string $_ [NULL]
     * @return AbstractXhtml
     */
    function addClass( $class, $_ = NULL ) {
        $this->class = array_unique( array_merge( $this->class, func_get_args() ) );
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function style( $style ) {
        $this->style = $style;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function title( $title ) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function id( $id ) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnClick() {
        return $this->onclick;
    }

    /**
     * @return AbstractXhtml
     */
    function onclick( $onclick ) {
        $this->onclick = $onclick;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnDblClick() {
        return $this->ondblclick;
    }

    /**
     * @return AbstractXhtml
     */
    function ondblclick( $ondblclick ) {
        $this->ondblclick = $ondblclick;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnKeyDown() {
        return $this->onkeydown;
    }

    /**
     * @return AbstractXhtml
     */
    function onkeydown( $onkeydown ) {
        $this->onkeydown = $onkeydown;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnKeyPress() {
        return $this->onkeypress;
    }

    /**
     * @return AbstractXhtml
     */
    function onkeypress( $onkeypress ) {
        $this->onkeypress = $onkeypress;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnKeyUp() {
        return $this->onkeyup;
    }

    /**
     * @return AbstractXhtml
     */
    function onkeyup( $onkeyup ) {
        $this->onkeyup = $onkeyup;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnMouseDown() {
        return $this->onmousedown;
    }

    /**
     * @return AbstractXhtml
     */
    function onmousedown( $onmousedown ) {
        $this->onmousedown = $onmousedown;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnMouseMove() {
        return $this->onmousemove;
    }

    /**
     * @return AbstractXhtml
     */
    function onmousemove( $onmousemove ) {
        $this->onmousemove = $onmousemove;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnMouseOut() {
        return $this->onmouseout;
    }

    /**
     * @return AbstractXhtml
     */
    function onmouseout( $onmouseout ) {
        $this->onmouseout = $onmouseout;
        return $this;
    }

    function getOnMouseOver() {
        return $this->onmouseover;
    }

    /**
     * @return AbstractXhtml
     */
    function onmouseover( $onmouseover ) {
        $this->onmouseover = $onmouseover;
        return $this;
    }

    /**
     * @return AbstractXhtml
     */
    function getOnMouseUp() {
        return $this->onmouseup;
    }

    /**
     * @return AbstractXhtml
     */
    function onmouseup( $onmouseup ) {
        $this->onmouseup = $onmouseup;
        return $this;
    }

    function getSanatize() {
        return $this->_sanatize;
    }

    /**
     * @return AbstractXhtml
     */
    function _sanatize( $_sanatize ) {
        $this->_sanatize = $_sanatize;
        return $this;
    }

    function getOnBlur() {
        return $this->onblur;
    }

    /**
     * @return AbstractXhtml
     */
    function onblur( $onblur ) {
        $this->onblur = $onblur;
        return $this;
    }

    function getOnFocus() {
        return $this->onfocus;
    }

    /**
     * @return AbstractXhtml
     */
    function onfocus( $onfocus ) {
        $this->onfocus = $onfocus;
        return $this;
    }

    function getOnLoad() {
        return $this->onload;
    }

    /**
     * @return AbstractXhtml
     */
    function onload( $onload ) {
        $this->onload = $onload;
        return $this;
    }

    function getOnChange() {
        return $this->onchange;
    }

    /**
     * @return AbstractXhtml
     */
    function onchange( $onchange ) {
        $this->onchange = $onchange;
        return $this;
    }

    function getAttributes() {
        return $this->_attributes;
    }

    /**
     * @return AbstractXhtml
     */
    function attr( $attr, $value ) {
        $this->_attributes[ $attr ] = $value;
        return $this;
    }

    function getAttributeEnclose() {
        return $this->_attribute_enclose;
    }

    /**
     * @return AbstractXhtml
     */
    function attrEnclose( $enclose ) {
        $this->_attribute_enclose = $enclose;
        return $this;
    }
    
    //	VARIABLES
    

    protected function param( $param, $value = NULL ) {
        return ( !( empty( $value ) && !is_numeric( $value ) ) ) ? sprintf( "%s=%s%s%s", $param, 
                $this->getAttributeEnclose(), $value, $this->getAttributeEnclose() ) : NULL;
    }

    protected function noEndTag( $code, $param ) {
        return trim( "<$code $param />\n" );
    }

    protected function endTag( $code, $param, $content ) {
        return trim( "<$code $param>" . $content . "</$code>\n" );
    }

    public function __toString() {
        
        // Variables
        $variables = get_object_vars( $this );
        
        // Add attributes
        $variables = array_merge( $variables, $this->_attributes );
        
        // Foreach variable
        $param_array = array ();
        foreach ( $variables as $param => $value ) {
            
            // Param is not a class variable and value not null
            if ( strcmp( substr( $param, 0, 1 ), "_" ) != 0 && !( empty( $value ) && !is_numeric( $value ) ) ) {
                $param_array[] = $this->param( $param, is_array( $value ) ? implode( " ", $value ) : $value );
            }
        
        }
        
        // No end tag
        if ( !$this->get_endTag() ) {
            return trim( $this->noEndTag( $this->get_code(), implode( " ", $param_array ) ) );
        }
        // End tag
        else {
            return trim( $this->endTag( $this->get_code(), implode( " ", $param_array ), $this->get_content() ) );
        }
    
    }

    /**
     * @param AbstractXhtml $get
     * @return AbstractXhtml
     */
    public static function get_( $get ) {
        return $get;
    }

}

?>