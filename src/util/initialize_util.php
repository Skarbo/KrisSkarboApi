<?php

class InitializeUtil
{

    // VARIABLES


    /** Source folder */
    public static $SRC = "src";
    /** Directory Seperator */
    public static $SEPERATOR = "";

    // /VARIABLES


    // CONSTRUCTOR


    private function __construct()
    {

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @param string $class_name "ClassSubFolder"
     * @return string "folder/sub/class_sub_folder.php"
     * @throws Exception
     */
    public static function getClassPathFile( $class_name, $root )
    {

        // Set directory seperator
        self::$SEPERATOR = DIRECTORY_SEPARATOR;

        $path = self::$SEPERATOR . self::getParsedClassNameFolder( $class_name,
                self::$SEPERATOR );
        $file = self::getParsedClassNameUnderscore( $class_name );
        $src = self::$SEPERATOR . self::$SRC . $path . self::$SEPERATOR . $file . ".php";

        $path_files = array ();
        $path_files[] = $root . $src;
        $path_files[] = dirname(str_replace(array("src", "initialize_util.php"),array("",""), __FILE__) ) . $src;

        foreach ( $path_files as $path_file )
        {
            if ( is_file( $path_file ) )
            {
                return strtolower( $path_file );
            }
        }

        // Get dirname called from
        $backtrace_array = debug_backtrace( true );
        $backtrace = $backtrace_array[ 1 ];

        throw new Exception(
                "Could not include class \"$class_name\" ($path_files[0]) called from " . $backtrace[ "file" ] . ":" . $backtrace[ "line" ] );

    }

    /**
     * @param string $class_name "ClassSubFolder"
     * @return string "folder/sub"
     */
    private static function getParsedClassNameFolder( $class_name, $seperator )
    {

        // Represents the result array
        $match_array = array ();

        // Preg match all
        $result = preg_match_all( "/((?<=[a-z])[A-Z]|[A-Z](?=[a-z]))/",
                $class_name, $match );

        // Empty result, return class name
        if ( !$result || empty( $match ) || empty( $match[ 0 ] ) || count(
                $match[ 0 ] ) == 1 )
        {
            return strtolower( $class_name );
        }

        // Generate text split
        $text_split = $class_name;
        foreach ( $match[ 0 ] as $letter )
        {
            $text_split = str_replace( $letter, strtolower( "|{$letter}" ),
                    $text_split );
        }

        // Split class name into array
        $folders = explode( "|", $text_split );
        array_shift( $folders );

        // First element should represent file
        $file = array_shift( $folders );

        // Reversed rest should represent folders
        $folders = array_reverse( $folders );

        return implode( $seperator, $folders );

    }

    /**
     * @param string $class_name "ClassSubFolder"
     * @return string "class_sub_folder"
     */
    private static function getParsedClassNameUnderscore( $class_name )
    {

        // Represents the result array
        $match_array = array ();

        // Preg match all
        preg_match_all( "/((?<=[a-z])[A-Z]|[A-Z](?=[a-z]))/",
                $class_name, $a );

        // Empty result, return class name
        if ( empty( $a ) )
        {
            return strtolower( $class_name );
        }

        // Foreach match, do a _ infront of capital letter
        $class_name_return = $class_name;
        foreach ( $a[ 0 ] as $value )
        {
            $class_name_return = str_replace( $value,
                    "_" . strtolower( $value ), $class_name_return );
        }

        // Removes _ in front of string
        return substr( $class_name_return, 0, 1 ) == "_" ? substr(
                $class_name_return, 1, strlen( $class_name_return ) ) : $class_name_return;

    }

    // ... /GET


// /FUNCTIONS


}

?>