<?php

class AbstractJavascriptResource extends ClassCore
{

    // VARIABLES


    protected static $ROOT_FOLDER = "javascript";
    protected static $ROOT_API = "api";

    private $jqueryApiFile = "jquery-1.7.1.min.js";
    private $jqueryUiApiFile = "jquery-ui-1.8.18.custom.min.js";
    private $jqueryHistoryApiFile = "jquery.history.js";
    private $kineticApiFile = "kinetic-v3.9.3.js";
    private $jqueryDragApiFile = "jquery.event.drag-2.0.min.js";
    private $transitionsApiFile = "fasw.transitions.min.js";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {

        // TODO: To absolute
        $this->jqueryApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryApiFile );
        $this->jqueryUiApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryUiApiFile );
        $this->jqueryHistoryApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryHistoryApiFile );
        $this->kineticApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->kineticApiFile );
        $this->jqueryDragApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryDragApiFile );
        $this->transitionsApiFile = sprintf( "%s/%s/%s/%s", "../KrisSkarboApi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->transitionsApiFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function getJqueryApiFile()
    {
        return $this->jqueryApiFile;
    }

    public function getJqueryUiApiFile()
    {
        return $this->jqueryUiApiFile;
    }

    public function getKineticApiFile()
    {
        return $this->kineticApiFile;
    }

    // /FUNCTIONS


    public function getJqueryHistoryApiFile()
    {
        return $this->jqueryHistoryApiFile;
    }

    public function getJqueryDragApiFile()
    {
        return $this->jqueryDragApiFile;
    }

    public function getTransitionsApiFile()
    {
        return $this->transitionsApiFile;
    }

}

?>