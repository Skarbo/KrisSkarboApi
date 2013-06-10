<?php

include_once dirname( str_replace( "javascript", "", __FILE__ ) ) . '/src/util/initialize_util.php';

function __autoload( $class_name ) {
    try {
        $class_path = InitializeUtil::getClassPathFile( $class_name, realpath( "." ) );
        require_once ( $class_path );
    }
    catch ( Exception $e ) {
        throw $e;
    }
}

// Javascript files
$JAVASCRIPT_FILES = array ();

$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/core" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/controller" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/event" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/handler" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/view" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/model" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/db" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/gui" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( dirname( __FILE__ ) . "/dao" ) );

// Javascript generate
//JavascriptUtil::generate( $JAVASCRIPT_FILES, __FILE__ );


?>