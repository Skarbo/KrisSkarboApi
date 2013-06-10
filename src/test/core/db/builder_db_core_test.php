<?php

class BuilderDbCoreTest extends UnitTestCase {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    public function __construct() {
        parent::__construct( "BuilderCoreDb test" );
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    public function testSelectBuilder() {
        
        // Select builder
        $select_builder = new SelectSqlbuilderDbCore();
        
        $select_builder->setExpression( "expression" );
        $select_builder->addExpression( "expression2" );
        $select_builder->addExpression( new SelectSqlbuilderDbCore( "expression3", "from3" ) );
        $select_builder->setFrom( "from" );
        $select_builder->addFrom( "from2" );
        $select_builder->addJoin( "table1" );
        $select_builder->addJoin( SB::join( "table2", "from.join = table2.join" ), SB::$LEFT );
        $select_builder->setWhere( "con = 'dition'" );
        $select_builder->addWhere( "con2 = 'dition2'" );
        $select_builder->addWhere( "con3 = 'dition3'", "OR" );
        $select_builder->setGroupBy( "groupby" );
        $select_builder->setHaving( "having" );
        $select_builder->addHaving( "having2" );
        $select_builder->addHaving( "having3", "OR" );
        $select_builder->setOrderBy( array ( array ( "order", "by" ), array ( "order2", "by2" ) ) );
        $select_builder->setLimit( "limit", "offset" );
        
        $select_query = Core::cc( " ", 
                "SELECT expression, expression2, ( SELECT expression3 FROM from3 ) FROM from, from2", 
                "JOIN table1 LEFT JOIN table2 ON from.join = table2.join", 
                "WHERE con = 'dition' AND con2 = 'dition2' OR con3 = 'dition3'", 
                "GROUP BY groupby HAVING having AND having2 OR having3", "ORDER BY order by, order2 by2", 
                "LIMIT limit, offset" );
        
        // Assert select builder
        $select_query_build = $select_builder->build();
        $this->assertEqual( $select_query, $select_query_build, "Select query should be equal" ) or $this->dump( 
                $select_query_build, "Builded select query" );
    
    }

    public function testUpdateBuilder() {
        
        // Update builder
        $update_builder = new UpdateSqlbuilderDbCore();
        
        $update_builder->setTable( "table" );
        $update_builder->setSet( array ( "column" => "value", "column2" => "value2" ) );
        $update_builder->setWhere( "where" );
        $update_builder->addWhere( "where2" );
        $update_builder->addWhere( "where3", "OR" );
        $update_builder->setOrderBy( array ( array ( "order", "by" ), array ( "order2", "by2" ) ) );
        $update_builder->setLimit( "limit", "offset" );
        
        $update_query = Core::cc( " ", "UPDATE table", "SET column = value, column2 = value2", 
                "WHERE where AND where2 OR where3", "ORDER BY order by, order2 by2", "LIMIT limit, offset" );
        
        // Assert update builder
        $update_query_build = $update_builder->build();
        $this->assertEqual( $update_query, $update_query_build, "Update query should be equal" ) or $this->dump( 
                $update_query_build, "Builded update query" );
    
    }

    public function testInsertBuilder() {
        
        // Insert builder
        $insert_builder = new InsertSqlbuilderDbCore();
        
        $insert_builder->setInto( "into" );
        $insert_builder->setSet( array ( "set", "set2" ) );
        $insert_builder->setValues( array ( "value", "value2" ) );
        $insert_builder->setDuplicate( array ( "dup" => "licate" ) );
        
        $insert_query = Core::cc( " ", "INSERT INTO into", "(set, set2)", "VALUES (value, value2)", 
                "ON DUPLICATE KEY UPDATE dup = licate" );
        
        // Assert insert builder
        $insert_query_builder = $insert_builder->build();
        $this->assertEqual( $insert_query, $insert_query_builder, "Insert query should be equal" ) or $this->dump( 
                $insert_query_builder . "\n" . $insert_query, "Builded insert query" );
    
    }

    public function testDeleteBuilder() {
        
        // Delete builder
        $delete_builder = new DeleteSqlbuilderDbCore();
        
        $delete_builder->setFrom( "from" );
        $delete_builder->setWhere( "where" );
        $delete_builder->setOrderBy( array ( array ( "order", "by" ), array ( "order2", "by2" ) ) );
        $delete_builder->setLimit( "limit", "offset" );
        
        $delete_query = Core::cc( " ", "DELETE FROM from", "WHERE where", "ORDER BY order by, order2 by2", 
                "LIMIT limit, offset" );
        
        //Aassert delete builder
        $delete_query_builder = $delete_builder->build();
        $this->assertEqual( $delete_query, $delete_query_builder, "Delete query should be equal" ) or $this->dump( 
                $delete_query_builder . "\n" . $delete_query, "Builded delete query" );
    
    }
    
    // /FUNCTIONS


}

?>