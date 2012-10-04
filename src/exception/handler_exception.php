<?php

class HandlerException extends AbstractException
{

    const ALGORITHM_NOT_GIVEN = "handler_algorithm_not_given";
    const WEBSITE_NOT_GIVEN = "handler_website_not_given";

    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL )
    {
        parent::__construct( $message, $custom_code, $previous );
    }

}

?>