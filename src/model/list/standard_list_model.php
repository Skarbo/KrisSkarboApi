<?php

abstract class StandardListModel extends IteratorCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return integer Last modified, null if not exist
     */
    public function getLastModified()
    {
        // Initiate last modified
        $last_modified = null;

        // Foreach Facilities
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $model = $this->current();

            $last_modified = max( $last_modified, $model->getLastModified() );
        }

        // Return last modified
        return $last_modified;
    }

    /**
     * @return StandardModel
     * @see IteratorCore::current()
     */
    public function current()
    {
        return parent::current();
    }

    // /FUNCTIONS


}

?>