<?php

class AbstractStandardRestView extends AbstractRestView {
    
    // VARIABLES
    

    public static $FIELD_SINGLE = "single";
    public static $FIELD_LIST = "list";
    private static $FIELD_INFO = "info";
    private static $FIELD_INFO_LASTMODIFIED = "lastmodifed";
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GET
    

    /**
     * @see AbstractView::getController()
     * @return StandardRestController
     */
    public function getController() {
        return parent::getController();
    }

    /**
     * @see AbstractView::getLastModified()
     */
    protected function getLastModified() {
        return max( $this->getController()->getLastModified(), parent::getLastModified(), filemtime( __FILE__ ) );
    }
    
    // ... /GET
    

    /**
     * @see AbstractRestView::getData()
     */
    public function getData() {
        
        // Initiate data array
        $data = array ();
        
        // Building Floor
        $data[ self::$FIELD_SINGLE ] = $this->getController()->getModel();
        
        // Building Floors
        $data[ self::$FIELD_LIST ] = $this->getController()->getModelList() ? $this->getController()->getModelList()->getJson() : array ();
        
        // Info
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_LASTMODIFIED ] = gmdate( 'D, d M Y H:i:s \G\M\T', 
                $this->getLastModified() );
        
        // Return data
        return $data;
    
    }
    
    // /FUNCTIONS


}

?>