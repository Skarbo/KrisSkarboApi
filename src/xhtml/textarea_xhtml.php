<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_textarea.asp
 */
class TextareaXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $cols;
    protected $rows;
    protected $disabled;
    protected $name;
    protected $readonly;

    // CONSTRUCT


    function __construct( $content = "" )
    {
        $this->_sanatize = true;
        parent::__construct( $content );
    }

    // FUNCTIONS


    function getCols()
    {
        return $this->cols;
    }

    /**
     * @return TextareaXhtml
     */
    function cols( $cols )
    {
        $this->cols = $cols;
        return $this;
    }

    function getRows()
    {
        return $this->rows;
    }

    /**
     * @return TextareaXhtml
     */
    function rows( $rows )
    {
        $this->rows = $rows;
        return $this;
    }

    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return TextareaXhtml
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
     * @return TextareaXhtml
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
     * @return TextareaXhtml
     */
    function readonly( $readonly )
    {
        $this->readonly = $readonly;
        return $this;
    }

}

?>