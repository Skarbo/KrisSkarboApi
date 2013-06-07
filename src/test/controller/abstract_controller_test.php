<?php

abstract class AbstractControllerTest extends AbstractWebTest
{

    // VARIABLES


    private static $PAGE_COMMAND = "command.php";
    private static $PAGE_API_REST = "api_rest.php";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->getDaoContainer()->removeAll();
    }

    // ... GET


    public static function getCommandWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_COMMAND, $arguments );
    }

    public static function getRestWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_API_REST, $arguments );
    }

    /**
     * @return InterfaceDaoContainerTest
     */
    public abstract function getDaoContainer();

    public static function getRestStandardSingle( $array )
    {
        return Core::arrayAt( $array, AbstractStandardRestView::$FIELD_SINGLE, array () );
    }

    // ... /GET


    public static function createPostStandard( $object, $_ = null )
    {
        $objectArray = array ();
        $args = func_get_args();
        $args = array_walk( $args,
                function ( $var, $key ) use(&$objectArray )
                {
                    if ( is_object( $var ) )
                        $objectArray = get_object_vars( $var ) + $objectArray;
                    else if ( is_array( $var ) )
                        $objectArray = $var + $objectArray;
                    else
                        $array[] = $var;
                } );
        return array ( AbstractStandardRestController::$POST_OBJECT => $objectArray );
    }

    // /FUNCTIONS


}

?>