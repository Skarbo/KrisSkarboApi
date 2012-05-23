<?php

abstract class PageMainView extends ClassCore
{

    // VARIABLES

    public static $ID_PAGE_WRAPPER = "page_wrapper";

    /**
     * @var MainView
     */
    private $view;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
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
    public function setView( MainView $view )
    {
        $this->view = $view;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param AbstractXhtml $root
     */
    public abstract function draw( AbstractXhtml $root );

    // /FUNCTIONS


}

?>