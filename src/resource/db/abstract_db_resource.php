<?php

class AbstractDbResource extends ClassCore
{

    // VARIABLES


    private static $ERROR, $DEBUG;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    /**
     * @return ErrorDbResource
     */
    public static function error()
    {
        self::$ERROR = self::$ERROR ? self::$ERROR : new ErrorDbResource();
        return self::$ERROR;
    }

    /**
     * @return DebugDbResource
     */
    public static function debug()
    {
        self::$DEBUG = self::$DEBUG ? self::$DEBUG : new DebugDbResource();
        return self::$DEBUG;
    }

    // /FUNCTIONS


}

?>