<?php

/**
 * Represents an abstract Iterator
 *
 * @author Kris Skarbo
 *
 */
class IteratorCore extends ClassCore implements Iterator
{

    // VARIABLES


    private $position = 0;
    public $array = array ();

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( array $array = array() )
    {
        $this->array = $array;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @param array $array
     */
    public function setArray( array $array = array() )
    {
        $this->array = $array;
    }

    /**
     * @return integer
     */
    public function size()
    {
        return count( $this->array );
    }

    /**
     * @param integer $i
     */
    public function get( $i )
    {
        return Core::arrayAt( $this->array, $i );
    }

    public function add( $add )
    {
        $this->array[] = $add;
    }

    /**
     * @param mixed $i Index
     * @return mixed The removed object
     */
    public function remove( $i )
    {
        $element = $this->get( $i );
        unset( $this->array[ $i ] );
        $this->array = array_merge($this->array);
        return $element;
    }

    public function removeAll()
    {
        $this->array = array ();
        $this->position = 0;
    }

    /**
     * @param integer $offset
     * @return IteratorCore
     */
    public function slice( $offset )
    {
        $iterator = clone $this;
        $iterator->array = array_merge( array (), array_slice( $this->array, $offset ) );
        return $iterator;
    }

    /**
     * @param IteratorCore $iterator
     */
    public function addAll( IteratorCore $iterator )
    {
        $this->array = array_merge( $this->getArray(), $iterator->getArray() );
    }

    /**
     * @param mixed $i Index
     * @param mixed $set Set object
     */
    public function set( $i, $set )
    {
        $this->array[ $i ] = $set;
    }

    /**
     * @return boolean True if empty
     */
    public function isEmpty()
    {
        return $this->size() == 0;
    }

    /**
     * @param Closure $func
     * @return IteratorCore
     */
    public function filter( $func )
    {
        // Clone this iterator
        $iterator = clone $this;

        // Remove all from clone
        $iterator->array = array ();

        // Foreach objects
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $object = $this->current();
            if ( $func( $object ) )
            {
                $iterator->add( $object );
            }
        }

        // Return cloned iterator
        return $iterator;
    }

    /**
     * @param integer $limit
     * @return IteratorCore
     */
    public function limit( $limit )
    {
        $iterator = clone $this;
        for ( $this->rewind(), $i = 0; $this->valid() && $i < $limit; $this->next(), $i++ )
        {
            $iterator->add( $this->current() );
        }
        return $iterator;
    }

    /**
     * @return StandardModel
     */
    public function getId( $id )
    {
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $object = $this->current();

            if ( method_exists( $object, 'getId' ) && $object->getId() == $id )
            {
                return $object;
            }
        }

        return null;
    }

    /**
     * @return array Id's
     */
    public function getIds()
    {
        $ids = array ();

        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $object = $this->current();

            if ( method_exists( $object, 'getId' ) )
            {
                $ids[] = $object->getId();
            }
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function getJson()
    {
        $array = array ();

        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $object = $this->current();

            if ( method_exists( $object, 'getId' ) )
            {
                $array[ $object->getId() ] = $object;
            }
        }

        return $array;
    }

    /**
     * Shufles the array
     *
     * @return void
     */
    public function shuffle()
    {
        shuffle( $this->array );
    }

    // ... ITERATOR


    /**
     * @see Iterator::current()
     * @return mixed
     */
    public function current()
    {
        return Core::arrayAt( $this->array, $this->position );
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see Iterator::key()
     * @return mixed
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @see Iterator::valid()
     * @return boolean
     */
    public function valid()
    {
        return isset( $this->array[ $this->position ] );
    }

    /**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }

    // ... /ITERATOR


    // /FUNCTIONS


}

?>