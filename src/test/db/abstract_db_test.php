<?php

abstract class AbstractDbTest extends UnitTestCase {
    
    // VARIABLES
    

    private $db_api;
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    public function __construct( $label ) {
        parent::__construct( $label );
        
        $databaseConfig = $this->getDatabaseConfig();
        $this->db_api = new PdoDbApi( $databaseConfig[ "host" ], $databaseConfig[ "db" ], $databaseConfig[ "user" ], 
                $databaseConfig[ "pass" ] );
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
    protected function getDbApi() {
        return $this->db_api;
    }
    
    // ... /GET
    

    // ... BEFORE/AFTER
    

    public function setUp() {
        $this->getDbApi()->connect();
    }
    
    // ... /BEFORE/AFTER
    

    // /FUNCTIONS


}

?>