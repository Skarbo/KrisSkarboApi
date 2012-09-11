<?php

/**
 * Static Mainfile class
 */
class Core
{

    private function __construct()
    {

    }

    /**
     * @param integer $operator 2
     * @param integer $bitwise 4
     * @return integer 6
     */
    static function addBitwise( $operator, $bitwise )
    {
        return $operator | $bitwise;
    }

    /**
     * @param array $array
     * @param mixed $value
     * @param mixed $index [null]
     */
    static function arrayAdd( array $array, $value, $index = null )
    {
        if ( is_null( $index ) )
        {
            $array[] = $value;
        }
        else
        {
            $array[ $index ] = $value;
        }
    }

    /**
     * @param array $array
     * @param mixed $index
     * @param mixed $default [null]
     * @return mixed value, null if not exist
     */
    static function arrayAt( array $array, $index, $default = null )
    {
        return $array != null && is_array( $array ) && array_key_exists( $index, $array ) ? $array[ $index ] : $default;
    }

    /**
     * Array at numeric index
     *
     * @param array $array
     * @param int $index
     * @param mixed $default
     * @return mixed Value, default if not exist
     */
    static function arrayAtIndex( array $array, $index, $default = null )
    {
        return Core::arrayAt( $array, Core::arrayAt( array_keys( $array ), $index ), $default );
    }

    /**
     * @param array $array Array( 0 => Array( 0 => W, 1 => X [, ... ] ), 1 => Array( 0 => Y, 1 => Z [, ... ] ) [, ... ] )
     * @param mixed $index Integer( 0 )
     * @return array Array( 0 => W, 1 => Y )
     */
    static function arrayAtMultiple( array $array, $index )
    {
        $return = array ();
        foreach ( $array as $v )
        {
            $return[] = self::arrayAt( $v, $index );
        }
        return $return;
    }

    /**
     * False if there is a false value in array
     *
     * @param array $array ( bool[, bool[, ... ] ] )
     * @return boolean
     */
    static function arrayBool( array $array )
    {
        return !in_array( false, $array );
    }

    /**
     * @param Array $array Array( "v1", "v2", "v3" )
     * @return Array Array( "v1" => "v1", "v2" => "v2", "v3" => "v3" )
     */
    static function arrayCombine( Array $array )
    {
        return array_combine( $array, $array );
    }

    /**
     * Pops a value in front of array stack and returns the new array
     *
     * @return array $array ( test1, test2, ... )
     * @return array ( test2, ... )
     */
    static function arrayPopFront( array $array )
    {
        array_shift( $array );
        return $array;
    }

    /**
     * @param Array $array array( "key" => "value" [, ... ] )
     * @param String $prefix ":"
     * @return Array array( ":key" => "value" [, ... ] )
     */
    static function arrayPrefixKey( $array, $prefix )
    {
        $new_array = array ();

        foreach ( is_array( $array ) ? $array : array () as $key => $value )
        {
            $new_array[ $prefix . $key ] = $value;
        }

        return $new_array;
    }

    /**
     * @return Array Array( "key" => ":value" [, ... ] )
     * @param Array $array array ( "key" => "value" [, ... ] )
     * @param String $prefix ":"
     */
    static function arrayPrefixValue( $array, $prefix )
    {
        $new_array = array ();

        foreach ( $array as $key => $value )
        {
            $new_array[ $key ] = $prefix . $value;
        }

        return $new_array;
    }

    /**
     * Returns empty array if value is not an array
     *
     * @param mixed $value
     * @return array
     */
    static function arrayEmpty( $value )
    {
        return is_array( $value ) ? $value : ( $value ? array ( $value ) : array () );
    }

