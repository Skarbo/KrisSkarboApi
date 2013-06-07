<?php

class ActionbarPresenterView extends AbstractPresenterView
{

    // VARIABLES


    /**
     * @var string
     */
    private $referral;
    /**
     * @var AbstractXhtml
     */
    private $icon;
    /**
     * @var AbstractXhtml
     */
    private $viewControl;
    /**
     * @var AbstractXhtml
     */
    private $viewControlDouble;
    /**
     * @var array
     */
    private $viewControlMenu = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return the $referral
     */
    public function getReferral()
    {
        return $this->referral;
    }

    /**
     * @return the $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return AbstractXhtml
     */
    public function getViewControl()
    {
        return $this->viewControl;
    }

    /**
     * @param string $referral
     */
    public function setReferral( $referral )
    {
        $this->referral = $referral;
    }

    /**
     * @param AbstractXhtml $icon
     */
    public function setIcon( $icon )
    {
        $this->icon = $icon;
    }

    /**
     * @param AbstractXhtml $viewControl
     */
    public function setViewControl( AbstractXhtml $viewControl, AbstractXhtml $double = null )
    {
        $this->viewControl = $viewControl;
        $this->viewControlDouble = $double;
    }

    /**
     * @param array $menu Array( AbstractXhtml, ... )
     */
    public function setViewControlMenu( array $menu )
    {
        $this->viewControlMenu = $menu;
    }

    // ... /GETTERS/SETTERS


    public function addViewControlMenu( $menu )
    {
        $this->viewControlMenu[] = $menu;
    }

    public function draw( AbstractXhtml $root )
    {

        $actionbar_wrapper = Xhtml::div()->class_( "actionbar_wrapper" );

        $actionbar = Xhtml::div()->class_( "actionbar" );

        $actionbar_icon = Xhtml::div()->class_( "actionbar_icon" );
        $actionbar_icon_referral = Xhtml::div( Xhtml::div()->attr( "data-icon", "left" ) )->class_(
                "actionbar_icon_referral", "invisible" );
        $actionbar_icon_icon = Xhtml::div()->class_( "actionbar_icon_icon" );

        if ( $this->getReferral() )
            $actionbar_icon_referral->attr( "data-referral", $this->getReferral() );
        if ( $this->getIcon() )
            $actionbar_icon_icon->addContent( $this->getIcon() );

        $actionbar_icon->addContent( $actionbar_icon_referral );
        $actionbar_icon->addContent( $actionbar_icon_icon );

        $actionbar_viewcontrol = Xhtml::div()->class_( "actionbar_viewcontrol" );
        $actionbar_viewcontrol_menu = Xhtml::div()->addContent(Xhtml::div("Menu 2"))->class_( "actionbar_viewcontrol_menu" );
        $actionbar_buttons = Xhtml::div()->class_( "actionbar_buttons" );
        $actionbar_buttons_container = Xhtml::div()->class_( "actionbar_buttons_container" );
        $actionbar_buttons->addContent( $actionbar_buttons_container );

        if ( $this->getViewControl() && $this->viewControlDouble )
        {
            $actionbar_viewcontrol->addContent(
                    Xhtml::div( $this->getViewControl() )->addContent( $this->viewControlDouble )->class_( "double" ) );
        }
        else if ( $this->getViewControl() && !$this->viewControlDouble )
        {
            $actionbar_viewcontrol->addContent( Xhtml::div( $this->getViewControl() )->class_( "single" ) );
        }

        $actionbar->addContent( $actionbar_icon );
        $actionbar->addContent( $actionbar_viewcontrol );
        $actionbar->addContent( $actionbar_buttons );

        $actionbar_wrapper->addContent( $actionbar );
        $actionbar_wrapper->addContent( $actionbar_viewcontrol_menu );
        $root->addContent( $actionbar_wrapper );

    }

    // /FUNCTIONS


}

?>