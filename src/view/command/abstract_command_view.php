<?php

class AbstractCommandView extends AbstractView {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    protected function isNoCache() {
        return true;
    }

    /**
     * @see AbstractView::draw()
     */
    public function draw( AbstractXhtml $root ) {
    
    }
    
    // /FUNCTIONS


}

?>