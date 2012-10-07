<?php

abstract class ErrorDao extends Dao
{

    /**
     * Add Error
     *
     * @param ErrorModel $error Error to add
     * @return integer Error id
     * @throws DbException
     */
    public abstract function addError( ErrorModel $error );

    /**
     * @return ErrorListModel
     */
    public abstract function getAll();

}

?>