<?php

class ResultDbCore extends ClassCore
{

    // VARIABLES


    /**
     * @var QueryDbCore
     */
    private $query = null;
    /**
     * @var array
     */
    private $rows = array ();
    /**
     * @var integer
     */
    private $affected_rows;
    /**
     * @var integer
     */
    private $insert_id;
    /**
     * Execute result
     *
     * @var boolean
     */
    private $execute;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return QueryDbCore
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param QueryDbCore $query
     */
    public function setQuery( QueryDbCore $query )
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param array $rows
     */
    public function setRows( array $rows )
    {
        $this->rows = $rows;
    }

    /**
     * @return integer
     */
    public function getAffectedRows()
    {
        return $this->affected_rows;
    }

    /**
     * @param integer $affected_rows
     */
    public function setAffectedRows( $affected_rows )
    {
        $this->affected_rows = $affected_rows;
    }

    /**
     * @return integer
     */
    public function getInsertId()
    {
        return $this->insert_id;
    }

    /**
     * @param integer $insert_id
     */
    public function setInsertId( $insert_id )
    {
        $this->insert_id = $insert_id;
    }

    /**
     * @return boolean
     */
    public function isExecute()
    {
        return $this->execute;
    }

    /**
     * @param boolean $execute
     */
    public function setExecute( $execute )
    {
        $this->execute = $execute;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @param mixed $row
     * @return array Row array or empty array if not exists
     */
    public function getRow( $row )
    {
        $value = Core::arrayAt( $this->rows, $row );
        return $value == null ? array () : $value;
    }

    /**
     * @return number
     */
    public function getSizeRows()
    {
        return count( $this->getRows() );
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean
     */
    public function isEmptyRows()
    {
        return count( $this->getRows() ) == 0;
    }

    // ... /IS


    // /FUNCTIONS


}

?>