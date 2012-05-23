<?php

abstract class Controller extends ClassCore
{

    // VARIABLES


    // ... CONSTANTS


    const URI_CONTROLLER = 0;

    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NO_CONTENT = 204;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOW_ALLOWED = 405;
    const STATUS_NOT_ACCAPTABLE = 406;
    const STATUS_SERVER_ERROR = 500;

    const CONTENT_TYPE_JSON = "application/json";

    private static $URI_SPLITTER = "/";
    private static $REQUEST_METHOD_POST = "POST";
    private static $REQUEST_METHOD_GET = "GET";
    private static $GET_MODE = "mode";

    // ... /CONSTANTS


    /**
     * @var DbApi
     */
    private $db_api;
    /**
     * @var View
     */
    private $view;
    /**
     * @var AbstractDefaultLocale
     */
    private $locale;
    /**
     * @var integer
     */
    private $mode;
    /** Status code */
    private $status_code = self::STATUS_OK;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @param DbApi $db_api
     * @param AbstractDefaultLocale $locale
     * @param View $view
     * @param integer Mode
     */
    public function __construct( DbApi $db_api, AbstractDefaultLocale $locale, View $view, $mode )
    {

        $this->db_api = $db_api;
        $this->view = $view;
        $this->locale = $locale;
        $this->mode = $mode;

        // Set Controller to View
        if ( $view )
        {
            $this->getView()->setController( $this );
        }

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return DbApi
     */
    public function getDbApi()
    {
        return $this->db_api;
    }

    /**
     * @param DbApi $db_api
     */
    public function setDbApi( DbApi $db_api )
    {
        $this->db_api = $db_api;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param View $view
     */
    public function setView( View $view )
    {
        $this->view = $view;
    }

    /**
     * @return AbstractDefaultLocale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param AbstractDefaultLocale $locale
     */
    public function setLocale( AbstractDefaultLocale $locale )
    {
        $this->locale = $locale;
    }

    /**
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param integer $status_code
     */
    protected function setStatusCode( integer $status_code )
    {
        $this->status_code = $status_code;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * Path info is given as the first parameter in the query
     *
     * @return string Path info given in first parameter in URL
     */
    public static function getPathInfo()
    {
        $get_keys = array_keys( $_GET );
        if ( count( $_GET ) > 0 && substr( $get_keys[ 0 ], 0, 1 ) == self::$URI_SPLITTER )
        {
            return urldecode( $get_keys[ 0 ] );
        }
        else
        {
            return "";
        }
    }

    /**
     * Returns the URI at given position
     *
     * @param int $index URI index (0 contains the controller)
     * @param mixed $def [null] Default
     * @return string URI at given position, null if none set
     */
    protected static function getURI( $index, $def = null )
    {
        // Explode path info into array, splittet by uri splitter
        $path_info_array = explode( self::$URI_SPLITTER, self::getPathInfo() );

        // Shift path info array, first element should be null
        if ( !Core::arrayAt( $path_info_array, 0 ) )
        {
            array_shift( $path_info_array );
        }

        // Return URI
        return Core::arrayAt( $path_info_array, $index, $def );

    }

    /**
     * Returns controller name, from path info
     *
     * @return string Controller name
     */
    public static function getController()
    {
        return self::getURI( self::URI_CONTROLLER );
    }

    /**
     * POST and GET are sent as SERVER[request method]. Prototype ajax methods DELETE and PUT are sent as an argument in POST[_method].
     *
     * @return string
     */
    public static function getRequestMethod()
    {
        return $_POST[ "_method" ] ? strtoupper( $_POST[ "_method" ] ) : strtoupper( $_SERVER[ "REQUEST_METHOD" ] );
    }

    /**
     * @return array Query array
     */
    public static function getQuery()
    {
        return $_GET;
    }

    /**
     * @return array Post data
     */
    public static function getPost()
    {
        return $_POST;
    }

    /**
     * @return array Raw post data
     */
    public static function getPostRaw()
    {
        return $GLOBALS['HTTP_RAW_POST_DATA'];
    }

    /**
     * @return integer Mode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return integer Time if modified since header value, null if not given
     */
    public static function getIfModifiedSinceHeader()
    {
        // Not modified
        if ( php_sapi_name() == 'apache2handler' || php_sapi_name() == 'apache' )
        {
            $headers = apache_request_headers();
            if ( isset( $headers[ 'If-Modified-Since' ] ) && !empty( $headers[ 'If-Modified-Since' ] ) )
            {
                // Return modified since time
                return strtotime( $headers[ "If-Modified-Since" ] );
            }
        }

        // Return null
        return null;
    }

    /**
     * @return integer Time since last modified, null if not given
     */
    public function getLastModified()
    {
        return filemtime( __FILE__ );
    }

    // ... /GET


    // ... IS


    public static function isGet()
    {
        return self::getRequestMethod() == self::$REQUEST_METHOD_GET;
    }

    public static function isPost()
    {
        return self::getRequestMethod() == self::$REQUEST_METHOD_POST;
    }

    /**
     * @param string $controller
     * @return boolean True if controller equals given controller
     */
    public static function isController( $controller )
    {
        return self::getController() == $controller;
    }

    // ... /IS


    /**
     * Called before request
     */
    public function before()
    {
    }

    /**
     * Redirect
     *
     * @param string $url
     */
    public static function redirect( $url )
    {
        header( sprintf( "Location: %s", $url ) );
        exit();
    }

    /**
     * Called at request
     */
    public abstract function request();

    /**
     * Called after request
     */
    public function after()
    {
    }

    /**
     * Called at time to render
     *
     * @param AbstractXhtml $root
     */
    public function render( AbstractXhtml $root )
    {

        // Before draw
        $this->getView()->before();

        // Draw
        $this->getView()->draw( $root );

        // After draw
        $this->getView()->after();

    }

    /**
     * Called after render
     */
    public function destroy()
    {
    }

    // /FUNCTIONS


}

?>