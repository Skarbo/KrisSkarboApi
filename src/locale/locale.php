<?php

abstract class Locale extends ClassCore {
    
    // VARIABLES
    

    const TYPE_DEFAULT = "Default";
    
    private static $_LOCALE;
    
    private $type;
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    public function __construct( $type = self::TYPE_DEFAULT ) {
        $this->type = $type;
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GET
    

    /**
     * @param string $class_name Class name, must be a default locale class
     * @return ClassCore Class instance in given locale
     * @throws Exception
     */
    protected function getLocaleClass( $class_name ) {
        $pos = strrpos( $class_name, "DefaultLocale" );
        $locale_class_postfix = "{$this->type}Locale";
        
        // Generate new class name
        $class_name_new = sprintf( "%s%s", substr( $class_name, 0, $pos ), $locale_class_postfix );
        
        // If class does not exist, use default
        if ( !class_exists( $class_name_new, true ) ) {
            $class_name_new = $class_name;
        }
        
        // Initiate class
        $class_instance = new $class_name_new( $this->type );
        
        // Class must be a Locale
        if ( !is_a( $class_instance, Locale::class_() ) ) {
            throw new Exception( "Locale class \"%s\" must be a Locale", $class_name_new );
        }
        
        // Return Locale instance
        return $class_instance;
    
    }
    
    // ... /GET
    

    /**
     * @return AbstractDefaultLocale
     */
    public static function instance() {
        $defaultLocaleName = sprintf( "%sLocale", self::TYPE_DEFAULT );
        $instanceClassName = class_exists( $defaultLocaleName ) ? $defaultLocaleName : AbstractDefaultLocale::class_();
        self::$_LOCALE = self::$_LOCALE && get_class( self::$_LOCALE ) == $instanceClassName ? self::$_LOCALE : new $instanceClassName();
        return self::$_LOCALE;
    }
    
    // /FUNCTIONS


}

?>