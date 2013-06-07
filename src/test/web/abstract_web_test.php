<?php

abstract class AbstractWebTest extends WebTestCase
{

    // VARIABLES


    private $db_api;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        list ( $host, $db, $user, $pass ) = $this->getDatabaseConfig();
        $this->db_api = new PdoDbApi( $host, $db, $user, $pass );

        $this->getDbApi()->connect();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return array Array( host, db, user, pass )
     */
    public abstract function getDatabaseConfig();

    /**
     * @return DbApi
     */
    protected function getDbApi()
    {
        return $this->db_api;
    }

    public static function getWebsite( $page )
    {
        return sprintf( "http://%s%s/%s", $_SERVER[ "HTTP_HOST" ], dirname( $_SERVER[ "REQUEST_URI" ] ), $page );
    }

    public static function getWebsiteApi( $page, $arguments )
    {
        return sprintf( self::getWebsite( sprintf( "%s?/%s&mode=3", $page, $arguments ) ) );
    }

    // ... /GET


    // /FUNCTIONS


}

?>