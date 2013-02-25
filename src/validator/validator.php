<?php

abstract class Validator extends ClassCore
{

    // VARIABLES


    public static $REGEX_TITLE = '/[^\w\p{L}\s,.-]+/';

    //    static $REGEX_EMAIL = "/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/";
    //    static $REGEX_DATE = "/^(([1-9])|(0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))\\.(([1-9])|(0[1-9])|(1[0-2]))\\.(\\d{4})$/i"; // dd.mm.yyyy
    //    //static $REGEX_DATE = "/^(([1-9])|(0[1-9])|(1[0-2]))\\/(([1-9])|(0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))\\/((\\d{2})|(\\d{4}))|(([1-9])|(0[1-9])|(1[0-9])|(2[0-9])|(3[0-1])).(([1-9])|(0[1-9])|(1[0-2])).(\\d{4})|((\\d{2})|(\\d{4}))\\-(([1-9])|(0[1-9])|(1[0-2]))\\-(([1-9])|(0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))$/i";
    //    static $REGEX_TIME = "/^(20|21|22|23|[0-1]\\d):[0-5]\\d$/";
    //    static $REGEX_COUNTRY = "/[^a-zA-Z������\\s-]/i";
    //    static $REGEX_ADDRESS = "/[^a-zA-Z������0-9'\\s,.-]/i";
    //    static $REGEX_CITY = "/[^a-zA-Z������'\\s,.-]/i";
    //    static $REGEX_ZIP = "/[^0-9\\s-]/i";
    //
    //    static $REGEX_NUMBER = "/[^0-9]/i";


    protected $model;
    protected $locale;

    // CONSTRUCT


    public function __construct( Locale $locale )
    {
        $this->locale = $locale;
    }

    // FUNCTIONS


    //	VALIDATE


    // ... GET


    /**
     * @return Model
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * @return DefaultLocale
     */
    protected function getLocale()
    {
        return $this->locale;
    }

    // ... /GET


    /**
     * @param string $name Name of value
     * @param string $value To be validated
     * @param int $min
     * @param int $max
     * @throws Exception
     * @return string
     */
    protected static function validateLength( $name, $value, $min, $max = NULL )
    {
        $betweenString = $max ? "Must bust be between $min and $max characters." : "Must be minimum $min characters.";

        // Too long
        if ( $max && strlen( strval( $value ) ) > intval( $max ) )
        {
            throw new Exception( "$name is too long. $betweenString" );
        }

        // Too short
        if ( $min && strlen( strval( $value ) ) < intval( $min ) )
        {
            throw new Exception( "$name is too short. $betweenString" );
        }

        return $value;

    }

    /**
     * @param string titleing
     * @param string titlee
     * @throws Exception
     * @return string
     */
    protected static function validateCharacters( $title, $string )
    {

        // Sanatize string, if length is different it is invalid
        if ( strlen( $string ) != strlen( self::sanitizeCharacthers( $string ) ) )
        {
            throw new Exception( sprintf( "%s contains illegal characters", $title ) );
        }

        return $string;

    }

    /**
     * @param string $name
     * @param string $regex_pattern
     * @param string $string
     * @throws Exception
     * @return string
     */
    protected static function validateRegex( $name, $regex_pattern, $string )
    {

        // Validate regex
        if ( preg_match( $regex_pattern, $string ) )
        {
            throw new Exception( sprintf( "\"%s\" contains an illegal characters", $name ) );
        }

        return $string;

    }

    /**
     * Value equals one of values
     *
     * @param string $name
     * @param array $equals array( "0", "1" )
     * @param string $value "1"
     * @return string
     * @throws Exception
     */
    protected function validateValueEquals( $name, array $equals, $value )
    {

        // Value must be in a equals array
        if ( array_search( $value, $equals ) === false )
        {
            throw new Exception( sprintf( "%s contains a wrong value", $name ) );
        }

        return $value;

    }

    //	/VALIDATE


    //	SANITIZE


    /**
     * Sanitizes illegal characters (&lt;,&gt;,&,',")
     *
     * @param string $validate
     */
    protected static function sanitizeCharacthers( $validate )
    {
        return filter_var( $validate, FILTER_SANITIZE_SPECIAL_CHARS );
    }

    //	/SANITIZE


    //	DO


    /**
     * Goes through every validate function
     *
     * @param Model $model
     * @param string $exceptionMessage
     * @throws ValidatorException
     */
    public final function doValidate( Model $model, $exceptionMessage = "" )
    {

        // Set model
        $this->model = $model;

        // Catch array
        $catch = array ();

        // Foreach methods
        foreach ( get_class_methods( $this ) as $method )
        {

            // Method is is a 'do' method and not this method
            if ( strcmp( substr( $method, 0, 2 ), "do" ) == 0 && strcmp( $method, __FUNCTION__ ) != 0 )
            {

                try
                {
                    $this->$method();
                }
                catch ( Exception $e )
                {
                    $catch[] = $e->getMessage();
                }

            }

        }

        // Trow Validator errors
        if ( !empty( $catch ) )
        {
            throw new ValidatorException( $exceptionMessage, $catch );
        }

    }

    //	/DO


}

?>