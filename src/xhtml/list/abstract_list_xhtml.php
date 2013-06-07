<?php

abstract class AbstractListXhtml extends AbstractContentXhtml
{

    // VARIABLES


    protected $items;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param array $items
     * @return AbstractListXhtml
     */
    public function items( array $items )
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return AbstractListXhtml
     */
    public function addItems( array $items )
    {
        $this->items = array_merge( $this->items, $items );
        return $this;
    }

    // ... STRING


    public function __toString()
    {

        // Dont use custom string if items are given
        if ( is_null( $this->items ) )
        {
            return "" . parent::__toString();
        }

        // Add items as content
        $this->addContent( implode( $this->getItems() ) );

        // Return parent toString
        return "" . parent::__toString();

    }

    // ... /STRING


// /FUNCTIONS


}

?>