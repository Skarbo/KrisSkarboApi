<?php

class UpdateSqlbuilderDbCore extends SelectupdatedeleteSqlbuilderDbCore
{

    // VARIABLES


    /** Represents the table */
    protected $table;
    /** Represents the columns and values to be set */
    protected $set = array ();

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @param string $table
     * @param array $set Array( "column" => "value" )
     * @param string $where
     * @param array $order_by
     * @param string $limit
     * @param string $offset
     */
    function __construct( $table = null, array $set = array(), $where = null, array $order_by = array(), $limit = null, $offset = null )
    {
        $this->setTable( $table );
        $this->setSet( $set );
        $this->setWhere( $where );
        if ( $order_by )
        {
            $this->setOrderBy( $order_by );
        }
        $this->setLimit( $limit, $offset );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable( $table )
    {
        $this->table = $table;
    }

    /**
     * @return array Array( "column" => "value" )
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @param array $set Array( "column" => "value", ... )
     */
    public function setSet( array $set )
    {
        $this->set = $set;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return string "key = value [, ...]"
     */
    private function getCreatedSet()
    {

        $new_array = array ();

        foreach ( $this->getSet() as $key => $value )
        {
            $new_array[] = "$key = $value";
        }

        return "SET " . implode( ", ", $new_array );

    }

    // ... /GET


    // ... ADD


    /**
     * @param array $set array( "column" => "value" )
     */
    public function addSet( array $set )
    {
        $this->set = array_merge( $this->set, $set );
    }

    // ... /ADD


    /**
     * @see BuilderCoreDb::build()
     */
    public function build()
    {

        // Update
        $update = "UPDATE {$this->getTable()}";

        // Set
        $set = $this->getSet() ? $this->getCreatedSet() : "";

        // Where
        $where = $this->getWhere() ? sprintf( "WHERE %s", implode( " ", $this->getWhere() ) ) : "";

        // Order by
        $order_by = $this->getOrderBy() ? $this->getCreatedOrderBy() : "";

        // Limit
        $limit = !Core::isEmpty( $this->getLimit() ) ? $this->getCreatedLimit() : "";

        // Return query
        return Core::trimWhitespace( "$update $set $where $order_by $limit" );

    }

    // /FUNCTIONS


}

?>