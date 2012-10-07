<?php

abstract class SqlbuilderDbCore extends ClassCore
{

    // VARIABLES


    // ... CONSTANTS


    public static $LEFT = "LEFT";
    public static $RIGHT = "RIGHT";
    public static $OUTER = "OUTER";

    public static $ASC = "ASC";
    public static $DESC = "DESC";

    public static $OR = " OR ";
    public static $AND = " AND ";

    public static $TRUE = "true";
    public static $FALSE = "false";
    public static $NULL = "NULL";
    public static $NOW = "NOW()";

    public static $CURRENT_DATE = "CURRENT_DATE()";
    public static $CURRENT_TIMESTAMP = "CURRENT_TIMESTAMP()";

    public static $DISTINCT = "DISTINCT";
    public static $ORDER_BY = "ORDER BY";
    public static $SEPARATOR = "SEPARATOR";

    public static $DATE_HOUR_NULL = "0000-00-00 00:00:00";
    public static $DATE_NULL = "0000-00-00";

    public static $BITWISE_AND = "&";
    public static $BITWISE_OR = "|";
    public static $ADD = "+";
    public static $MINUS = "-";

    // ... /CONSTANTS


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Builds the query
     *
     * @return string
     */
    public abstract function build();

    //	... STATIC


    /**
     * @param string $field "field"
     * @param array $values Array( "value1", "value2" )
     * @return array Array( String( ":field_0, :field_1" ), Array( "field_0" => "value1", "field_1" => "value2" ) )
     */
    public static function createIn( $field, array $values )
    {
        $in = array ();
        $binds = array ();

        for ( $i = 0; $i < count( $values ); $i++ )
        {
            $bindKey = sprintf( "%s_%d", $field, $i );
            $in[] = sprintf( ":%s", $bindKey );
            $binds[ $bindKey ] = $values[ $i ];
        }

        return array ( implode( ", ", $in ), $binds );
    }

    /**
     * @param string $left
     * @param string $right
     * @return string " left = right"
     */
    public static function equ( $left, $right )
    {
        return " $left = $right";
    }

    /**
     * @param string $left
     * @param string $right
     * @return string " left != right"
     */
    public static function notequ( $left, $right )
    {
        return " $left != $right";
    }

    /**
     * @param string $field
     * @param string $as
     * @return string "field AS as"
     */
    public static function as_( $field, $as )
    {
        return "$field AS $as";
    }

    /**
     * @param string $left
     * @param string $right
     * @return string "left LIKE right"
     */
    public static function like( $left, $right )
    {
        return "$left LIKE $right";
    }

    /**
     * @param string $condition
     * @return string "( condition )"
     */
    public static function par( $condition )
    {
        return "( $condition )";
    }

    /**
     * @param string $condition
     * @param boolean $not
     * @return string "[NOT] EXISTS condition"
     */
    public static function exists( $condition, $not = false )
    {
        return ( $not ? "NOT " : "" ) . "EXISTS " . self::par( $condition );
    }

    /**
     * @param string $left
     * @param string $right
     * @return string "( $left + $right )"
     */
    public static function add( $left, $right )
    {
        return self::par( "$left + $right" );
    }

    /**
     * @param string $left
     * @param string $right
     * @return string "(left AND right [AND right, ...])"
     */
    public static function and_( $left, $right, $_ = null )
    {
        return self::par( implode( self::$AND, func_get_args() ) );
    }

    /**
     * @param string $left
     * @param string $right
     * @return string "(left OR right)"
     */
    public static function or_( $left, $right )
    {
        return self::par( Core::cc( " ", $left, self::$OR, $right ) );
    }

    /**
     * @param string $table
     * @param string $as_table
     * @return string "(table AS as_table)"
     */
    public static function tblAs( $table, $as_table )
    {
        return Core::cc( " ", $table, "AS", $as_table );
    }

    /**
     * @param string $table
     * @param string $field
     * @return string "table.field"
     */
    public static function pun( $table, $field )
    {
        return "`$table`.$field";
    }

    /**
     * @param string $field
     * @param string $from
     * @param string $to
     */
    public static function replace( $field, $from, $to )
    {
        return "REPLACE({$field}, {$from}, {$to})";
    }

    /**
     * @param string $ifnull
     * @param string $as
     * @param string $default ["NULL"]
     */
    public static function ifnull( $ifnull, $as = null, $default = "NULL" )
    {
        return sprintf( "IFNULL( ( %s ), %s )%s", $ifnull, $default, $as ? sprintf( " AS %s", $as ) : "" );
    }

    /**
     * @param string $if
     * @param string $then
     * @param string $else
     * @return string "IF( $if, $then, $else )"
     */
    public static function if_( $if, $then, $else )
    {
        return "IF( $if, $then, $else )";
    }

    /**
     * @param string $isnull
     * @return string "isnull IS NULL"
     */
    public static function isnull( $isnull )
    {
        return "$isnull IS NULL";
    }

    /**
     * @param string $table
     * @param string $on
     * @return string "table ON on"
     */
    public static function join( $table, $on )
    {
        return "$table ON $on";
    }

    /**
     * @param string $expression DISTINCT field_title ORDER BY field_order SEPERATOR ', '
     * @return string "GROUP_CONCAT( expression )"
     */
    public static function groupConcat( $expression )
    {
        return "GROUP_CONCAT( $expression )";
    }

    /**
     * @param string $sum
     * @return string "SUM( sum )"
     */
    public static function sum( $sum )
    {
        return "SUM( $sum )";
    }

