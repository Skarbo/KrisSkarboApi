<?php

class AbstractJavascriptResource extends ClassCore {

    // VARIABLES


    protected static $ROOT_FOLDER = "javascript";
    protected static $ROOT_API = "api";

    private $jqueryApiFile = "jquery-1.9.1.min.js";
    private $jqueryMobileApiFile = "jquery.mobile-1.2.0.js";
    private $jqueryUiApiFile = "jquery-ui-1.8.18.custom.min.js";
    private $jqueryHistoryApiFile = "jquery.history.js";
    private $kineticApiFile = "kinetic-v4.5.4.js"; // "kinetic-v4.4.3.js";
    private $jqueryDragApiFile = "jquery.event.drag-2.0.min.js";
    private $transitionsApiFile = "fasw.transitions.min.js";
    private $hammerApiFile = "hammer.min.js";
    private $hammerJqueryApiFile = "jquery.hammer.min.js";
    private $knockoutApiFile = "knockout-2.1.0.js";
    private $googleChart = "https://www.google.com/jsapi";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct() {

        // TODO: To absolute
        $this->jqueryApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryApiFile );
        $this->jqueryMobileApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryMobileApiFile );
        $this->jqueryUiApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryUiApiFile );
        $this->jqueryHistoryApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryHistoryApiFile );
        $this->kineticApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->kineticApiFile );
        $this->jqueryDragApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->jqueryDragApiFile );
        $this->transitionsApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->transitionsApiFile );
        $this->hammerApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->hammerApiFile );
        $this->hammerJqueryApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->hammerJqueryApiFile );
        $this->knockoutApiFile = sprintf( "%s/%s/%s/%s", "../krisskarboapi", self::$ROOT_FOLDER, self::$ROOT_API,
                $this->knockoutApiFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function getJqueryApiFile() {
        return $this->jqueryApiFile;
    }

    public function getJqueryUiApiFile() {
        return $this->jqueryUiApiFile;
    }

    public function getKineticApiFile() {
        return $this->kineticApiFile;
    }

    // /FUNCTIONS


    public function getJqueryHistoryApiFile() {
        return $this->jqueryHistoryApiFile;
    }

    public function getJqueryDragApiFile() {
        return $this->jqueryDragApiFile;
    }

    public function getTransitionsApiFile() {
        return $this->transitionsApiFile;
    }

    public function getJqueryMobileApiFile() {
        return $this->jqueryMobileApiFile;
    }

    public function getHammerApiFile() {
        return $this->hammerApiFile;
    }

    public function getHammerJqueryApiFile() {
        return $this->hammerJqueryApiFile;
    }

    public function getKnockoutApiFile() {
        return $this->knockoutApiFile;
    }

    public function getGoogleChart() {
        return $this->googleChart;
    }

}

?>