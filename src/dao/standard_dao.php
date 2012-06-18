<?php

interface StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $id
     * @return StandardModel
     * @throws DbException
     */
    public function get( $id );

    /**
     * @param array fields@return StandardListModel
     * @throws DbException
     */
    public function getList( array $ids );

    /**
     * @return StandardListModel
     * @throws DbException
     */
    public function getAll();

    /**
     * @param array $foreignIds
     * @return StandardListModel
     * @throws DbException
     */
    public function getForeign( array $foreignIds );

    /**
     * @param StandardModel $model
     * @param int $foreignId [null]
     * @return int Generated id
     * @throws DbException
     */
    public function add( StandardModel $model, $foreignId );

    /**
     * @param int $id
     * @param StandardModel $model
     * @param int $foreignId [null]
     * @throws DbException
     */
    public function edit( $id, StandardModel $model, $foreignId );

    /**
     * @param $id
     * @return boolean True if removed
     * @throws DbException
     */
    public function remove( $id );

    /**
     * @return int Number removed
     * @throws DbException
     */
    public function removeAll();

    /**
     * @param string $search
     * @return StandardListModel
     * @throws DbException
     */
    public function search( $search );

    // /FUNCTIONS


}

?>