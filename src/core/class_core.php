<?php

/**
 * Represents a class object, with extra help methods
 *
 * @author Kris Skarbø
 *
 */
abstract class ClassCore
{

    /**
     * Returns class name
     *
     * @return string
     */
    public final static function class_()
    {
        return get_called_class();
    }

    /**
     * Returns back parameter, but with javadoc return statement
     *
     * @return ClassCore
     */
    public static function get_( $get )
    {
        return $get;
    }

    /**
     * @param mixed $object
     * @return boolean True if the object is of this class or has this class as one of its parents
     * @see http://php.net/manual/en/function.is-a.php
     */
    public static function is_( $object )
    {
        return is_object( $object ) && is_a($object, self::class_() );
    }

}

?>