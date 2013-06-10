<?php

class MultipleInputXhtml {
    
    // VARIABLES
    

    private $input;
    private $options = array ();
    private $selected = array ();
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    function __construct( InputXhtml $input ) {
        $this->input = $input;
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    /**
     * @param InputXhtml $input
     * @return MultipleInputXhtml
     */
    function input( InputXhtml $input ) {
        $this->input = $input;
        return $this;
    }

    /**
     * @return InputXhtml
     */
    function getInput() {
        return $this->input;
    }

    /**
     * @param array $options Array( param => value )
     * @return MultipleInputXhtml
     */
    function options( array $options ) {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    function getOptions() {
        return $this->options;
    }

    /**
     * @param mixed $selected String( "selected" ) / Array( "selected1", "selected2" )
     * @return MultipleInputXhtml
     */
    function selected( $selected ) {
        $this->selected = is_array( $selected ) ? $selected : array ( $selected );
        return $this;
    }

    /**
     * @return array
     */
    function getSelected() {
        return $this->selected;
    }
    
    // ... STRING
    

    function __toString() {
        
        // Table
        $table = Xhtml::table()->cellpadding( 0 )->cellspacing( 0 );
        
        // Foreach options
        foreach ( $this->options as $param => $value ) {
            $input = $this->getInput();
            $table_tr = Xhtml::tr();
            $table_tr->addContent( 
                    Xhtml::td()->style( "vertical-align: text-top;" )->content( 
                            $input->value( $param )->checked( array_search( $param, $this->getSelected() ) > -1 ) ) );
            $table_tr->addContent( Xhtml::td( $value ) );
            $table->addContent( $table_tr );
        }
        
        return "" . $table;
    
    }
    
    // ... /STRING
    

    // /FUNCTIONS


}

?>