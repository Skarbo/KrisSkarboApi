<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_option.asp
 */
class OptionXhtml extends AbstractContentXhtml
{

    // VARIABLES


    static $SELECTED_SELECTED = "selected";

    protected $disabled;
    protected $label;
    protected $selected;
    protected $value;

    // CONSTRUCT


    public function __construct( $content = "", $value = "" )
    {
        parent::__construct( $content );
        $this->value( $value );
    }

    // FUNCTIONS


    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return OptionXhtml
     */
    function disabled( $disabled )
    {
        $this->disabled = $disabled;
        return $this;
    }

    function getLabel()
    {
        return $this->label;
    }

    /**
     * @return OptionXhtml
     */
    function label( $label )
    {
        $this->label = $label;
        return $this;
    }

    function getSelected()
    {
        return $this->selected;
    }

    /**
     * @return OptionXhtml
     */
    function selected( $selected )
    {
        $this->selected = $selected;
        return $this;
    }

    function getValue()
    {
        return $this->value;
    }

    /**
     * @return OptionXhtml
     */
    function value( $value )
    {
        $this->value = $value;
        return $this;
    }

}

?>