    /**
     * @param string $string
     * @param string $arraySplit
     * @param string $keySplit
     * @param Closure $handleValue Function( $value ) { return mixed }
     */
    public static function arrayExplode( $string, $arraySplit, $keySplit, $handleValue = null )
    {
        $array = explode( $arraySplit, $string );
        $newArray = array ();
        foreach ( $array as $value )
        {
            $strpos = strpos( $value, $keySplit );
            $newKey = substr( $value, 0, $strpos );
            $newValue = substr( $value, $strpos + 1, strlen( $value ) );
            $newArray[ $newKey ] = $handleValue ? $handleValue( $newValue ) : $newValue;
        }
        return $newArray;
    }

    /**
     * @param array $array Array to compare to arrays
     * @param array $arrays Arrays to be compred to
     */
    public static function arrayEquals( array $array, array $arrays )
    {
        $result = array_filter( $arrays,
                function ( $var ) use($array )
                {
                    return $array == $var;
                } );
        return !empty( $result );
    }

    /**
     * @param array $array Array( "value", 0, false, NULL, "" )
     * @param boolean $filter_only_null True
     * @return array Array( "value", 0, false, "" )
     */
    static function arrayFilter( Array $array, $filter_only_null = true )
    {
        $func = function ( $value ) use($filter_only_null )
        {
            return $filter_only_null ? !is_null( $value ) : $value != FALSE;
        };

        return array_filter( $array, $func );
    }

    /**
     * Searches for element in mulitdimentional array and returns how many times i occurs
     *
     * @param string $elem
     * @param array $array
     * @return integer Times occured in array
     */
    static function arrayIn( $elem, array $array )
    {
        $top = sizeof( $array ) - 1;
        $bottom = 0;
        $found = 0;
        while ( $bottom <= $top )
        {
            if ( $array[ $bottom ] == $elem )
                $found++;
            else if ( is_array( $array[ $bottom ] ) )
                if ( self::arrayIn( $elem, ( $array[ $bottom ] ) ) )
                    $found++;

            $bottom++;
        }
        return $found;
    }

    /**
     * @param array $array
     * @param string $arrayGlue
     * @param string $keyGlue
     * @param Closure $handleValue Function( $value ) { return string }
     * @return string
     */
    public static function arrayImplode( array $array, $arrayGlue = ",", $keyGlue = ":", $handleValue = null )
    {
        return implode( $arrayGlue,
                array_map(
                        function ( $value, $key ) use($keyGlue, $handleValue )
                        {
                            return sprintf( "%s%s%s", $key, $keyGlue, $handleValue ? $handleValue( $value ) : $value );
                        }, $array, array_keys( $array ) ) );
    }

    /**
     * @param array $array Array( "key1" => "var1", "key2" => "var2", "key3" => "var3" )
     * @param array $array_keep Array( "key2", "key3" )
     * @return array Array( "key2" => "var2", "key3" => "var3" )
     */
    public static function arrayKeepKeys( Array $array, Array $array_keep )
    {
        // Return array
        $return_array = array ();

        // Foreach array
        foreach ( $array as $key => $value )
        {
            if ( in_array( $key, $array_keep ) )
            {
                $return_array[ $key ] = $value;
            }
        }

        return $return_array;
    }

    /**
     * @param array $array Array( "key1" => "var1", "key2" => "var2", "key3" => "var3" )
     * @param array $array_key_replace Array( "key1" => "key4", "key2" => "key5" )
     * @param boolean $keep_unmatched False
     * @return array Array( "key4" => "var1", "key5" => "var2" )
     */
    public static function arrayReplaceKey( Array $array, Array $array_key_replace, $keep_unmatched = false )
    {
        // Return array
        $return_array = array ();

        // Foreach array
        foreach ( is_array( $array ) ? $array : array () as $key => $value )
        {
            // If key exists in replace array
            if ( array_key_exists( $key, $array_key_replace ) )
            {
                $return_array[ $array_key_replace[ $key ] ] = $value;
            }
            // Keep unmatched
            elseif ( $keep_unmatched )
            {
                $return_array[ $key ] = $value;
            }
        }

        return $return_array;
    }

