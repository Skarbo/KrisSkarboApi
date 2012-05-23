<?php

class DebugDbDao extends DebugDao
{

    /**
     * @see DebugDao::addDebug()
     */
    public function addDebug( DebugModel $debug )
    {

        // Insert query
        $insert_query = new InsertQueryDbCore();

        // Generate query
        $query_builder = new InsertSqlbuilderDbCore();
        $query_builder->setInto( AbstractResource::db()->debug()->getTable() );
        $query_builder->setSetValues(
                array (
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
    public function removeDebugs()
    {

        // Delete query
        $delete_query = new DeleteQueryDbCore(
                new DeleteSqlbuilderDbCore( AbstractResource::db()->debug()->getTable() ) );

        // Do delete
        $result = $this->getDbApi()->query( $delete_query );

        // Return deleted rows
        return $result->getAffectedRows();

    }

}

?>