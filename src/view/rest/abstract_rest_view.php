<?php

abstract class AbstractRestView extends AbstractView {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GET
    

    /**
     * @see AbstractView::getLastModified()
     */
    protected function getLastModified() {
        return max( array ( parent::getLastModified(), filemtime( __FILE__ ) ) );
    }

    /**
     * @param array $array
     * @return String JSON data
     */
    public static function getJSON( array $array ) {
        return json_encode( $array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP );
    }

    /**
     * @param RestView $get
     * @return RestView
     * @see ClassCore::get_()
     */
    public static function get_( $get ) {
        return parent::get_( $get );
    }
    
    // ... /GET
    

    /**
     * @return array
     */
    public abstract function getData();

    /**
     * @see AbstractView::draw()
     */
    public function draw( AbstractXhtml $root ) {
        parent::draw( $root );
        
        // Set Javascript as Content type
        @header( sprintf( "Content-type: %s;charset=%s", "application/json", "utf-8" ) );
        
        // Get data
        $data = $this->getData();
        
        // Get JSON from data
        $json = self::getJSON( $data );
        
        // Add JSON to root
        $root->content( $json );
    
    }
    
    // /FUNCTIONS


}

?>