<?php

class ValidatorException extends AbstractException {
    
    private $validations = array ();

    public function __construct( $message = NULL, array $validations = array(), $custom_code = 0, Exception $previous = NULL ) {
        parent::__construct( $message, $custom_code, $previous );
        $this->validations = $validations;
    }

    public function getValidations() {
        return $this->validations;
    }

    /**
     * @param ValidatorException $get
     * @return ValidatorException
     */
    public static function get_( $get ) {
        return parent::get_( $get );
    }

}

?>