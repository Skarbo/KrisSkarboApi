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
     * @return String result
     * @deprecated
     */
    private function parseUrl( $url )
    {
        if ( key_exists( self::generateKey( $url ), self::$PARSED ) )
            return self::$PARSED[ self::generateKey( $url ) ];

            // Check if webpage exists
        $headers = array ();
        if ( !Core::isUrlExist( $url, $headers ) )
        {
            throw new ParserException( sprintf( "Webpage (\"%s\") does not exist", $url ),
                    ParserException::WEBPAGE_NOT_EXIST_ERROR );
        }

        $charset = "UTF-8";
        if ( preg_match( '/Charset=([\w\d-]+)/s', Core::arrayAt( $headers, "Content-Type" ), $matches ) )
        {
            $charset = $matches[ 0 ];
        }

        return SimplehtmldomApi::fileGetHtml( $url );
    }

    /**
     * @param string $url
     * @param WebsiteAlgorithmParser $parseAlgorithm
     * @param array $post Given if post
     * @throws ParserException
     * @return mixed
     */
    public function parse( $url, WebsiteAlgorithmParser $parseAlgorithm, $post = null )
    {
        // Check if webpage exists
        if ( !Core::isUrlExist( $url ) )
        {
            throw new ParserException( sprintf( "Webpage (\"%s\") does not exist", $url ),
                    ParserException::WEBPAGE_NOT_EXIST_ERROR );
        }

        $result = null;
        $html = null;

        // Post
        if ( is_array( $post ) )
        {
            $data = json_encode($post);
            $opts = array (
                    "http" => array ( "method" => "POST", "header" => "Content-Type: application/json\r\nContent-Length: " . strlen($data_string),
                            "content" => $data ) );
            $context = stream_context_create( $opts );
            $html = file_get_contents( $url, false, $context );
        }
        else
            $html = file_get_contents( $url );

            // HTML DOM parse
        if ( $parseAlgorithm->getParseType() == WebsiteAlgorithmParser::PARSER_TYPE_HTMLDOM )
        {

            if ( !$html )
                throw new ParserException( sprintf( "Could not get HTML DOM from webpage (\"%s\")", $url ),
                        ParserException::DOM_ERROR );

            $result = $parseAlgorithm->parseHtmlDom( $html );
        }
        // HTML raw parse
        else
        {
            //$html = SimplehtmldomApi::fileGetHtml( $url );

            if ( !$html )
                throw new ParserException( sprintf( "Could not get HTML from webpage (\"%s\")", $url ),
                        ParserException::HTML_ERROR );

            $result = $parseAlgorithm->parseHtmlRaw( $html );
        }

        return $result;
    }

    // /FUNCTIONS


}

?>