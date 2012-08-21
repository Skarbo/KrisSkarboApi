<?php

class RawSqlbuilderDbCore extends SqlbuilderDbCore
{

    // VARIABLES


    /**
     * @var string
     */
    private $query;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @param string $query Raw query
     */
    function __construct( $query )
    {
        $this->setQuery( $query );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery( $query )
    {
        $this->query = $query;
    }

    // ... /GETTERS/SETTERS


    /**
     * @see BuilderCoreDb::build()
     */
    public function build( )
    {
        return Core::trimWhitespace( $this->getQuery() );
    }

    // /FUNCTIONS


}

?>