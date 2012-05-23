<?php

class ErrorModel extends Model
{

    // VARIABLES


    private $id;
    private $kill;
    private $code;
    private $message;
    private $file;
    private $line;
    private $occured;
    private $url;
    private $backtrack;
    private $trace;
    private $query;
    private $exception;
    private $updated;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getKill()
    {
        return $this->kill;
    }

    public function setKill( $kill )
    {
        $this->kill = $kill;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage( $message )
    {
        $this->message = $message;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile( $file )
    {
        $this->file = $file;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setLine( $line )
    {
        $this->line = $line;
    }

    public function getOccured()
    {
        return $this->occured;
    }

    public function setOccured( $occured )
    {
        $this->occured = $occured;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl( $url )
    {
        $this->url = $url;
    }

    public function getBacktrack()
    {
        return $this->backtrack;
    }

    public function setBacktrack( $backtrack )
    {
        $this->backtrack = $backtrack;
    }

    public function getTrace()
    {
        return $this->trace;
    }

    public function setTrace( $trace )
    {
        $this->trace = $trace;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery( $query )
    {
        $this->query = $query;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException( $exception )
    {
        $this->exception = $exception;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function setRegistered( $registered )
    {
        $this->registered = $registered;
    }

    // ... /GETTERS/SETTERS


// /FUNCTIONS

	public function getUpdated()
    {
        return $this->updated;
    }

	public function setUpdated( $updated )
    {
        $this->updated = $updated;
    }


}

?>