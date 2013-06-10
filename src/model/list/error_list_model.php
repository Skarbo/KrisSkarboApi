<?php

class ErrorListModel extends IteratorCore {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    /**
     * @see IteratorCore::get()
     * @return ErrorModel
     */
    public function get( $i ) {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return ErrorModel
     */
    public function add( $add ) {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return ErrorModel
     */
    public function current() {
        return parent::current();
    }
    
    // ... STATIC
    

    /**
     * @param ErrorListModel $get
     * @return ErrorListModel
     */
    public static function get_( $get ) {
        return $get;
    }
    
    // ... /STATIC
    

    // /FUNCTIONS


}

?>