<?php

class SelectSqlbuilderDbCore extends SelectupdatedeleteSqlbuilderDbCore
{

    // VARIABLES


    /** Represents the expression */
    private $expression;
    /** Represents group by statement in select expression */
    private $groupBy;
    /** Represents the having */
    private $having;

    // /VARIABLES


    // CONSTRUCTOR


    function __construct( $expression = null, $from = null, $where = null, $group_by = null, DoublearrayCore $order_by = null, $limit = null, $offset = null )
    {
        $this->setExpression( $expression );
        $this->setFrom( $from );
        $this->setWhere( $where );
        $this->setGroupBy( $group_by );
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
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param string $expression
     */
    public function setExpression( $expression )
    {
        $this->expression = $expression;
    }

    /**
     * @return string
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @param string $groupBy
     */
    public function setGroupBy( $groupBy, $_ = null )
    {
        $this->groupBy = implode( ", ", func_get_args() );
    }

    /**
     * @return string
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * @param string $variable
     */
    public function setHaving( $having )
    {
        $this->having = $having;
    }

    // ... /GETTERS/SETTERS


    // ... ADD


    /**
     * Add expression to expression
     *
     * @param string $expression
     */
    public function addExpression( $expression )
    {
        $this->expression .= $this->getExpression() && $expression ? ", {$expression}" : "{$expression}";
    }

    /**
     * Add join to where sentence
     *
     * @param string $join Join statement
     * @param string $type [NULL]|LEFT|RIGHT
     */
    public function addJoin( $join, $type = null )
    {
        $this->from .= Core::cc( "", ( ( !empty( $type ) ) ? " {$type}" : "" ),
                " JOIN {$join}" );
    }

    /**
     * Add natural join to where sentence
     *
     * @param string $table
     * @param string $type LEFT|RIGHT|INNER|OUTER
     */
    public function addNaturalJoin( $table, $on = null, $type = null )
    {
        $this->from .= Core::cc( "", " NATURAL {$type} JOIN {$table}",
                ( ( !empty( $on ) ) ? " ON {$on}" : "" ) );
    }

    /**
     * @param string $having
     * @param string $add "AND"|["OR"]
     */
    public function addHaving( $having, $add = "AND" )
    {
        $this->having .= !empty( $add ) && $this->getHaving() && $having ? " {$add} {$having}" : "{$having}";
    }

    // ... /ADD


    /**
     * @see BuilderCoreDb::build()
     */
    public function build()
    {

        // Select
        $select = "SELECT {$this->getExpression()}";

        // From
        $from = $this->getFrom() ? "FROM {$this->getFrom()}" : "";

        // Where
        $where = $this->getWhere() ? "WHERE {$this->getWhere()}" : "";

        // Group by
        $group_by = $this->getGroupBy() ? "GROUP BY {$this->getGroupBy()}" : "";

        // Having
        $having = $this->getHaving() ? "HAVING {$this->getHaving()}" : "";

        // Order by
        $order_by = $this->getOrderBy() ? $this->getCreatedOrderBy() : "";

        // Limit
        $limit = !Core::isEmpty( $this->getLimit() ) ? $this->getCreatedLimit() : "";

        // Return query
        return Core::trimWhitespace(
                "$select $from $where $group_by $having $order_by $limit" );

    }

    /**
     * @param SelectSqlbuilderDbCore $get
     * @return SelectSqlbuilderDbCore
     */
    public static function get_( $get )
    {
        return parent::get_($get);
    }

    // /FUNCTIONS


}

?>