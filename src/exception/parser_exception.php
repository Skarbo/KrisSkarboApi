<?php

class ParserException extends AbstractException {
    
    const WEBPAGE_NOT_EXIST_ERROR = 1;
    const DOM_ERROR = 2;
    const HTML_ERROR = 3;

    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL ) {
        parent::__construct( $message, $custom_code, $previous );
    }

}

?>