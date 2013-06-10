<?php

class QueryDbCore extends ClassCore {
    
    // VARIABLES
    

    /**
     * SQL query statement
     *
     * @var SqlbuilderDbCore
     */
    private $query;
    /**
     * Prepare statement binds
     *
     * @var array
     */
    private $binds = array ();
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    /**
     * @param SqlbuilderDbCore $query SQL query statement
     * @param array $binds Prepare statement binds
     */
    public function __construct( SqlbuilderDbCore $query = null, array $binds = array() ) {
        $this->query = $query;
        $this->binds = $binds;
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GETTERS/SETTERS
    

    /**
     * @return SqlbuilderDbCore
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param SqlbuilderDbCore $query
     */
    public function setQuery( SqlbuilderDbCore $query ) {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getBinds() {
        return $this->binds;
    }

    /**
     * @param array $binds
     */
    public function setBinds( array $binds ) {
        $this->binds = $binds;
    }
    
    // ... /GETTERS/SETTERS
    

    /**
     * @param array $binds
     */
    public function addBind( array $binds ) {
        $this->binds += $binds;
    }

    public function __toString() {
        
        $string_array = array ();
        
        // Query
        if ( $this->getQuery() && is_a( $this->getQuery(), SqlbuilderDbCore::class_() ) ) {
            $string_array[] = $this->getQuery()->build();
        }
        
        // Binds
        $string_array[] = print_r( $this->getBinds(), true );
        
        // Return string
        return implode( " : ", $string_array );
    
    }
    
    // /FUNCTIONS


}

?>