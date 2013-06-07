<?php

interface StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param mixed $id
     * @return StandardModel
     */
    public function get( $id );

    /**
     * @param array fields@return StandardListModel
     */
    public function getList( array $ids );

    /**
     * @return StandardListModel
     */
    public function getAll();

    /**
     * @param array $foreignIds
     * @return StandardListModel
     */
    public function getForeign( array $foreignIds );

    /**
     * @param StandardModel $model
     * @param int $foreignId [null]
     * @return int Generated id
     */
    public function add( StandardModel $model, $foreignId );

    /**
     * @param int $id
     * @param StandardModel $model
     * @param int $foreignId [null]
     */
    public function edit( $id, StandardModel $model, $foreignId );

    /**
     * @param $id
     * @return boolean True if removed
     */
    public function remove( $id );

    /**
     * @return int Number removed
     */
    public function removeAll();

    /**
     * @param string $search
     * @param int Foreign id
     * @return StandardListModel
     */
    public function search( $search, $foreignId = null );

    /**
     * @param int $id
     * @return boolean True if touched, null if touch field is not set
     */
    public function touch( $id );

    // /FUNCTIONS


}

?>