<?php

class WebsiteParser extends ClassCore
{

    // VARIABLES


    /**
     * @var array
     */
    private static $PARSED = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function generateKey( $url )
    {
        return preg_replace( '/[^a-zA-Z0-9\_]/i', "", $url );
    }

    /**
     * @param string $url
     * @throws ParserException
     */
    private function parseUrl( $url )
    {
        if ( key_exists( self::generateKey( $url ), self::$PARSED ) )
            return self::$PARSED[ self::generateKey( $url ) ];

            // Check if webpage exists
        if ( !Core::isUrlExist( $url ) )
        {
            throw new ParserException( sprintf( "Webpage (\"%s\") does not exist", $url ),
                    ParserException::WEBPAGE_NOT_EXIST_ERROR );
        }

        return SimplehtmldomApi::fileGetHtml( $url );
    }

    /**
     * @param string $url
     * @param WebsiteAlgorithmParser $parseAlgorithm
     * @throws ParserException
     * @return mixed
     */
    public function parse( $url, WebsiteAlgorithmParser $parseAlgorithm )
    {
        // Parse URL
        $html_dom = $this->parseUrl( $url );

        // Could not get DOM from url
        if ( $html_dom == null )
        {
            throw new ParserException( sprintf( "Could not get DOM from webpage (\"%s\")", $url ),
                    ParserException::DOM_ERROR );
        }

        // Parse html with given algorithm
        $parsed_list = $parseAlgorithm->parseHtml( $html_dom );

        // Return parsed list
        return $parsed_list;
    }

    // /FUNCTIONS


}

?>