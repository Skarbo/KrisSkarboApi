<?php

include_once 'src/util/initialize_util.php';
include_once '../SimpleTest/simpletest/autorun.php';
include_once '../SimpleTest/simpletest/web_tester.php';

function __autoload( $class_name ) {
    try {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e ) {
        throw $e;
    }
}

class AllTests extends TestSuite {

    public function __construct() {
        
        parent::TestSuite( "All tests" );
        
        $this->add( new BuilderDbCoreTest() );
    
    }

}

?>