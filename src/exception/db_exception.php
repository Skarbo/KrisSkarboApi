<?php

class DbException extends AbstractException
{

    /**
     * @var QueryDbCore
     */
    private $query = null;

    public function __construct( $message = NULL, Exception $previous = NULL, QueryDbCore $query = NULL )
    {
        parent::__construct( $message, $previous ? $previous->getCode() : 0, $previous );
        $this->query = $query;
    }

    /**
     * @return QueryDbCore
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param DbException $get
     * @return DbException
     */
    public static function get_( $get )
    {
        return $get;
    }

}

?>