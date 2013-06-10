<?php

class SelectSqlbuilderDbCore extends SelectupdatedeleteSqlbuilderDbCore {
    
    // VARIABLES
    

    /** Represents the expression */
    private $expression = array ();
    /** Represents join statement  */
    protected $join = array ();
    /** Represents group by statement in select expression */
    private $groupBy;
    /** Represents the having */
    private $having = array ();
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    function __construct( $expression = null, $from = null, $where = null, $group_by = null, array $order_by = array(), $limit = null, $offset = null ) {
        $this->setExpression( $expression );
        $this->setFrom( $from );
        $this->setWhere( $where );
        $this->setGroupBy( $group_by );
        if ( $order_by ) {
            $this->setOrderBy( $order_by );
        }
        $this->setLimit( $limit, $offset );
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GETTERS/SETTERS
    

    /**
     * @return array
     */
    public function getExpression() {
        return $this->expression;
    }

    /**
     * @param mixed $expression
     */
    public function setExpression( $expression ) {
        $this->expression = array ();
        $this->addExpression( $expression );
    }

    /**
     * @return string
     */
    public function getGroupBy() {
        return $this->groupBy;
    }

    /**
     * @param string $groupBy
     */
    public function setGroupBy( $groupBy, $_ = null ) {
        $this->groupBy = implode( ", ", func_get_args() );
    }

    /**
     * @return string
     */
    public function getHaving() {
        return $this->having;
    }

    /**
     * @param string $variable
     */
    public function setHaving( $having ) {
        $this->having = array ();
        $this->addHaving( $having );
    }
    
    // ... /GETTERS/SETTERS
    

    // ... GET
    

    /**
     * @return array:
     */
    private function getJoin() {
        return $this->join;
    }
    
    // ... /GET
    

    // ... ADD
    

    /**
     * Add expression to expression
     *
     * @param mixed $expression
     */
    public function addExpression( $expression ) {
        if ( !$expression ) {
            return;
        }
        else if ( is_array( $expression ) ) {
            $this->expression = array_merge( $this->getExpression(), $expression );
        }
        else {
            $this->expression[] = $expression;
        }
    }

    /**
     * Add join to where sentence
     *
     * @param string $join Join statement
     * @param string $type [NULL]|LEFT|RIGHT
     */
    public function addJoin( $join, $type = null ) {
        if ( !$join ) {
            return;
        }
        $this->join[] = $type ? sprintf( "%s JOIN %s", $type, $join ) : sprintf( "JOIN %s", $join );
    }

    /**
     * @param string $having
     * @param string $add "AND"|["OR"]
     */
    public function addHaving( $having, $add = "AND" ) {
        if ( !$having ) {
            return;
        }
        $this->having[] = $this->getHaving() ? sprintf( "%s %s", $add, $having ) : $having;
    }
    
    // ... /ADD
    

    // ... GET
    

    /**
     * @return string "expression, expression"
     */
    protected function getExpressionCreated() {
        return implode( ", ", 
                array_map( 
                        function ( $var ) {
                            if ( is_object( $var ) && is_a( $var, SqlbuilderDbCore::class_() ) ) {
                                return SB::par( SqlbuilderDbCore::get_( $var )->build() );
                            }
                            return $var;
                        }, array_filter( $this->getExpression() ) ) );
    }
    
    // ... /GET
    

    /**
     * @see BuilderCoreDb::build()
     */
    public function build() {
        
        // Select
        $select = "SELECT {$this->getExpressionCreated()}";
        
        // From
        $from = $this->getFrom() ? sprintf( "FROM %s", implode( ", ", $this->getFrom() ) ) : "";
        
        // Join
        $join = $this->getJoin() ? implode( " ", $this->getJoin() ) : "";
        
        // Where
        $where = $this->getWhere() ? sprintf( "WHERE %s", implode( " ", $this->getWhere() ) ) : "";
        
        // Group by
        $group_by = $this->getGroupBy() ? "GROUP BY {$this->getGroupBy()}" : "";
        
        // Having
        $having = $this->getHaving() ? sprintf( "HAVING %s", implode( " ", $this->getHaving() ) ) : "";
        
        // Order by
        $order_by = $this->getOrderBy() ? $this->getCreatedOrderBy() : "";
        
        // Limit
        $limit = !Core::isEmpty( $this->getLimit() ) ? $this->getCreatedLimit() : "";
        
        // Return query
        return Core::trimWhitespace( "$select $from $join $where $group_by $having $order_by $limit" );
    
    }

    /**
     * @param SelectSqlbuilderDbCore $get
     * @return SelectSqlbuilderDbCore
     */
    public static function get_( $get ) {
        return parent::get_( $get );
    }
    
    // /FUNCTIONS


}

?>