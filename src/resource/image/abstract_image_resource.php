<?php

class AbstractImageResource extends ClassCore
{

    // VARIABLES


    public static $FOLDER_IMAGE = "image";
    private static $ROOT = "../krisskarboapi/image/";

    private $emptyImage = "1x1.png";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getEmptyImage()
    {
        return sprintf( "%s/%s", self::$ROOT, $this->emptyImage );
    }

    // /FUNCTIONS


}

?>