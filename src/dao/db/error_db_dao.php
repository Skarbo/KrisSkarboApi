<?php

class ErrorDbDao extends ErrorDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GENERATE


    /**
     * @param array $error_array
     * @return ErrorModel
     */
    private static function generateError( array $error_array )
    {

        // Initiate error
        $error = new ErrorModel();

        $error->setId( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldId() ) );
        $error->setKill( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldKill() ) );
        $error->setCode( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldCode() ) );
        $error->setMessage( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldMessage() ) );
        $error->setFile( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldFile() ) );
        $error->setLine( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldLine() ) );
        $error->setOccured( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldOccured() ) );
        $error->setUrl( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldUrl() ) );
        $error->setBacktrack( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldBacktrack() ) );
        $error->setTrace( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldTrace() ) );
        $error->setQuery( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldQuery() ) );
        $error->setException( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldException() ) );
        $error->setUpdated(
                strtotime( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldUpdated() ) ) );
        $error->setRegistered(
                strtotime( Core::arrayAt( $error_array, AbstractResource::db()->error()->getFieldRegistered() ) ) );

        // Return error
        return $error;

    }

    /**
     * @param array $errors_array
     * @return ErrorListModel
     */
    private static function generateErrors( array $errors_array )
    {

        // Initiate errors
        $errors = new ErrorListModel();

        foreach ( $errors_array as $error_array )
        {
            $errors->add( self::generateError( $error_array ) );
        }

        // Return errors
        return $errors;

    }

    // ... /GENERATE


    /**
     * @see ErrorDao::addError()
     */
    public function addError( ErrorModel $error )
    {

        // Insert query
        $insert_query = new InsertQueryDbCore();

        // Generate query
        $insert_builder = new InsertSqlbuilderDbCore();

        $insert_builder->setInto( AbstractResource::db()->error()->getTable() );
        $insert_builder->setSetValues(
                array ( AbstractResource::db()->error()->getFieldKill() => ":error_kill",
                        AbstractResource::db()->error()->getFieldCode() => ":error_code",
                        AbstractResource::db()->error()->getFieldMessage() => ":error_message",
                        AbstractResource::db()->error()->getFieldFile() => ":error_file",
                        AbstractResource::db()->error()->getFieldLine() => ":error_line",
                        AbstractResource::db()->error()->getFieldUrl() => ":error_url",
                        AbstractResource::db()->error()->getFieldBacktrack() => ":error_backtrack",
                        AbstractResource::db()->error()->getFieldTrace() => ":error_trace",
                        AbstractResource::db()->error()->getFieldQuery() => ":error_query",
                        AbstractResource::db()->error()->getFieldException() => ":error_exception" ) );
        $insert_builder->setDuplicate(
                array ( AbstractResource::db()->error()->getFieldKill() => ":error_kill",
                        AbstractResource::db()->error()->getFieldMessage() => ":error_message",
                        AbstractResource::db()->error()->getFieldBacktrack() => ":error_backtrack",
                        AbstractResource::db()->error()->getFieldTrace() => ":error_trace",
                        AbstractResource::db()->error()->getFieldQuery() => ":error_query",
                        AbstractResource::db()->error()->getFieldUrl() => ":error_url",
                        AbstractResource::db()->error()->getFieldException() => ":error_exception",
                        AbstractResource::db()->error()->getFieldOccured() => SB::add(
                                AbstractResource::db()->error()->getFieldOccured(), "1" ),
                        AbstractResource::db()->error()->getFieldUpdated() => SB::$CURRENT_TIMESTAMP ) );

        $insert_query->setQuery( $insert_builder );

        // Generate binds
        $binds = array ();
        $binds[ "error_kill" ] = Core::empty_( $error->getKill(), 0 );
        $binds[ "error_code" ] = $error->getCode();
        $binds[ "error_message" ] = $error->getMessage();
        $binds[ "error_file" ] = $error->getFile();
        $binds[ "error_line" ] = $error->getLine();
        $binds[ "error_url" ] = $error->getUrl();
        $binds[ "error_backtrack" ] = $error->getBacktrack();
        $binds[ "error_trace" ] = $error->getTrace();
        $binds[ "error_query" ] = $error->getQuery();
        $binds[ "error_exception" ] = $error->getException();

        $insert_query->setBinds( $binds );

        // Do insert
        $result = $this->getDbApi()->query( $insert_query );

        // Return Error id
        return $result->getInsertId();

    }

    /**
     * @see ErrorDao::getAll()
     */
    public function getAll()
    {

        // Generate select
        $select_query = new SelectQueryDbCore();

        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( "*" );
        $select_build->setFrom( AbstractResource::db()->error()->getTable() );
        $select_build->setOrderBy(
                array (
                        array (
                                SB::ifnull( AbstractResource::db()->error()->getFieldUpdated(), null,
                                        AbstractResource::db()->error()->getFieldRegistered() ), SB::$DESC ) ) );

        $select_query->setQuery( $select_build );

        // Do select
        $result = $this->getDbApi()->query( $select_query );
        // Return error list
        return self::generateErrors( $result->getRows() );

    }

    // /FUNCTIONS


}

?>