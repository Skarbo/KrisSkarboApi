<?php

abstract class AbstractException extends Exception
{

    public static $CODE_GENERAL = 0;

    private $custom_code = 0;
    private $backtrack;

    /**
     * @param string $message
     * @param int $custom_code
     * @param Exception $previous
     */
    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL )
    {
        parent::__construct( $message, $previous && is_int($previous->getCode()) ? $previous->getCode() : 0, $previous );
        $this->custom_code = $custom_code;
        $this->initBacktrack( debug_backtrace() );
    }

    private function initBacktrack( array $backtracks )
    {
        $returns = array ();

        for ( $i = 1; $i < count( $backtracks ); $i++ )
        {
            $backtrack = $backtracks[ $i ];
            $backtrack_last = $backtracks[ $i - 1 ];
            $return = array ();

            // Number
            $return[] = "#{$i}";

            // Class, type, function
            $return[] = Core::cc( "",
                    Core::arrayAt( $backtrack, "class" ),
                    Core::arrayAt( $backtrack, "type" ),
                    Core::arrayAt( $backtrack, "function" ) );

            // File:line
            if ( Core::arrayAt( $backtrack_last, "file" ) && Core::arrayAt(
                    $backtrack_last, "line" ) )
            {
                $return[] = Core::cc( ":",
                        Core::arrayAt( $backtrack_last, "file" ),
                        Core::arrayAt( $backtrack_last, "line" ) );
            }

            $returns[] = implode( " ", $return );

        }

        $this->backtrack = implode( "\n", $returns );

    }

    /**
     * @return integer
     */
    public function getCustomCode()
    {
        return $this->custom_code;
    }

    /**
     * @return string Backtrack as string
     */
    public function getBacktrack()
    {
        return $this->backtrack;
    }

    public static function class_()
    {
        return get_called_class();
    }

    /**
     * @param AbstractException $get
     * @return AbstractException
     */
    public static function get_( $get )
    {
        return $get;
    }

}

?>