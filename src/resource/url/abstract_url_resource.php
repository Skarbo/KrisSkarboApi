<?php

class AbstractUrlResource extends ClassCore {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    public static function getFullUrl( $url ) {
        $protocol = ( isset( $_SERVER[ 'HTTPS' ] ) && ( $_SERVER[ 'HTTPS' ] === 'on' || $_SERVER[ 'HTTPS' ] == 1 ) ) ? "https" : "http";
        $port = intval( $_SERVER[ 'SERVER_PORT' ] ) != 80 ? sprintf( ":%s", $_SERVER[ 'SERVER_PORT' ] ) : "";
        
        return sprintf( "%s://%s%s%s", $protocol, $_SERVER[ "HTTP_HOST" ], 
                Core::arrayAt( explode( "?", $_SERVER[ "REQUEST_URI" ] ), 0 ), $url );
    }

    public static function getUrl( $file, $mode = null, $url = "" ) {
        return sprintf( "%s?%s%s", $file, $url, $mode ? sprintf( "&mode=%s", $mode ) : "" );
    }
    
    // /FUNCTIONS


}

?>