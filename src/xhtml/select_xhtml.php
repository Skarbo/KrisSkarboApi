<?php

/**
 * @author Kris Skarbo
 * @see http://www.w3schools.com/TAGS/tag_select.asp
 */
class SelectXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $disabled;
    protected $multiple;
    protected $name;
    protected $size;

    protected $_options;
    protected $_selected;

    // CONSTRUCT


    // FUNCTIONS


    function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return SelectXhtml
     */
    function disabled( $disabled )
    {
        $this->disabled = $disabled;
        return $this;
    }

    function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * @return SelectXhtml
     */
    function multiple( $multiple )
    {
        $this->multiple = $multiple;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    /**
     * @return SelectXhtml
     */
    function name( $name )
    {
        $this->name = $name;
        return $this;
    }

    function getSize()
    {
        return $this->size;
    }

    /**
     * @return SelectXhtml
     */
    function size( $size )
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param array $options Array( "option_value" => "option_title" [, ... ] )
     * @return SelectXhtml
     */
    function options( array $options )
    {
        $this->_options = $options;
        return $this;
    }

    function getOptions()
    {
        return $this->_options;
    }

    /**
     * @param array $options
     * @return SelectXhtml
     */
    function addOption( array $options )
    {
        $this->_options = array_merge( $this->_options, $options );
        return $this;
    }

    /**
     * @param mixed $selected String( "option_value" ) / Array( "option_value" [, ... ] )
     * @return SelectXhtml
     */
    function selected( $selected )
    {
        $this->_selected = is_array( $selected ) ? $selected : array( $selected );
        return $this;
    }

    /**
     * @return array
     */
    function getSelected()
    {
        return $this->_selected;
    }

    // ... STRING


    public function __toString()
    {

        // Dont use custom string if options is given
        if ( is_null( $this->_options ) )
        {
            return "" . parent::__toString();
        }

        // Create XHTMLOptions array
        $xhtmloption_array = array ();
        foreach ( $this->getOptions() as $option_value => $option_title )
        {

            // Create XHTMLoption
            $option = Xhtml::option();

            // Check if selected option is this option value
            if ( array_search( $option_value, $this->getSelected() ) > -1 )
            {
                $option->selected( OptionXhtml::$SELECTED_SELECTED );
            }

            // Set value and content
            $option->value( $option_value )->content(
                    $option_title );

            // Add to array
            $xhtmloption_array[] = $option;



        }

        // Add options to content
        $this->content( implode( $xhtmloption_array ) );

        return "" . parent::__toString();

    }

    // ... /STRING


// /FUNCTIONS


}

?>