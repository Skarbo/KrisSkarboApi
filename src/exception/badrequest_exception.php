<?php

class BadrequestException extends AbstractException {
    
    const UNKNOWN_COMMAND = 1;
    const MISSING_POST_DATA = 100;

    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL ) {
        parent::__construct( $message, $custom_code, $previous );
    }

}

?>