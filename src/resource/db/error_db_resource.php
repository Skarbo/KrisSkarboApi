<?php

class ErrorDbResource
{

    // VARIABLES


    private $table = "error";

    private $fieldId = "error_id";
    private $fieldKill = "error_kill";
    private $fieldCode = "error_code";
    private $fieldMessage = "error_message";
    private $fieldFile = "error_file";
    private $fieldLine = "error_line";
    private $fieldOccured = "error_occured";
    private $fieldUrl = "error_url";
    private $fieldBacktrack = "error_backtrack";
    private $fieldTrace = "error_trace";
    private $fieldQuery = "error_query";
    private $fieldException = "error_exception";
    private $fieldUpdated = "error_updated";
    private $fieldRegistered = "error_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return DB_PREFIX . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldKill()
    {
        return $this->fieldKill;
    }

    public function getFieldCode()
    {
        return $this->fieldCode;
    }

    public function getFieldMessage()
    {
        return $this->fieldMessage;
    }

    public function getFieldFile()
    {
        return $this->fieldFile;
    }

    public function getFieldLine()
    {
        return $this->fieldLine;
    }

    public function getFieldOccured()
    {
        return $this->fieldOccured;
    }

    public function getFieldUrl()
    {
        return $this->fieldUrl;
    }

    public function getFieldBacktrack()
    {
        return $this->fieldBacktrack;
    }

    public function getFieldTrace()
    {
        return $this->fieldTrace;
    }

    public function getFieldQuery()
    {
        return $this->fieldQuery;
    }

    public function getFieldException()
    {
        return $this->fieldException;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

	public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


}

?>