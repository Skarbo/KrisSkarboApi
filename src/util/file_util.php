<?php

class FileUtil {

    // VARIABLES


    const TYPE_JAVASCRIPT = "javascript";
    const TYPE_CSS = "css";

    const CSS_REPLACE_NO_SELECT = '%/\* no_select \*/%';
    const CSS_REPLACE_SHADOW = '%/\* box_shadow:(.+): \*/%';
    const CSS_REPLACE_GRADIENT = '%/\* gradient:(.+):(.+):(.+):(.+): \*/%';
    const CSS_REPLACE_TRANSITION = '%/\* transition:(.+): \*/%';
    const CSS_REPLACE_TRANSFORM = '%/\* transform:(.+): \*/%';

    public static $CSS_REPLACE = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getContentType( $file_type ) {
        switch ( $file_type ) {
            case self::TYPE_CSS :
                return StyleXhtml::$TYPE_CSS;

            default :
                return ScriptXhtml::$TYPE_JAVASCRIPT;
        }
    }

    private static function createComment( $comment, $file_type ) {
        switch ( $file_type ) {
            case self::TYPE_CSS :
                return sprintf( "/*\n %s\n */\n", $comment );

            default :
                return sprintf( "\n// %s\n", $comment );
        }
    }

    private static function getFileContents( $file, $fileType, $minify = false ) {
        if ( $fileType == self::TYPE_CSS ) {

            $fileContents = file_get_contents( $file );

            // Foreach CSS replace
            foreach ( self::$CSS_REPLACE as $regex => $replace ) {
                $fileContents = preg_replace( $regex, $replace, $fileContents );
            }

            if ( $minify )
                return CssminUtil::minifyCss( $fileContents );
            return $fileContents;
        }
        else {
            $fileContents = file_get_contents( $file );
            if ( $minify )
                return JsminUtil::minify( $fileContents );
            return $fileContents;
        }
    }

    public static function generateFiles( array $files, $root_file, $file_type, $minify = false ) {

        // Figure out last modified header
        $last_modified_time = 0;

        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                $last_modified_time = max( array ( filemtime( $file ), $last_modified_time ) );
            }
        }

        // Root last modified
        $last_modified_time = max( array ( filemtime( $root_file ), $last_modified_time ) );

        // Set Content type
        @header( sprintf( "Content-type: %s", self::getContentType( $file_type ) ) );

        // Not modified
        if ( $last_modified_time ) {
            // Set last modified
            @header( sprintf( "Last-Modified: %s GMT", gmdate( "D, d M Y H:i:s", $last_modified_time ) ) );

            // Get if modified since
            $if_modified_since = AbstractController::getIfModifiedSinceHeader();

            // Set status if not modified since
            if ( $last_modified_time <= $if_modified_since ) {
                @header( "HTTP/1.1 304 Not Modified" );
                exit();
            }

            // Dump if last modified since
            echo self::createComment(
                    sprintf( "If modified since: %s", date( "D, d M Y H:i:s e", $if_modified_since ) ), $file_type );
        }

        echo self::createComment( sprintf( "Last modified: %s", date( "D, d M Y H:i:s e", $last_modified_time ) ),
                $file_type );

        // Foreach files
        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                // Get modified time
                $modified_time = filemtime( $file );

                // Dump filename and modified time
                echo self::createComment(
                        sprintf( "File: \"%s\" Modified: %s", basename( $file ),
                                date( "D, d M Y H:i:s e", $modified_time ) ), $file_type );

                // Dump file contents
                echo self::getFileContents( $file, $file_type, $minify );
            }
        }

    }

    // /FUNCTIONS


}

FileUtil::$CSS_REPLACE[ FileUtil::CSS_REPLACE_NO_SELECT ] = <<<EOF
/* No select */
    -webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
EOF;

FileUtil::$CSS_REPLACE[ FileUtil::CSS_REPLACE_SHADOW ] = <<<EOF
/* Shadow */
    box-shadow: $1;
    -moz-box-shadow: $1;
    -webkit-box-shadow: $1;
EOF;

FileUtil::$CSS_REPLACE[ FileUtil::CSS_REPLACE_GRADIENT ] = <<<EOF
/* Gradient */
	background: -webkit-gradient(linear, center top, center bottom, from($1), to($3));
    background: -webkit-linear-gradient($1, $3);
    background: -moz-linear-gradient($1, $3);
    background: -o-linear-gradient($1, $3);
    background: -ms-linear-gradient($1, $3);
    background: linear-gradient($1, $3);
EOF;

// background-image: linear-gradient(bottom, $1 $2%, $3 $4% );
// background-image: -o-linear-gradient(bottom, $1 $2%, $3 $4% );
// background-image: -moz-linear-gradient(bottom, $1 $2%, $3 $4% );
// background-image: -webkit-linear-gradient(bottom, $1 $2%, $3 $4% );
// background-image: -ms-linear-gradient(bottom, $1 $2%, $3 $4% );
// background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0.$2, $1 ), color-stop(0.$4, $3 ) );


FileUtil::$CSS_REPLACE[ FileUtil::CSS_REPLACE_TRANSITION ] = <<<EOF
/* Transition */
	-webkit-transition : $1;
	-moz-transition: $1;
	-o-transition: $1;
	transition: $1;
	-webkit-transition: $1;
EOF;

FileUtil::$CSS_REPLACE[ FileUtil::CSS_REPLACE_TRANSFORM ] = <<<EOF
/* Transform */
    transform: $1;
    -ms-transform: $1;
    -webkit-transform: $1;
EOF;

?>