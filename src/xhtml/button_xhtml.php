<?php

class ButtonXhtml extends AbstractContentXhtml
{

    // VARIABLES


    public static $TYPE_BUTTON = "button";
    public static $TYPE_SUBMIT = "submit";

    protected $disabled;
    protected $name;
    protected $type = "button";
    protected $value;

    // CONSTRUCT


    // FUNCTIONS


    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return ButtonXhtml
     */
    function disabled( $disabled )
    {
        $this->disabled = $disabled;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    /**
     * @return ButtonXhtml
     */
    function name( $name )
    {
        $this->name = $name;
        return $this;
    }

    function getType()
    {
        return $this->type;
    }

    /**
     * @return ButtonXhtml
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
     * @return ButtonXhtml
     */
    function value( $value )
    {
        $this->value = $value;
        return $this;
    }

}

?>