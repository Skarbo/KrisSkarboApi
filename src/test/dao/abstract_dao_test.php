<?php

abstract class AbstractDaoTest extends AbstractDbTest {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    public function setUp() {
        parent::setUp();
        
        $this->getDaoContainer()->removeAll();
    }

    /**
     * @return InterfaceDaoContainerTest
     */
    public abstract function getDaoContainer();
    
    // /FUNCTIONS


}

?>