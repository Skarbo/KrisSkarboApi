<?php

class StandardListModel extends IteratorCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return StandardModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    public function getIndex( $modelId )
    {
        for ( $i = 0; $i < count( $this->array ); $i++ )
        {
            if ( $this->get( $i )->getId() == $modelId )
                return $i;
        }
        return -1;
    }

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
     * @return array Foreign ids in list
     */
    public function getForeignIds()
    {
        $foreignIds = array ();

        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $model = $this->current();
            $foreignIds[] = $model->getForeignId();
        }

        return array_values( array_unique( $foreignIds ) );

    }

    /**
     * @return StandardListModel
     */
    public function getForeignList( $foreignId )
    {
        return $this->filter(
                function ( StandardModel $model ) use($foreignId )
                {
                    return $model->getForeignId() == $foreignId;
                } );
    }

    /**
     * @param mixed $id Standard model id
     * @return StandardModel Removed model, null if not found
     */
    public function removeId( $id )
    {
        for ( $this->rewind(), $i = 0; $this->valid(); $this->next(), $i++ )
        {
            $model = $this->current();

            if ( $model->getId() == $id )
            {
                $this->remove( $i );
                return $model;
            }
        }

        return null;
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