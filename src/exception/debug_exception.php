<?php

/**
 * Debug Exception is used with debugging
 *
 * @author Kris
 */
class DebugException extends AbstractException
{

    private $data;

    /**
     * @param mixed $debug_data $debug_data [, $debug_data]
     */
    public function __construct( $debug_data )
    {
        parent::__construct();
        $this->data = func_get_args();
    }

    public function getData()
    {
        return $this->data;
    }

}

?>