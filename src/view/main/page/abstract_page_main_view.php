<?php

abstract class AbstractPageMainView extends ClassCore implements InterfaceView {
    
    // VARIABLES
    

    public static $ID_PAGE_WRAPPER = "page_wrapper";
    
    /**
     * @var MainView
     */
    private $view;
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    public function __construct( AbstractMainView $view ) {
        $this->view = $view;
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GETTERS/SETTERS
    

    /**
     * @return AbstractMainView
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param AbstractMainView $view
     */
    public function setView( AbstractMainView $view ) {
        $this->view = $view;
    }
    
    // ... /GETTERS/SETTERS
    

    // ... GET
    

    /**
     * @return AbstractMainController
     */
    public function getController() {
        return $this->getView()->getController();
    }

    /**
     * @see InterfaceView::getMode()
     */
    public function getMode( $force = false ) {
        return $this->getView()->getMode( $force );
    }

    /**
     * @see InterfaceView::getLocale()
     */
    public function getLocale() {
        return $this->getView()->getLocale();
    }

    public function getLastModified() {
        return filemtime( __FILE__ );
    }
    
    // ... /GET
    

    /**
     * @param AbstractXhtml $root
     */
    public abstract function draw( AbstractXhtml $root );
    
    // /FUNCTIONS


}

?>