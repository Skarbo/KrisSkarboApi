<?php

class AbstractUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getUrl( $file, $mode = null, $url = "" )
    {
        return sprintf( "%s?%s%s", $file, $url, $mode ? sprintf( "&mode=%s", $mode ) : "" );
    }

    // /FUNCTIONS


}

?>