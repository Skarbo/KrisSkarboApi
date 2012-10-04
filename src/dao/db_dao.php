<?php

abstract class DbDao extends ClassCore
{

    // VARIABLES


    protected static $SQL_DATE_FORMAT_YmdHis = "Y-m-d H:i:s";
    protected static $SQL_DATE_FORMAT_Ymd = "Y-m-d";
    protected static $SQL_DATE_FORMAT_His = "H:i:s";
    protected static $REGEX_WILDCARD = '/[^\p{L}\d]/s';

    /**
     * @var DbApi
     */
    private $db_api;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $db_api )
    {
        $this->db_api = $db_api;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return DbApi
     */
    public function getDbApi()
    {
        return $this->db_api;
    }

    // ... /GET


// /FUNCTIONS


}

?>