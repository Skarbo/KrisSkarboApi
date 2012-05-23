<?php

include_once dirname( str_replace("css", "", __FILE__ ) ) . '/src/util/initialize_util.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name,
                realpath( "." ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        throw $e;
    }
}

// CSS files
$CSS_FILES = array ();

$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( dirname( __FILE__ ) . "/view" ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( dirname( __FILE__ ) . "/gui" ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( dirname( __FILE__ ) . "/core" ) );

?>