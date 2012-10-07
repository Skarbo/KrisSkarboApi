<?php

abstract class AbstractPageMainView extends ClassCore implements InterfaceView
{

    // VARIABLES


    public static $ID_PAGE_WRAPPER = "page_wrapper";

    /**
     * @var MainView
     */
    private $view;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( AbstractMainView $view )
    {
        $this->view = $view;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return MainView
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param MainView $view
     */
    public function setView( AbstractMainView $view )
    {
        $this->view = $view;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see InterfaceView::getMode()
     */
    public function getMode( $force = false )
    {
        return $this->getView()->getMode( $force );
    }

    /**
     * @see InterfaceView::getLocale()
     */
    public function getLocale()
    {
        return $this->getView()->getLocale();
    }

    // ... /GET


    /**
     * @param AbstractXhtml $root
     */
    public abstract function draw( AbstractXhtml $root );

    // /FUNCTIONS


}

?>