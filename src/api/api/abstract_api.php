<?php

if ( !defined( "DB_PREFIX" ) )
    define( "DB_PREFIX", "" );

abstract class AbstractApi
{

    // VARIABLES


    // ... CONSTANTS


    /** URI mapping constant */
    const MAP_CONTROLLER = "controller", MAP_VIEW = "view";

    /** Execution modes */
    const MODE_PROD = 1, MODE_DEV = 2, MODE_TEST = 3;
    public static $MODES = array ( self::MODE_PROD, self::MODE_DEV, self::MODE_TEST );

    const LOCALHOST_PORT = 8008;

    private static $LOG_FILE = "log.log";

    // ... /CONSTANTS


    /**
     * Represents the Database API
     *
     * @var DbApi
     */
    private $db_api;
    /**
     * Kill handler
     *
     * @var KillHandler
     */
    private $kill_handler;
    /**
     * Represents the Error handler
     *
     * @var ErrorHandler
     */
    private $error_handler;
    /**
     * Represents the Output handler
     *
     * @var OutputHandler
     */
    private $output_handler;
    /**
     * Represents the current Locale
     *
     * @var DefaultLocale
     */
    private $locale;
    /** Execution mode */
    private $mode;
    /** Default execution mode */
    private $modeDefault;
    /** Debug handler */
    private $debug_handler;
    /**
     * @var DbbackupHandler
     */
    private $dbbackupHandler;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * Calls autoload setup, error handling setup, database and locale setup
     */
    public function __construct( $modeDefault = self::MODE_PROD )
    {
        $this->modeDefault = $modeDefault;
        $this->mode = in_array( Core::arrayAt( AbstractController::getQuery(), "mode", array () ), self::$MODES ) ? intval(
                Core::arrayAt( AbstractController::getQuery(), "mode" ) ) : $modeDefault;
        $this->doTimeSetup();
        $this->doErrorhandlingSetup();
        $this->doDatabaseAndLocaleSetup( $this->getMode() );

        // Destruct function
        //register_shutdown_function( array ( $this, "destruct" ) );
    }

    // /CONSTRUCTOR


    // DECONSTRUCTOR


    public function destruct()
    {
        try
        {

            // Disconnect database
            $this->getDbApi()->disconnect();

            // Backup database
            $dbbackupHandler = $this->getDbbackupHandler();

            if ( $dbbackupHandler )
            {
                // Do backup
                $dbbackupHandler->handle();

            }

        }
        catch ( Exception $e )
        {
            //                 ErrorHandler::doError($e);
            //                 $this->error_handler->handle( $e );
            $this->doErrorLog( $e );
        }
    }

    // /DECONSTRUCTOR


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
     * @return KillHandler
     */
    public function getKillHandler()
    {
        return $this->kill_handler;
    }

    /**
     * @param KillHandler $kill
     */
    public function setKillHandler( KillHandler $kill )
    {
        $this->kill_handler = $kill;
    }

    /**
     * @return ErrorHandler
     */
    public function getErrorHandler()
    {
        return $this->error_handler;
    }

    /**
     * @param ErrorHandler $error_handler
     */
    public function setErrorHandler( ErrorHandler $error_handler )
    {
        $this->error_handler = $error_handler;
    }

    /**
     * @return OutputHandler
     */
    public function getOutputHandler()
    {
        return $this->output_handler;
    }

    /**
     * @param OutputHandler $output_handler
     */
    public function setOutputHandler( OutputHandler $output_handler )
    {
        $this->output_handler = $output_handler;
    }

    /**
     * @return AbstractDefaultLocale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param Locale $locale
     */
    public function setLocale( Locale $locale )
    {
        $this->locale = $locale;
    }

    /**
     * @return DebugHandler
     */
    public function getDebugHandler()
    {
        return $this->debug_handler;
    }

