<?php

class DebugHandler extends Handler
{

    // VARIABLES


    /**
     * @var DebugHandler
     */
    private static $INSTANCE;

    const LEVEL_LOW = 1;
    const LEVEL_MEDIUM = 2;
    const LEVEL_HIGH = 3;

    /**
     * @var DebugDao
     */
    private $debug_dao;
    private $level;
    private $session;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DebugDao $debug_dao, $level )
    {
        // Set DebugDao
        $this->debug_dao = $debug_dao;

        // Set next session
        $this->session = $this->getDebugDao()->getNextSession();

        // Delete all Debug's
        $this->getDebugDao()->removeDebugs();

        // Set level
        $this->level = $level;

        // Set this instance as instance
        self::$INSTANCE = $this;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return DebugDao
     */
    public function getDebugDao()
    {
        return $this->debug_dao;
    }

    /**
     * @param DebugDao $debug_dao
     */
    public function setDebugDao( DebugDao $debug_dao )
    {
        $this->debug_dao = $debug_dao;
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param integer $level
     */
    public function setLevel( $level )
    {
        $this->level = $level;
    }

    /**
     * @return integer
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param integer $session
     */
    public function setSession( $session )
    {
        $this->session = $session;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param integer $level Debug level
     * @param DebugException $debug_exception
     */
    public function handle( $level, DebugException $debug_exception )
    {

        // Level
        if ( $this->getLevel() > $level )
        {
            return;
        }

        // Initiate Debug
        $debug = new DebugModel();

        // Set session
        $debug->setSession( $this->getSession() );

        // Set level
        $debug->setLevel( $level );

        // Set data
        $debug->setData( print_r( $debug_exception->getData(), true ) );

        // Set file (remove path)
        $debug->setFile(
                str_replace(
                        str_replace( "/", "\\", dirname( $_SERVER[ "DOCUMENT_ROOT" ] ) ), "",
                        $debug_exception->getFile() ) );

        // Set line
        $debug->setLine( $debug_exception->getLine() );

        // Set trace
        $debug->setTrace( print_r( $debug_exception->getTraceAsString(), true ) );

        // Set backtrack
        $debug->setBacktrack( $debug_exception->getBacktrack() );

        // Set type
        $debug->setType(
                implode( ", ",
                        array_map(
                                function ( $data )
                                {
                                    return is_object( $data ) ? get_class( $data ) : gettype( $data );
                                }, $debug_exception->getData() ) ) );

        // Add Debug
        $this->getDebugDao()->addDebug( $debug );

    }

    // ... STATIC


    /**
     * @param integer $level Debug level
     * @param DebugException $debug_exception
     */
    public static function doDebug( $level, DebugException $debug_exception )
    {
        if ( self::$INSTANCE )
        {
            $instance = self::$INSTANCE;
            $instance->handle( $level, $debug_exception );
        }
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>