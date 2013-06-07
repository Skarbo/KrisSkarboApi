<?php

abstract class AbstractWidgetView extends ClassCore
{

    // VARIABLES


    /**
     * @var InterfaceView
     */
    private $view;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( InterfaceView $view )
    {
        $this->view = $view;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return InterfaceView
     */
    protected function getView()
    {
        return $this->view;
    }

    /**
     * @param AbstractXhtml $root
     */
    public abstract function draw( AbstractXhtml $root );

    /**
     * @param InterfaceView $view
     * @return AbstractWidgetView
     */
    public static function init( InterfaceView $view )
    {
        $class = get_called_class();
        return new $class( $view );
    }

    // /FUNCTIONS


}

?>