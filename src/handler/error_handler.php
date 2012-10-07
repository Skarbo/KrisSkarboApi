<?php

class ErrorHandler extends Handler
{

    // VARIABLES


    /**
     * @var ErrorHandler
     */
    private static $INSTANCE;

    /**
     * @var ErrorDao
     */
    private $error_dao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( ErrorDbDao $error_dao )
    {
        $this->error_dao = $error_dao;

        // Set this instance as instance
        self::$INSTANCE = $this;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return ErrorDao
     */
    public function getErrorDao()
    {
        return $this->error_dao;
    }

    /**
     * @param ErrorDao $error_dao
     */
    public function setErrorDao( ErrorDao $error_dao )
    {
        $this->error_dao = $error_dao;
    }

    // ... /GETTERS/SETTERS


    public function handle( Exception $exception )
    {
        $documentRoot = str_replace( "/", "\\", dirname( $_SERVER[ "DOCUMENT_ROOT" ] ) );

        // Initiate Error Model
        $error_model = new ErrorModel();

        // Set code
        $error_model->setCode( $exception->getCode() );

        // Set message
        $error_model->setMessage( $exception->getMessage() );

        // Set file (remove path)
        $error_model->setFile(
                str_replace( $documentRoot, "", $exception->getFile() ) );

        // Set line
        $error_model->setLine( $exception->getLine() );

        // Set trace
        $error_model->setTrace( str_replace( $documentRoot, "", print_r( $exception->getTraceAsString(), true ) ) );

        // Set URL
        $error_model->setUrl( basename( $_SERVER[ "PHP_SELF" ] ) . "?" . $_SERVER[ "QUERY_STRING" ] );

        // Set exception type
        $error_model->setException( get_class( $exception ) );

        // Set backtrack
        if ( is_a( $exception, AbstractException::class_() ) )
        {
            $error_model->setBacktrack( str_replace( $documentRoot, "", AbstractException::get_( $exception )->getBacktrack() ) );
        }

        // Switch exception type
        switch ( get_class( $exception ) )
        {

            // DB Exception
            case DbException::class_() :
                // Set SQL query
                $query = Core::cc( "\n",
                        DbException::get_( $exception )->getQuery()->getQuery()->build(),
                        print_r( DbException::get_( $exception )->getQuery()->getBinds(), true ) );
                $error_model->setQuery( $query );
                break;

        }

        // Add Error
        $this->getErrorDao()->addError( $error_model );

    }

    // ... DO


    /**
     * @param Exception $errorException
     */
    public static function doError( Exception $errorException )
    {
        if ( self::$INSTANCE )
        {
            $instance = self::$INSTANCE;
            $instance->handle( $errorException );
        }
    }

    // ... /DO


    // /FUNCTIONS


}

?>