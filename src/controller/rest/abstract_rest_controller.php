<?php

abstract class AbstractRestController extends AbstractController
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * POST and GET are sent as SERVER[request method]. Prototype ajax methods DELETE and PUT are sent as an argument in POST[_method].
     *
     * @return string
     */
    public static function getRequestMethod()
    {
        return $_POST[ "_method" ] ? strtoupper( $_POST[ "_method" ] ) : strtoupper(
                $_SERVER[ "REQUEST_METHOD" ] );
    }

    /**
     * @see ClassCore::get_()
     * @param RestController $get
     * @return RestController
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /GET


    /**
     * @see AbstractController::render()
     */
    public function render( AbstractXhtml $root, $content_type = self::CONTENT_TYPE_JSON )
    {
        parent::render( $root );

        // Set Status
        @header( sprintf( "HTTP/1.0 %d", $this->getStatusCode() ) );

        // Set content type
        @header( sprintf( "Content-type: %s", $content_type ) );

    }

    // /FUNCTIONS


}

?>