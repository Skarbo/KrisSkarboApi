<?php

class DebugModel extends Model {
    
    // VARIABLES
    

    private $id;
    private $session;
    private $level;
    private $data;
    private $file;
    private $line;
    private $backtrack;
    private $trace;
    private $type;
    private $registered;
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // /FUNCTIONS
    

    public function getId() {
        return $this->id;
    }

    public function setId( $id ) {
        $this->id = $id;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel( $level ) {
        $this->level = $level;
    }

    public function getData() {
        return $this->data;
    }

    public function setData( $data ) {
        $this->data = $data;
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile( $file ) {
        $this->file = $file;
    }

    public function getLine() {
        return $this->line;
    }

    public function setLine( $line ) {
        $this->line = $line;
    }

    public function getBacktrack() {
        return $this->backtrack;
    }

    public function setBacktrack( $backtrack ) {
        $this->backtrack = $backtrack;
    }

    public function getTrace() {
        return $this->trace;
    }

    public function setTrace( $trace ) {
        $this->trace = $trace;
    }

    public function getType() {
        return $this->type;
    }

    public function setType( $type ) {
        $this->type = $type;
    }

    public function getRegistered() {
        return $this->registered;
    }

    public function setRegistered( $registered ) {
        $this->registered = $registered;
    }

    public function getSession() {
        return $this->session;
    }

    public function setSession( $session ) {
        $this->session = $session;
    }

}

?>