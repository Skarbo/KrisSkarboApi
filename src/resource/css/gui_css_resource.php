<?php

class GuiCssResource
{

    // VARIABLES


    private $gui = "gui";
    private $wrapper = "wrapper";
    private $button = "button";
    private $light = "light";
    private $inactive = "inactive";
    private $component = "guiComp";
    private $icon = "icon";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getGui()
    {
        return $this->gui;
    }

    public function getButton()
    {
        return $this->button;
    }

    public function getLight()
    {
        return $this->light;
    }

    public function getWrapper()
    {
        return $this->wrapper;
    }

    public function getInactive()
    {
        return $this->inactive;
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function getIcon()
    {
        return $this->icon;
    }

}

?>