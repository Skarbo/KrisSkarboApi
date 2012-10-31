<?php

abstract class AbstractPresenterView extends ClassCore implements InterfaceView
{

    // VARIABLES


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
     * @return AbstractView
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

    /**
     * @see AbstractController
     */
    public function getController()
    {
        return $this->getView()->getController();
    }

    /**
     * @see InterfaceView::getLocale()
     */
    public function getLocale()
    {
        return $this->getView()->getLocale();
    }

    /**
     * @see InterfaceView::getMode()
     */
    public function getMode( $force = false )
    {
        return $this->getView()->getMode( $force );
    }

    // ... /GETTERS/SETTERS


    public abstract function draw( AbstractXhtml $root );

    // /FUNCTIONS


}

?>