    /**
     * @param DebugHandler $debug_handler
     */
    public function setDebugHandler( DebugHandler $debug_handler )
    {
        $this->debug_handler = $debug_handler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return array Array( mode = Array( host, database, user, password ) )
     */
    protected abstract function getDatabaseLocalConfig();

    /**
     * @return array Array( mode = Array( host, database, user, password ) )
     */
    protected abstract function getDatabasePublicConfig();

    /**
     * @return array Array( mode = Array( host, database, user, password ) )
     */
    protected function getDatabaseConfig()
    {
        return $_SERVER[ "SERVER_PORT" ] == self::LOCALHOST_PORT ? $this->getDatabaseLocalConfig() : $this->getDatabasePublicConfig();
    }

    /**
     * @return DbApi Production database, default is production
     */
    private function getDbInstance()
    {

        // Get database config
        list ( $db_host, $db_database, $db_user, $db_password ) = Core::empty_(
                Core::arrayAt( $this->getDatabaseConfig(), $this->getMode() ), array ( null, null, null, null ) );

        // Return Database API
        return new PdoDbApi( $db_host, $db_database, $db_user, $db_password );

    }

    /**
     * @return integer
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return integer
     */
    public function getModeDefault()
    {
        return $this->modeDefault;
    }

    /**
     * @return DbbackupHandler
     */
    protected abstract function getDbbackupHandler();

    // ... /GET


    // ... SET


    /**
     * @param array $debug_config Array( $mode => $level [, ... ] )
     */
    public function setDebug( array $debug_config )
    {
        if ( isset( $debug_config[ $this->getMode() ] ) )
        {
            $this->setDebugHandler(
                    new DebugHandler( new DebugDbDao( $this->getDbApi() ), $debug_config[ $this->getMode() ] ) );
        }
    }

    // ... /SET


    // ... DO


    // ... ... SETUP


    /**
     * Sets Europe/Oslo as timezone
     */
    private function doTimeSetup()
    {
        //@date_default_timezone_set("Europe/Oslo");
    }

    /**
     * Set up the error/exception handlers
     */
    private function doErrorhandlingSetup()
    {
        // Error/exception handlers
        set_error_handler( array ( $this, "doErrorHandling" ), E_ALL | E_STRICT );
        set_exception_handler( array ( $this, "doExceptionHandling" ) );
    }

    /**
     * @param integer $mode Execution mode
     * @throws Exception
     */
    private function doDatabaseAndLocaleSetup( $mode )
    {
        try
        {

            // Set database
            $this->setDbApi( $this->getDbInstance() );

            // Connect database
            $this->getDbApi()->connect();

            // Set locale
            $this->setLocale( Locale::instance() );

            if ( class_exists( "ErrorDbDao" ) && class_exists( "ErrorHandler" ) )
            {
                $error_dao = new ErrorDbDao( $this->getDbApi() );
                $this->setErrorHandler( new ErrorHandler( $error_dao ) );
            }

        }
        catch ( Exception $e )
        {
            throw $e;
        }
    }

    // ... ... /SETUP


    // ... ... HANDLING


    /**
     * Represents the custom error handler
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @throws ErrorException If E_ERROR or E_USER_ERROR is called
     */
    public function doErrorHandling( $errno, $errstr, $errfile, $errline )
    {

        // Initiate Error Exception
        $error_exception = new ErrorException( $errstr, 0, $errno, $errfile, $errline );

        // Switch severity
        switch ( $error_exception->getSeverity() )
        {
            case E_ERROR :
            case E_USER_ERROR :
                throw $error_exception;
                break;

            case E_WARNING :
            case E_USER_WARNING :
                if ( $this->getErrorHandler() )
                {
                    $this->getErrorHandler()->handle( $error_exception );
                }
                else
                {
                    $this->doErrorLog( $error_exception );
                }
                break;

            default :
                break;
        }

        // Don't execute PHP internal error handler
        return true;

    }

    /**
     * Represents the custom exception handler
     *
     * @param Exception $exception
     */
    public function doExceptionHandling( Exception $exception )
    {

        // Do error
        if ( $this->getKillHandler() && $this->getKillHandler()->isAutoErrorLog( $exception ) )
        {
            try
            {
                if ( $this->getErrorHandler() )
                {
                    $this->getErrorHandler()->handle( $exception );
                }
                else
                {
                    $this->doErrorLog( $exception );
                }
            }
            catch ( DbException $exception )
            {
                $this->doErrorLog( $exception );
            }
        }

        // Call Kill handler
        if ( $this->getKillHandler() )
        {
            $this->getKillHandler()->handle( $exception );
        }

        // Log exception
        $this->doErrorLog( $exception );

        // If this is reached kill function does not kill
        die( $exception->getMessage() );

    }

    // ... ... /HANDLING


    /**
     * Logs exception to log file
     *
     * @param Exception $exception
     */
    private function doErrorLog( Exception $exception )
    {

        // Create error string
        $errorstr = "";
        $errorstr .= date( "d-m-Y H:i", time() ) . "\n";
        $errorstr .= $exception->getMessage() . " " . $exception->getFile() . ":" . $exception->getLine() . "\n";
        $errorstr .= $exception->getTraceAsString() . "\n";

        // Db exception
        if ( is_a( $exception, DbException::class_() ) )
        {
            $query = DbException::get_( $exception )->getQuery();

            if ( $query )
            {
                $errorstr .= Core::cc( "\n", DbException::get_( $exception )->getQuery()->getQuery()->build(),
                        print_r( DbException::get_( $exception )->getQuery()->getBinds(), true ) );
            }
        }

        $errorstr .= "\n";

        // Do log error
        @error_log( $errorstr, 3, self::$LOG_FILE );

    }

    /**
     * Main execution
     *
     * @param array $mapping URI mapping
     * @param KillHandler $kill Kill handler
     * @param integer $mode Execution mode
     * @throws Exception
     */
    public function doRequest( array $mapping )
    {

        // Initiate Error handler
        //         $error_dao = new ErrorDbDao( $this->getDbApi() );
        //         $this->setErrorHandler( new ErrorHandler( $error_dao ) );


        // Initiate Controller and View
        $controller = null;
        $view = null;
        try
        {

            // Get Controller name
            $controller_name = AbstractController::getController();

            // Controller exists in mapping
            if ( !Core::arrayAt( $mapping, $controller_name ) )
            {
                throw new Exception( "Controller mapping \"{$controller_name}\" does not exist" );
            }

            // Controller exists
            $controller_class = Core::arrayAt( Core::arrayAt( $mapping, $controller_name ),
                    self::MAP_CONTROLLER );

            if ( !class_exists( $controller_class, true ) )
            {
                throw new Exception( sprintf( "Controller \"%s\" does not exist", $controller_class ) );
            }

            // View exists
            $view_class = Core::arrayAt( Core::arrayAt( $mapping, $controller_name ), self::MAP_VIEW );

            if ( !class_exists( $view_class, true ) )
            {
                throw new Exception( sprintf( "View \"%s\" does not exist", $view_class ) );
            }

            // Initiate View
            $view = AbstractView::get_( new $view_class() );

            // Initiate Controller
            $controller = AbstractController::get_( new $controller_class( $this, $view ) );

            // Set view controller
            $view->setController( $controller );

        }
        catch ( Exception $e )
        {
            throw $e;
        }

        // Do Controll,er View and Render execution
        $this->doControllerViewRender( $controller );

    }

    public function doErrorExecute( AbstractController $controller )
    {

        try
        {
            // Do Controller, View and Render excecution
            $this->doControllerViewRender( $controller );
        }
        catch ( Exception $exception )
        {
            // Log error
            $this->doErrorLog( $exception );
        }

    }

    private function doControllerViewRender( AbstractController $controller )
    {

        // Do request
        try
        {

            // Before request
            $controller->before();

            // Do request
            $controller->request();

            // After request
            $controller->after();

        }
        catch ( Exception $e )
        {
            throw $e;
        }

        // Do render
        $root = Xhtml::div();
        try
        {
            $controller->render( $root );
        }
        catch ( Exception $e )
        {
            throw $e;
        }

        // Display the output
        if ( $this->getOutputHandler() )
        {
            echo $this->getOutputHandler()->handle( $root );
        }
        else
        {
            echo $root;
        }

        // Do destroy
        try
        {
            // Destroy controller
            $controller->destroy();
        }
        catch ( Exception $e )
        {
            throw $e;
        }

    }

    // ... /DO


    // /FUNCTIONS


}

?>