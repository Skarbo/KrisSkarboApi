<?php

class DeleteSqlbuilderDbCore extends SelectupdatedeleteSqlbuilderDbCore {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    /**
     * @param string $from
     * @param string $where
     * @param array $order_by
     * @param string $limit
     * @param string $offset
     */
    function __construct( $from = null, $where = null, array $order_by = array(), $limit = null, $offset = null ) {
        $this->setFrom( $from );
        $this->setWhere( $where );
        if ( $order_by ) {
            $this->setOrderBy( $order_by );
        }
        $this->setLimit( $limit, $offset );
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    /**
     * @see BuilderCoreDb::build()
     */
    public function build() {
        
        // Delete
        $delete = sprintf( "DELETE FROM %s", implode( ", ", $this->getFrom() ) );
        
        // Where
        $where = $this->getWhere() ? sprintf( "WHERE %s", implode( " ", $this->getWhere() ) ) : "";
        
        // Order by
        $order_by = $this->getOrderBy() ? $this->getCreatedOrderBy() : "";
        
        // Limit
        $limit = $this->getLimit() ? $this->getCreatedLimit() : "";
        
        // Return
        return Core::trimWhitespace( "$delete $where $order_by $limit" );
    
    }
    
    // /FUNCTIONS


}

?>