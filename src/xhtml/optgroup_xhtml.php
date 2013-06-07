<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_optgroup.asp
 */
class OptgroupXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $label;
    protected $disabled;

    // CONSTRUCT


    // FUNCTIONS


    function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return OptgroupXhtml
     */
    function label( $label )
    {
        $this->label = $label;
        return $this;
    }

    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param string $disabled
     * @return OptgroupXhtml
     */
    function disabled( $disabled )
    {
        $this->disabled = $disabled;
        return $this;
    }

}

?>