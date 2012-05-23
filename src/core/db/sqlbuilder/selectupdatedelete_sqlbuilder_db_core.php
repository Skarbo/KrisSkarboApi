<?php

abstract class SelectupdatedeleteSqlbuilderDbCore extends SqlbuilderDbCore
{

    // VARIABLES


    /** Represents from statement in select expression */
    protected $from;
    /**
     * Represents order by statement
     *
     * @var DoublearrayCore array ( array ( col, sort ) )
     */
    private $orderBy;
    /** Represents limit statement in select expresion */
    private $limit;
    /** Represents offset statement in select limit expresion */
    private $offset;
    /** Represents where statement */
    private $where;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom( $from )
    {
        $this->from = $from;
    }

    /**
     * @return DoublearrayCore array ( array ( col, sort ) )
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param DoublearrayCore $orderBy array ( array ( col, sort ) )
     */
    public function setOrderBy( DoublearrayCore $orderBy )
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return array array ( limit, offset )
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param integer $limit
     * @param integer $offset
     */
    public function setLimit( $limit, $offset = null )
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * @param string $where
     */
    public function setWhere( $where )
    {
        $this->where = $where;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return string Order by string
     */
    protected function getCreatedOrderBy()
    {
        $order_byString = implode( ", ",
                array_map(
                        function ( $a )
                        {
                            return implode( " ", $a );
                        }, $this->getOrderBy()->getArray() ) );
        $order_by = !empty( $order_byString ) ? "ORDER BY {$order_byString}" : "";

        return $order_by;
    }

    /**
     * @return string "limit [, offset]"
     */
    protected function getCreatedLimit()
    {
        return !Core::isEmpty( $this->getLimit() ) ? Core::cc( "", "LIMIT {$this->getLimit()}",
                !Core::isEmpty( $this->offset ) ? ", {$this->offset}" : "" ) : "";
    }

    // ... /GET


    // ... ADD


    /**
     * Adds where statement to end of where statement
     *
     * @param string $where
     * @param string $add OR|AND, will only be added if $where already is set
     */
    function addWhere( $where, $add = "AND" )
    {
        $this->where .= ( !empty( $add ) && $this->getWhere() ) ? " {$add} {$where}" : "{$where}";
    }

    /**
     * Adds from statement to end of from statement
     *
     * @param string $from
     */
    function addFrom( $from )
    {
        $this->from .= $this->getFrom() && $from ? ", {$from}" : "{$from}";
    }

    // ... /ADD


// /FUNCTIONS


}

?>