<?php

class FileUtil
{

    // VARIABLES


    const TYPE_JAVASCRIPT = "javascript";
    const TYPE_CSS = "css";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getContentType( $file_type )
    {
        switch ( $file_type )
        {
            case self::TYPE_CSS :
                return StyleXhtml::$TYPE_CSS;

            default :
                return ScriptXhtml::$TYPE_JAVASCRIPT;
        }
    }

    private static function createComment( $comment, $file_type )
    {
        switch ( $file_type )
        {
            case self::TYPE_CSS :
                return sprintf( "/*\n %s\n */\n", $comment );

            default :
                return sprintf( "\n// %s\n", $comment );
        }
    }

    public static function generateFiles( array $files, $root_file, $file_type )
    {

        // Figure out last modified header
        $last_modified_time = 0;

        foreach ( $files as $file )
        {
            if ( file_exists( $file ) )
            {
                $last_modified_time = max(
                        array ( filemtime( $file ), $last_modified_time ) );
            }
        }

        // Root last modified
        $last_modified_time = max(
                array ( filemtime( $root_file ), $last_modified_time ) );

        // Set Content type
        @header(
                sprintf( "Content-type: %s", self::getContentType(
                        $file_type ) ) );

        // Not modified
        if ( $last_modified_time )
        {
            // Set last modified
            @header(
                    sprintf( "Last-Modified: %s GMT",
                            gmdate( "D, d M Y H:i:s", $last_modified_time ) ) );

            // Get if modified since
            $if_modified_since = Controller::getIfModifiedSinceHeader();

            // Set status if not modified since
            if ( $last_modified_time <= $if_modified_since )
            {
                @header( "HTTP/1.1 304 Not Modified" );
                exit();
            }

            // Dump if last modified since
            echo self::createComment(
                    sprintf( "If modified since: %s",
                            date( "D, d M Y H:i:s e", $if_modified_since ) ),
                    $file_type );
        }

        echo self::createComment( sprintf( "Last modified: %s",
                date( "D, d M Y H:i:s e", $last_modified_time ) ),
                    $file_type );

        // Foreach files
        foreach ( $files as $file )
        {
            if ( file_exists( $file ) )
            {
                // Get modified time
                $modified_time = filemtime( $file );

                // Dump filename and modified time
                echo self::createComment( sprintf(
                        "File: \"%s\" Modified: %s",
                        basename( $file ),
                        date( "D, d M Y H:i:s e", $modified_time ) ),
                    $file_type );

                // Dump file contents
                echo file_get_contents( $file );
            }
        }

    }

    // /FUNCTIONS


}

?>