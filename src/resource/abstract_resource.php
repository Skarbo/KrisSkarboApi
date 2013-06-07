<?php

class AbstractResource extends ClassCore
{

    // VARIABLES


    protected static $ABSTRACT_CSS, $ABSTRACT_DB, $ABSTRACT_JAVASCRIPT, $ABSTRACT_URL;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return AbstractCssResource
     */
    public static function css()
    {
        self::$ABSTRACT_CSS = self::$ABSTRACT_CSS ? self::$ABSTRACT_CSS : new AbstractCssResource();
        return self::$ABSTRACT_CSS;
    }

    /**
     * @return AbstractDbResource
     */
    public static function db()
    {
        self::$ABSTRACT_DB = self::$ABSTRACT_DB ? self::$ABSTRACT_DB : new AbstractDbResource();
        return self::$ABSTRACT_DB;
    }

    /**
     * @return AbstractJavascriptResource
     */
    public static function javascript()
    {
        self::$ABSTRACT_JAVASCRIPT = self::$ABSTRACT_JAVASCRIPT ? self::$ABSTRACT_JAVASCRIPT : new AbstractJavascriptResource();
        return self::$ABSTRACT_JAVASCRIPT;
    }

    /**
     * @return AbstractUrlResource
     */
    public static function url()
    {
        self::$ABSTRACT_URL = self::$ABSTRACT_URL ? self::$ABSTRACT_URL : new AbstractUrlResource();
        return self::$ABSTRACT_URL;
    }

    // /FUNCTIONS


}

?>