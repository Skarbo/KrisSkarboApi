<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_input.asp
 */
class InputXhtml extends AbstractXhtml
{

    // VARIABLES


    static $TYPE_PASSWORD = "password";
    static $TYPE_SUBMIT = "submit";
    static $TYPE_HIDDEN = "hidden";
    static $TYPE_CHECKBOX = "checkbox";
    static $TYPE_BUTTON = "button";
    static $TYPE_FILE = "file";
    static $TYPE_RADIO = "radio";
    static $TYPE_TEXT = "text";

    static $CHECKED_CHECKED = "checked";

    static $AUTOCOMPLETE_OFF = "off";

    protected $accepted;
    protected $align;
    protected $alt;
    protected $autocomplete;
    protected $checked;
    protected $disabled;
    protected $maxlength;
    protected $name;
    protected $readonly;
    protected $size;
    protected $src;
    protected $type;
    protected $value;

    // CONSTRUCT


    /**
     * @param string $value
     * @param string $name
     */
    function __construct( $value = "", $name = "" )
    {

        // Set no end tag
        $this->set_endTag( false );

        $this->value = $value;
        $this->name = $name;

        // Parent construct
        parent::__construct();

    }

    // FUNCTIONS


    function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * @return InputXhtml
     */
    function accepted( $accepted )
    {
        $this->accepted = $accepted;
        return $this;
    }

    function getAlign()
    {
        return $this->align;
    }

    /**
     * @return InputXhtml
     */
    function align( $align )
    {
        $this->align = $align;
        return $this;
    }

    function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return InputXhtml
     */
    function alt( $alt )
    {
        $this->alt = $alt;
        return $this;
    }

    function getAutocomplete()
    {
        return $this->autocomplete;
    }

    /**
     * @return InputXhtml
     */
    function autocomplete( $autocomplete )
    {
        $this->autocomplete = $autocomplete;
        return $this;
    }

    function getChecked()
    {
        return $this->checked;
    }

    /**
     * @return InputXhtml
     */
    function checked( $checked )
    {

        if ( is_bool( $checked ) && $checked )
        {
            $this->checked = self::$CHECKED_CHECKED;
        }
        else
        {
            $this->checked = $checked;
        }

        return $this;
    }

    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return InputXhtml
     */
    function disabled( $disabled )
    {
        $this->disabled = $disabled;
        return $this;
    }

    function getMaxlength()
    {
        return $this->maxlength;
    }

    /**
     * @return InputXhtml
     */
    function maxlength( $maxlength )
    {
        $this->maxlength = $maxlength;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    /**
     * @return InputXhtml
     */
    function name( $name )
    {
        $this->name = $name;
        return $this;
    }

    function getReadonly()
    {
        return $this->readonly;
    }

    /**
     * @return InputXhtml
     */
    function readonly( $readonly )
    {
        $this->readonly = $readonly;
        return $this;
    }

    function getSize()
    {
        return $this->size;
    }

    /**
     * @return InputXhtml
     */
    function size( $size )
    {
        $this->size = $size;
        return $this;
    }

    function getSrc()
    {
        return $this->src;
    }

    /**
     * @return InputXhtml
     */
    function src( $src )
    {
        $this->src = $src;
        return $this;
    }

    function getType()
    {
        return $this->type;
    }

    /**
     * @return InputXhtml
     */
    function type( $type )
    {
        $this->type = $type;
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    /**
     * Validates the value!
     *
     * @return InputXhtml
     */
    function value( $value )
    {
        $this->value = $value;
        return $this;
    }

}

?>