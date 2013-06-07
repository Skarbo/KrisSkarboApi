<?php

class UnauthorizedException extends AbstractException
{

    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL )
    {
        parent::__construct( $message, $custom_code, $previous );
    }

}

?>