    /**
     * @return array Array( 1, 3, 5 )
     * @param array $array Array( 1, 2, 3, 4, 5, 6 )
     * @param integer $skip Integer ( 2 )
     */
    static function arraySkip( array $array, $skip )
    {
        $return = array ();
        for ( $i = 0; $i < count( $array ); $i += $skip )
        {
            $return[] = $array[ $i ];
        }
        return $return;
    }

    /**
     * @return array Array( 1, 4, 7 )
     * @param array $array Array( 1, 2, 3, 4, 5, 6, 7, 8 )
     * @param integer $reduce 3
     */
    static function arrayReduce( array $array, $reduce )
    {
        $return = self::arraySkip( $array, ceil( count( $array ) / intval( $reduce ) ) );
        return $return;
    }

    /**
     * @return integer Integer( 4 )
     * @param array $array Array( 0, 1, 2, 3, 4 )
     */
    static function arrayMax( array $array )
    {
        asort( $array );
        return end( $array );
    }

    /**
     * Append param and values to link
     *
     * @param string $link NULL Represents the link to be appended, null if current link is to be appended
     * @param string $append Represents the field to be appended
     * @param string $value NULL Represents the field's value
     */
    static function appendLink( $link = "", $append, $value = "" )
    {

        // Link empty
        if ( empty( $link ) )
            $link = basename( $_SERVER[ "REQUEST_URI" ] );

            // Add '?' if it dosent exist
        if ( is_bool( strpos( $link, "?" ) ) )
            $link .= "?";

            // Does append exist in link	&& $posfirst = substr( $link, $pos-1, 1 ) && ( $posfirst == "?" || $posfirst == "&" )
        $pos = strpos( $link, $append );
        if ( $pos && ( substr( $link, $pos - 1, 1 ) == "?" || substr( $link, $pos - 1, 1 ) == "&" ) )
        {

            // Find the next '&'
            if ( ( $pos2 = strpos( $link, "&", $pos ) ) == true )
                $replace = substr( $link, $pos, $pos2 - $pos );
            else
                $replace = substr( $link, $pos, strlen( $link ) - $pos );

                // Value is set
            if ( !empty( $value ) )
                $link = str_replace( $replace, "$append=$value", $link );
            else
                $link = str_replace( "&" . $replace, "", $link );

        }

        // Add append to the end of the link
        elseif ( !empty( $value ) )
        {

            // Add '&' to the end
            if ( substr( $link, -1 ) != "&" && substr( $link, -1 ) != "?" )
                $link .= "&";

            $link .= "$append=$value";

        }

        return $link;

    }

    /**
     * If variable is epmty, return a default value
     *
     * @param mixed $value Checks if value is empty
     * @param mixed $default Default if value is empty
     * @return mixed
     */
    public static function empty_( $value, $default = "" )
    {
        return ( !empty( $value ) || is_numeric( $value ) ) ? $value : $default;
    }

    public static function decodeUtf8( $string )
    {
        return mb_detect_encoding( $string ) == "UTF-8" ? utf8_decode( $string ) : $string;
    }

    /**
     * @param array $array Array( "param" => "value", "param2" => Array( "param3" => "value3", "long param" => "long value" ) )
     * @return string "param=value&param2[param3]=value3&param2[long param]=long value"
     */
    public static function buildQuery( array $array, $key = NULL )
    {
        $return = array ();
        foreach ( $array as $k => $v )
        {
            if ( $key )
            {
                if ( is_array( $v ) )
                {
                    $return[] = self::buildQuery( $v, sprintf( "%s[%s]", $key, $k ) );
                }
                else
                {
                    $return[] = sprintf( "%s[%s]=%s", $key, $k, $v );
                }
            }
            else
            {
                if ( is_array( $v ) )
                {
                    $return[] = self::buildQuery( $v, $k );
                }
                else
                {
                    $return[] = sprintf( "%s=%s", $k, $v );
                }
            }
        }
        return implode( $return, "&" );
    }

    /**
     * Concat
     *
     * @param string $split " "
     * @param string $value "value" [,"value2"]
     * @return string "value value2"
     */
    public static function cc( $split, $value )
    {
        return implode( self::arrayAt( func_get_args(), 0 ), self::arrayPopFront( func_get_args() ) );
    }

