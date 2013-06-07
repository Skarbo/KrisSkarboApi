<?php

class DoublearrayCore extends IteratorCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @throws Exception If not a double array
     */
    public function __construct( array $array = array() )
    {
        parent::__construct( $array );

        // Must be a double array
        if ( !Core::isDoubleArray( $array ) )
        {
            throw new Exception( "Array is not a double array" );
        }

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return array
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @param array $add
     * @see IteratorCore::add()
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    // ... ITERATOR


    /**
     * @see IteratorCore::current()
     * @return array
     */
    public function current()
    {
        return parent::current();
    }

    // ... /ITERATOR


// /FUNCTIONS


}

?>