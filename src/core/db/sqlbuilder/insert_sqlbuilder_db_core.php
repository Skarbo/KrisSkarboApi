<?php

class InsertSqlbuilderDbCore extends SqlbuilderDbCore {
    
    // VARIABLES
    

    /** Represents table name */
    private $into;
    /** Rerpesents set */
    private $set = array ();
    /** Reprsents values */
    private $values = array ();
    /** Represents if duplicate */
    private $duplicate = array ();
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    function __construct( $into = NULL, array $set = array(), array $values = array(), array $duplicate = array() ) {
        $this->setInto( $into );
        $this->setSet( $set );
        $this->setValues( $values );
        $this->setDuplicate( $duplicate );
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GETTERS/SETTERS
    

    /**
     * @return string
     */
    public function getInto() {
        return $this->into;
    }

    /**
     * @param string $into
     */
    public function setInto( $into ) {
        $this->into = $into;
    }

    /**
     * @return array
     */
    public function getSet() {
        return $this->set;
    }

    /**
     * @param array $set array( "column", "column", ... )
     * @return void
     */
    public function setSet( array $set ) {
        $this->set = $set;
    }

    /**
     * @return array( "value", ... )
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * @param array( "value", ... )
     * @return void
     */
    public function setValues( array $values ) {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getDuplicate() {
        return $this->duplicate;
    }

    /**
     * @param $duplicate array
     * @return void
     */
    public function setDuplicate( array $duplicate ) {
        $this->duplicate = $duplicate;
    }
    
    // ... /GETTERS/SETTERS
    

    // ... GET
    

    /**
     * @return string "(column, column, ...)"
     */
    private function getCreatedSet() {
        return ( $this->getSet() ) ? Core::cc( "", "(", implode( ", ", $this->getSet() ), ")" ) : "";
    }

    /**
     * Returns duplicate array as string
     *
     * @return string
     */
    private function getCreatedDuplicate() {
        
        $duplicate = array ();
        
        foreach ( $this->getDuplicate() ? $this->getDuplicate() : array () as $key => $value ) {
            $duplicate[] = "$key = $value";
        }
        
        return implode( ", ", $duplicate );
    
    }

    /**
     * @return string "(value, ...)"
     */
    private function getCreatedValues() {
        return Core::cc( "", "(", implode( ", ", $this->getValues() ), ")" );
    }
    
    // ... /GET
    

    // ... SET
    

    /**
     * Sets both Set and Values
     *
     * @param array $set_values Array ( "set" => "value", ... )
     */
    public function setSetValues( array $set_values ) {
        
        // Set Set
        $this->setSet( array_keys( $set_values ) );
        
        // Values array
        $this->setValues( array_values( $set_values ) );
    
    }
    
    // ... /SET
    

    /**
     * @see BuilderCoreDb::build()
     */
    public function build() {
        
        // Insert
        $insert = "INSERT INTO {$this->getInto()}";
        
        // Set
        $set = $this->getCreatedSet();
        
        // Values
        $values = "VALUES {$this->getCreatedValues()}";
        
        // Duplicate
        $duplicate = $this->getDuplicate() ? "ON DUPLICATE KEY UPDATE {$this->getCreatedDuplicate()}" : "";
        
        // Return query
        return Core::trimWhitespace( "$insert $set $values $duplicate" );
    
    }
    
    // /FUNCTIONS


}

?>