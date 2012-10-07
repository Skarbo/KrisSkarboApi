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
    protected $spellcheck;
    protected $wrap;

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

    function getSpellcheck()
    {
        return $this->spellcheck;
    }

    /**
     * @return TextareaXhtml
     */
    function spellcheck( $spellcheck )
    {
        $this->spellcheck = is_bool( $spellcheck ) && !$spellcheck ? "false" : $spellcheck;
        return $this;
    }

    function getWrap()
    {
        return $this->wrap;
    }

    /**
     * @return TextareaXhtml
     */
    function wrap( $wrap )
    {
        $this->wrap = is_bool( $wrap ) && !$wrap ? "off" : $wrap;
        return $this;
    }

}

?>