    /**
     * @param srting $name
     * @param string $delimiter
     * @param int $count
     * @return string SUBSTRING_INDEX(name, delimiter, count)
     */
    public static function substringIndex( $name, $delimiter, $count )
    {
        return sprintf( "SUBSTRING_INDEX(%s, %s, %d)", $name, $delimiter, $count );
    }

    /**
     * @param string $count
     * @return string "COUNT( $count )"
     */
    public static function count( $count )
    {
        return "COUNT( $count )";
    }

    /**
     * @param string $concat [, $concat ]
     * @return "CONCAT_WS (concat)"
     */
    public static function concat( $seperator, $concat )
    {
        return sprintf( "CONCAT_WS( '%s', %s )", $seperator, implode( ", ", Core::arrayPopFront( func_get_args() ) ) );
    }

    /**
     * @param string $not
     * @return string "NOT( not )"
     */
    public static function not( $not )
    {
        return "NOT( $not )";
    }

    /**
     * @param string $field
     * @return string "DATE( $field )"
     */
    public static function date( $field )
    {
        return "DATE( $field )";
    }

    /**
     * @param string $field
     * @return string "DAYNAME( $field )"
     */
    public static function dayname( $field )
    {
        return "DAYNAME( $field )";
    }

    /**
     * @param string $date_start SQL Date
     * @param string $date_end SQL Date
     * @return string "DATEDIFF( start, end )"
     */
    public static function datediff( $date_start, $date_end )
    {
        return "DATEDIFF( $date_start, $date_end )";
    }

    /**
     * @param string $unixtime
     * @return string "FROM_UNIXTIME( unixtime )"
     */
    public static function fromunixtime( $unixtime )
    {
        return "FROM_UNIXTIME( $unixtime )";
    }

    /**
     * Left greater or equal to right
     *
     * @param string $left
     * @param string $right
     * @return string "left >= right"
     */
    public static function gte( $left, $right )
    {
        return "( $left >= $right )";
    }

    /**
     * Left lower or equal to right
     *
     * @param string $left
     * @param string $right
     * @return string "left <= right"
     */
    public static function lte( $left, $right )
    {
        return "( $left <= $right )";
    }

    /**
     * @param string $limit
     * @param string $offset
     * @return string "LIMIT $limit[ OFFSET $offset]"
     */
    public static function limit( $limit, $offset = NULL )
    {
        return "LIMIT $limit" . ( $offset ? " OFFSET $offset" : NULL );
    }

    /**
     * @param string $condition
     * @return string "condition IS NOT NULL"
     */
    public static function isnotnull( $condition )
    {
        return "$condition IS NOT NULL";
    }

    /**
     * @param string $expr
     * @param string $min
     * @param string $max
     * @return string "$expr BETWEEN $min AND $max"
     */
    public static function between( $expr, $min, $max )
    {
        return "$expr BETWEEN $min AND $max";
    }

    /**
     * @param string $field
     * @param integer $bit
     * @return string "$field & $bit"
     */
    public static function bitwiseAnd( $field, $bit )
    {
        return self::par( Core::cc( " ", $field, self::$BITWISE_AND, $bit ) );
    }

    /**
     * @param string $field
     * @param integer $bit
     * @return string "$field | $bit"
     */
    public static function bitwiseOr( $field, $bit )
    {
        return self::par( Core::cc( " ", $field, self::$BITWISE_OR, $bit ) );
    }

    /**
     * @param string $date YYYY-MM-DD HH:II
     * @return string UNIX_TIMESTAMP( $date )
     */
    public static function unix_timestamp( $date = "" )
    {
        return "UNIX_TIMESTAMP( $date )";
    }

    /**
     * @param string $field
     * @return string "WEEK( $field )"
     */
    public static function week( $field )
    {
        return "WEEK( $field )";
    }

    /**
     * @param string $field
     * @return string "YEAR( field )"
     */
    public static function year( $field )
    {
        return "YEAR( $field )";
    }

    /**
     * @param string $value
     * @return string "'value'";
     */
    public static function quote( $value )
    {
        return "'$value'";
    }

    /**
     * @param string $field
     * @return string "MONTH( field )"
     */
    public static function month( $field )
    {
        return "MONTH( $field )";
    }

    /**
     * @param string $left
     * @param string $right
     * @return string "(LEFT - RIGHT )"
     */
    public static function minus( $left, $right )
    {
        return self::par( "${left} - ${right}" );
    }

    /**
     * @param string $field
     * @param string $in
     * @return string "$field IN ( in )"
     */
    public static function in( $field, $in )
    {
        return "$field IN " . self::par( $in ? $in : self::$NULL );
    }

    /**
     * @param string $field
     * @param string $in
     * @return string "$field NOT IN ( in )"
     */
    public static function notin( $field, $in )
    {
        return "$field NOT IN " . self::par( $in );
    }

    /**
     * @param string $field
     * @return string TO_DAYS( $field )
     */
    public static function toDays( $field )
    {
        return "TO_DAYS( $field )";
    }

    /**
     * Calculates days to given date
     *
     * @param string $field
     * @param string $to
     * @return string "( TO_DAYS( field ) - TO_DAYS( to ) )"
     */
    public static function toDaysCount( $field, $to )
    {
        return self::par( Core::cc( " ", self::toDays( $field ), self::$MINUS, self::toDays( $to ) ) );
    }

    //	... /STATIC


    /**
     * @param SqlbuilderDbCore $get
     * @return SqlbuilderDbCore
     */
    public static function get_( $get )
    {
        return $get;
    }

    // /FUNCTIONS


}

/**
 * Short class of SqlBuilder
 */
abstract class SB extends SqlbuilderDbCore
{

}

?>