    /**
     * Creates folders that don't exist
     *
     * @param string $path
     * @return boolean True if created, false if could not create folder
     */
    public static function createFolders( $path )
    {
        $pathInfo = pathinfo( $path );
        $dirs = explode( "/", $pathInfo[ "dirname" ] );

        $parent = "";
        foreach ( $dirs as $dir )
        {
            $tempDir = sprintf( "%s%s", $parent, $dir );

            // Create dir if not exist
            if ( !file_exists( $tempDir ) )
            {
                $return = mkdir( $tempDir );
                if ( !$return )
                {
                    return false;
                }
            }

            $parent .= sprintf( "%s/", $dir );
        }

        return true;
    }

    /**
     * @param mixed $mixed
     * @return string JSON data
     */
    public static function createJson( $mixed )
    {
        return json_encode( $mixed, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
    }

    /**
     * @param string $name
     * @param string $default
     * @return string Defined constant, default if not exist
     */
    public static function constant( $name, $default = "" )
    {
        return defined( $name ) ? constant( $name ) : $default;
    }

    /**
     * @param String $text
     * @return String Decoded HTML text
     */
    static function decodeHtmlCodes( $text )
    {
        return str_replace( array ( "&lt;", "&gt;", "&amp;", '&#039;', '&quot;', '&lt;', '&gt;', '&#39;', "&nbsp;" ),
                array ( "<", ">", "&", '\'', '"', '<', '>', "'", " " ), $text );
    }

    /**
     * Fix string, \n to br etc
     */
    static function fixString( $string, $trim = false )
    {

        //$string = nl2br( $string );
        //$string = str_replace( "\n", "<br>", "$string" );
        $string = nl2br( $string, true );
        $stirng = self::trim( $string, $trim );

        return $string;
    }

    /**
     * Keep the string after the occurence
     *
     * @param string $string "keep.after"
     * @param string $occurence "."
     * @return string "after"
     */
    static function keepAfter( $string, $occurence )
    {

        // Occurence is in string
        if ( strpos( $string, $occurence ) )
        {
            return str_replace( $occurence, "", strstr( $string, $occurence ) );
        }

        // Occurence is not in string
        return $string;

    }

    /**
     * @param array $array
     * @return boolean True if array is double array, or if first array is empty
     */
    static function isDoubleArray( array $array )
    {
        return is_array( $array ) && ( count( $array ) == 0 || is_array(
                self::arrayAt( $array, self::arrayAt( array_keys( $array ), 0 ) ) ) );
    }

    /**
     * If variable is numeric it is not empty
     */
    static function isEmpty( $value )
    {
        return ( empty( $value ) && !is_numeric( $value ) );
    }

    /**
     * @param string $value
     * @return bool True if value is JSON
     */
    static function isJson( $value )
    {
        return json_decode( $value ) != NULL ? true : false;
    }

    /**
     * @param string $url Url to check
     * @return bool True if url exists
     */
    static function isUrlExist( $url )
    {
        $headers = @get_headers( $url );

        if ( strpos( $headers[ 0 ], "200" ) !== false || strpos( $headers[ 0 ], "302" ) !== false || strpos(
                $headers[ 0 ], "301" ) !== false )
        {
            return true;
        }
        else
            return false;
    }

    /**
     * Check if the bitwise exists
     *
     * @param integer $operator ( 1 | 3 ) = 4
     * @param integer $bitwise 1
     * @return integer 3
     */
    static function removeBitwise( $operator, $bitwise )
    {
        return self::isBitwise( $operator, $bitwise ) ? $operator - $bitwise : $operator;
    }

    /**
     * Removes non characters, not including space
     *
     * @param String $text
     * @param String $replace [""]
     * @return String Text removed non characters
     */
    static function removeNonCharacters( $text, $replace = "" )
    {
        return preg_replace( "/[^\\w\\s]/", $replace, $text );
    }

    /**
     * Removes directory and it's content recursivly
     *
     * @param string $directory
     * @param boolean $empty
     * @return boolean
     */
    static function removeDirectoryRecursive( $directory, $empty = FALSE )
    {
        // if the path has a slash at the end we remove it here
        if ( substr( $directory, -1 ) == '/' )
        {
            $directory = substr( $directory, 0, -1 );
        }

        // if the path is not valid or is not a directory ...
        if ( !file_exists( $directory ) || !is_dir( $directory ) )
        {
            // ... we return false and exit the function
            return FALSE;

            // ... if the path is not readable
        }
        elseif ( !is_readable( $directory ) )
        {
            // ... we return false and exit the function
            return FALSE;

            // ... else if the path is readable
        }
        else
        {

            // we open the directory
            $handle = opendir( $directory );

            // and scan through the items inside
            while ( FALSE !== ( $item = readdir( $handle ) ) )
            {
                // if the filepointer is not the current directory
                // or the parent directory
                if ( $item != '.' && $item != '..' )
                {
                    // we build the new path to delete
                    $path = $directory . '/' . $item;

                    // if the new path is a directory
                    if ( is_dir( $path ) )
                    {
                        // we call this function with the new path
                        self::removeDirectoryRecursive( $path );

                        // if the new path is a file
                    }
                    else
                    {
                        // we remove the file
                        unlink( $path );
                    }
                }
            }
            // close the directory
            closedir( $handle );

            // if the option to empty is not set to true
            if ( $empty == FALSE )
            {
                // try to delete the now empty directory
                if ( !rmdir( $directory ) )
                {
                    // return false if not possible
                    return FALSE;
                }
            }
            // return success
            return TRUE;
        }
    }

    /**
     * %# represents a wildcard
     *
     * @param string $subject "replace {1} string"
     * @param string $replace "test" [, ... ]
     * @return string "replace test string"
     */
    static function replace( $subject, $replace )
    {

        // No wildcars given
        if ( strpos( $subject, "{" ) === false || strpos( $subject, "}" ) === false )
        {
            return $subject;
        }

        // Foreach each arguments
        $search_array = array ();
        for ( $i = 1; $i <= func_num_args(); $i++ )
        {
            array_push( $search_array, "{$i}" );
        }
        var_dump( $search_array );
        return str_replace( $search_array, self::arrayPopFront( func_get_args() ), $subject );

    }

    /**
     * Fills zero
     *
     * @param integer $number 2
     * @param integer $size [4]
     * @return string 0002
     */
    static function numberPadding( $number, $size = 2 )
    {
        return sprintf( "%0" . intval( $size ) . "s", intval( $number ) );
    }

    /**
     * @param mixed $date
     * @return integer Timestamp
     */
    static function parseTimestamp( $date )
    {
        return is_numeric( $date ) ? intval( $date ) : ( !empty( $date ) ? strtotime( $date ) : null );
    }

    /**
     * Generates Unique id from string
     *
     * @param string $string
     * @param integer $maxLength
     */
    static function generateId( $string, $maxLength = 50 )
    {

        $result = strtolower( $string );

        $result = preg_replace( "/[^a-z0-9 ]/", "", $result );
        //$result = trim( preg_replace( "/[-]+/", " ", $result ) );
        $result = trim( substr( $result, 0, $maxLength ) );
        $result = preg_replace( "/ /", "-", $result );

        return $result;

    }

    /**
     * Upper case first letter in sentence
     *
     * @param string $s "hEllO wORlD"
     * @return string "Hello world"
     */
    static function ucfirst( $s )
    {
        return ucfirst( strtolower( $s ) );
    }

    /**
     * Capitilize every word in sentence
     *
     * @param string $s "hEllO wORlD"
     * @return string "Hello World"
     */
    static function ucwords( $s )
    {
        return ucwords( strtolower( $s ) );
    }

    /**
     * Utf8 encode variable
     *
     * @param mixed $var String or array
     */
    static function utf8Encode( $var )
    {
        if ( is_array( $var ) )
        {
            foreach ( $var as &$value )
            {
                $value = self::utf8Encode( $value );
            }
            return $var;
        }
        else if ( is_string( $var ) )
        {
            return !mb_check_encoding( $var, 'UTF-8' ) ? utf8_encode( $var ) : $var;
        }
        else
        {
            return $var;
        }
    }

    /**
     * Utf8 decode variable
     *
     * @param mixed $var String or array
     */
    static function utf8Decode( $var )
    {
        if ( is_array( $var ) )
        {
            foreach ( $var as &$value )
            {
                $value = self::utf8Decode( $value );
            }
            return $var;
        }
        else if ( is_string( $var ) )
        {
            return mb_check_encoding( $var, 'UTF-8' ) ? utf8_decode( $var ) : $var;
        }
        else
        {
            return $var;
        }
    }

    /**
     * @param integer $operator 128
     * @param integer $bitwise 256
     * @return boolean 256 & 128
     */
    static function isBitwise( $operator, $bitwise )
    {
        return ( bool ) ( $bitwise & $operator );
    }

    /**
     * Uses str to time
     *
     * @return boolean
     * @param string $date "2010-01-01 00:00:00"
     */
    static function isDate( $date )
    {
        return ( bool ) strtotime( $date );
    }

    /**
     * @return boolean
     * @param $email
     */
    static function isEmail( $email )
    {
        return ( bool ) filter_var( $email, FILTER_VALIDATE_EMAIL );
    }

    /**
     * Create random password
     * The letter l (lowercase L) and the number 1
     * have been removed, as they can be mistaken
     * for each other.
     */
    static function generateRandomChrs( $length = 7 )
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand( ( double ) microtime() * 1000000 );
        $i = 0;
        $pass = '';

        while ( $i <= $length )
        {
            $num = rand() % 33;
            $tmp = substr( $chars, $num, 1 );
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;

    }

    static function generateRandomString( $length = 5 )
    {

        // makes a random alpha numeric string of a given lenth
        $aZ = array_merge( range( 'A', 'Z' ), range( 'a', 'z' ) );
        $out = '';
        for ( $c = 0; $c < $length; $c++ )
        {
            $out .= $aZ[ mt_rand( 0, count( $aZ ) - 1 ) ];
        }
        return $out;

    }

    static function generateRandomWords( $words_count = 3, $word_length = 5 )
    {
        $return = array ();
        for ( $i = 0; $i < $words_count; $i++ )
        {
            $return[] = self::generateRandomString( $word_length );
        }

        return implode( " ", $return );
    }

    /**
     * Collects recursivly files in directory
     *
     * @param string $path ['.']
     * @param array $ignore [array]
     * @param int $level [0]
     * @return array Array( files )
     */
    static function getDirectory( $path = '.', array $ignore = array(), $level = 0 )
    {
        $DS = DIRECTORY_SEPARATOR;
        $ignoreArray = array_merge( array ( 'cgi-bin', '.', '..', '.svn' ), $ignore );
        $dh = @opendir( $path );
        $files = array ();

        while ( false !== ( $file = readdir( $dh ) ) )
        {
            if ( !in_array( $file, $ignoreArray ) )
            {
                // File
                if ( !is_dir( "{$path}{$DS}{$file}" ) )
                {
                    array_unshift( $files, "{$path}{$DS}{$file}" );
                }
                // Folder
                else if ( is_dir( "{$path}{$DS}{$file}" ) )
                {
                    $files = array_merge( $files, self::getDirectory( "{$path}{$DS}{$file}", $ignore, ( $level + 1 ) ) );
                }
            }
        }
        closedir( $dh );

        return $files;
    }

    /**
     * Removes whitespace and trims string
     *
     * @param string $str "   much    white   space   "
     * @return string "much white space"
     */
    public static function trimWhitespace( $str )
    {
        return trim( preg_replace( "'\\s+'", ' ', $str ) );
    }

}

?>