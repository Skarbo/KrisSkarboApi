<?php

class UnsupportedException extends AbstractException {

    public function __construct( $message = NULL, $custom_code = 0, Exception $previous = NULL ) {
        parent::__construct( $message, $custom_code, $previous );
    }

    /**
     * @param UnsupportedException $get
     * @return UnsupportedException
     */
    public static function get_( $get ) {
        return parent::get_( $get );
    }

}

?>