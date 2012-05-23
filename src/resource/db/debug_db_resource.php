<?php

class DebugDbResource
{

    private $table = "debug";

    private $fieldId = "debug_id";
    private $fieldLevel = "debug_level";
    private $fieldData = "debug_data";
    private $fieldFile = "debug_file";
    private $fieldLine = "debug_line";
    private $fieldBacktrack = "debug_backtrack";
    private $fieldTrace = "debug_trace";
    private $fieldType = "debug_type";
    private $fieldRegistered = "debug_registered";

    public function getTable()
    {
        return $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldLevel()
    {
        return $this->fieldLevel;
    }

    public function getFieldData()
    {
        return $this->fieldData;
    }

    public function getFieldFile()
    {
        return $this->fieldFile;
    }

    public function getFieldLine()
    {
        return $this->fieldLine;
    }

    public function getFieldBacktrack()
    {
        return $this->fieldBacktrack;
    }

    public function getFieldTrace()
    {
        return $this->fieldTrace;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

}

?>