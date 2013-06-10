<?php

class DebugDbDao extends DebugDao {
    
    private static $REMOVE_SESSION = 5;

    /**
     * @see DebugDao::addDebug()
     */
    public function addDebug( DebugModel $debug ) {
        
        // Insert query
        $insert_query = new InsertQueryDbCore();
        
        // Generate query
        $query_builder = new InsertSqlbuilderDbCore();
        $query_builder->setInto( AbstractResource::db()->debug()->getTable() );
        $query_builder->setSetValues( 
                array ( AbstractResource::db()->debug()->getFieldSession() => ":debug_session", 
                        AbstractResource::db()->debug()->getFieldLevel() => ":debug_level", 
                        AbstractResource::db()->debug()->getFieldData() => ":debug_data", 
                        AbstractResource::db()->debug()->getFieldFile() => ":debug_file", 
                        AbstractResource::db()->debug()->getFieldLine() => ":debug_line", 
                        AbstractResource::db()->debug()->getFieldBacktrack() => ":debug_backtrack", 
                        AbstractResource::db()->debug()->getFieldTrace() => ":debug_trace", 
                        AbstractResource::db()->debug()->getFieldType() => ":debug_type" ) );
        
        // Set query
        $insert_query->setQuery( $query_builder );
        
        // Generate binds
        $binds = array ();
        $binds[ "debug_session" ] = $debug->getSession();
        $binds[ "debug_level" ] = $debug->getLevel();
        $binds[ "debug_data" ] = $debug->getData();
        $binds[ "debug_file" ] = $debug->getFile();
        $binds[ "debug_line" ] = $debug->getLine();
        $binds[ "debug_backtrack" ] = $debug->getBacktrack();
        $binds[ "debug_trace" ] = $debug->getTrace();
        $binds[ "debug_type" ] = $debug->getType();
        
        // Set binds
        $insert_query->setBinds( $binds );
        
        // Do insert
        $result = $this->getDbApi()->query( $insert_query );
        
        // Return Debug id
        return $result->getInsertId();
    
    }

    /**
     * @see DebugDao::removeDebugs()
     */
    public function removeDebugs() {
        
        // Get next session
        $session = $this->getNextSession();
        
        // Delete query
        $delete_query = new DeleteQueryDbCore( 
                new DeleteSqlbuilderDbCore( AbstractResource::db()->debug()->getTable(), 
                        SB::gte( SB::minus( $session, AbstractResource::db()->debug()->getFieldSession() ), 
                                self::$REMOVE_SESSION ) ) );
        
        // Do delete
        $result = $this->getDbApi()->query( $delete_query );
        
        // Return deleted rows
        return $result->getAffectedRows();
    
    }

    /**
     * @see DebugDao::getNextSession()
     */
    public function getNextSession() {
        
        // Generate select
        $select_query = new SelectQueryDbCore();
        
        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( SB::as_( AbstractResource::db()->debug()->getFieldSession(), "session" ) );
        $select_build->setFrom( AbstractResource::db()->debug()->getTable() );
        $select_build->setOrderBy( array ( array ( AbstractResource::db()->debug()->getFieldSession(), SB::$DESC ) ) );
        $select_build->setLimit( 1 );
        
        $select_query->setQuery( $select_build );
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Get session
        $session = Core::arrayAt( $result->getRow( 0 ), "session" );
        
        // Return session
        return intval( $session ) + 1;
    
    }

}

?>