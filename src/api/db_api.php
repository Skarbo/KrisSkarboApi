<?php

abstract class DbApi
{

    // VARIABLES


    protected $hostname = NULL;
    protected $database = NULL;
    protected $username = NULL;
    protected $password = NULL;
    protected $port = "3306";

    // /VARIABLES


    // CONSTRUCT


    /**
     * @param $hostname
     * @param $database
     * @param $username
     * @param $password
     */
    public function __construct( $hostname, $database, $username, $password )
    {
        $this->hostname = $hostname;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        register_shutdown_function( array ( $this, "disconnect" ) );
    }

    // /CONSTRUCT


    // FUNCTIONS


    public abstract function connect();

    public abstract function disconnect();

    /**
     * @param QueryDbCore $query
     * @return ResultDbCore
     * @throws DbException
     */
    public abstract function query( QueryDbCore $query );

    /**
     * Rolls back a transaction
     *
     * @return boolean
     * @throws DbException
     */
    public abstract function rollback();

    /**
     * Initiates a transaction
     *
     * @return boolean
     * @throws DbException
     */
    public abstract function beginTransaction();

    /**
     * Commits a transaction
     *
     * @return boolean
     * @throws DbException
     */
    public abstract function commit();

    /**
     * @return boolean True if connected
     */
    public abstract function isConnected();

    // /FUNCTIONS


}

?>