<?php

class JavascriptUtil
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function generate( array $javascript_files, $javascript_root_file )
    {

        // Figure out last modified header
        $last_modified_time = 0;

        foreach ( $javascript_files as $file )
        {
            if ( file_exists( $file ) )
            {
                $last_modified_time = max(
                        array ( filemtime( $file ), $last_modified_time ) );
            }
        }

        // Javascript root last modified
        $last_modified_time = max(
                array ( filemtime( $javascript_root_file ), $last_modified_time ) );

        // Set Javascript as Content type
        @header( sprintf( "Content-type: %s", "text/javascript" ) );

        // Not modified
        if ( $last_modified_time )
        {
            // Set last modified
            @header(
                    sprintf( "Last-Modified: %s GMT",
                            gmdate( "D, d M Y H:i:s", $last_modified_time ) ) );

            // Get if modified since
            $if_modified_since = AbstractController::getIfModifiedSinceHeader();

            // Set status if not modified since
            if ( $last_modified_time <= $if_modified_since )
            {
                @header( "HTTP/1.1 304 Not Modified" );
                exit();
            }

            // Dump if last modified since
            echo sprintf( "// If modified since: %s\n",
                    date( "D, d M Y H:i:s e", $if_modified_since ) );
        }

        echo sprintf( "// Last modified: %s\n\n",
                date( "D, d M Y H:i:s e", $last_modified_time ) );

        // Foreach Javascript files
        foreach ( $javascript_files as $file )
        {
            if ( file_exists( $file ) )
            {
                // Get modified time
                $modified_time = filemtime( $file );

                // Dump filename and modified time
                echo sprintf(
                        "\n\n//\n// File: \"%s\" Modified: %s\n//\n\n",
                        basename( $file ),
                        date( "D, d M Y H:i:s e", $modified_time ) );

                // Dump Javascript file contents
                echo file_get_contents( $file );
            }
        }

    }

    // /FUNCTIONS


}

?>