<?php

/**
 * Generates general KrisSkarboApi files from a given database
 *
 * @author Kris
 *
 */
class Generator {
    
    // VARIABLES
    

    private static $TEMPLATE_PATH = "generatorTemplates";
    private static $TEMPLATE_MODEL = "model";
    private static $TEMPLATE_MODEL_LIST = "list";
    private static $TEMPLATE_MODEL_FACTORY = "modelfactory";
    private static $TEMPLATE_DB_RESOURCE = "resource";
    private static $TEMPLATE_DB_RESOURCES = "resources";
    private static $TEMPLATE_DAO = "dao";
    private static $TEMPLATE_DAO_DB = "daodb";
    private static $TEMPLATE_DAO_STANDARD = "standarddao";
    private static $TEMPLATE_DAO_DB_STANDARD = "standarddaodb";
    private static $TEMPLATE_TEST = "test";
    private static $TEMPLATE_TEST_DAO = "testdao";
    
    private static $GENERATED_PATH = "generated";
    private static $GENERATED_MODEL_PATH = "model";
    private static $GENERATED_MODEL_LIST_PATH = "list";
    private static $GENERATED_MODEL_FACTORY_PATH = "factory";
    private static $GENERATED_RESOURCE_PATH = "resource";
    private static $GENERATED_RESOURCE_DB_PATH = "db";
    private static $GENERATED_DAO = "dao";
    private static $GENERATED_DAO_DB = "db";
    private static $GENERATED_TEST = "test";
    private static $GENERATED_TEST_DAO = "dao";
    
    const MODE_DAO_DB = "db";
    const MODE_DAO_STANDARD = "standard";
    
    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbDatabase;
    private $dbLink;
    private $dbSelected;
    private $modeDao;
    
    /**
     * Which tables to skip
     *
     * @var Array
     */
    public $skipTables = array ();
    /**
     * @var array
     */
    public $onlyTables = array ();
    /**
     * @var string Table prefix to ignore
     */
    public $prefixIgnore = "";
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    public function __construct( $dbHost, $dbUser, $dbPassword, $dbDatabase, $modeDao = self::MODE_DAO_DB ) {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbDatabase = $dbDatabase;
        $this->modeDao = $modeDao;
    }

    public function __destruct() {
        if ( $this->dbLink ) {
            mysql_close( $this->dbLink );
        }
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GET
    

    // ... ... STATIC
    

    /**
     * @param string filenamele
     * @return array Array( filename, Array( folders ), class name, variable prefix )
     */
    private function getTableInfo( $table ) {
        
        if ( $this->prefixIgnore )
            $table = strstr( $table, $this->prefixIgnore ) == 0 ? substr( $table, strlen( $this->prefixIgnore ) ) : $table;
        
        $tableExploded = array_reverse( explode( "_", $table ) );
        
        $funcCapitalizeArray = function ( $array ) {
            return array_map( 
                    function ( $var ) {
                        return ucwords( strtolower( $var ) );
                    }, $array );
        };
        
        $className = implode( "", $funcCapitalizeArray( $tableExploded ) );
        
        $filename = strtolower( implode( "_", $tableExploded ) );
        
        $tableExplodedShift = $tableExploded;
        array_shift( $tableExplodedShift );
        $folders = $tableExplodedShift;
        
        $prefix = sprintf( "%s_", $tableExploded[ 0 ] );
        
        return array ( $filename, $folders, $className, $prefix );
    
    }

    /**
     * @param string $str "property_name"
     * @return string "PropertyName"
     */
    private static function getCamelcaseUnderscore( $str, $ignoreFirst = "" ) {
        $str = $ignoreFirst && strpos( $str, $ignoreFirst ) === 0 ? substr( $str, strlen( $ignoreFirst ) ) : $str;
        return implode( "", 
                array_map( 
                        function ( $var, $i ) {
                            return $i == 0 ? strtolower( $var ) : ucwords( strtolower( $var ) );
                        }, explode( "_", $str ), array_flip( explode( "_", $str ) ) ) );
    }
    
    // ... ... /STATIC
    

    private function getDbTables() {
        $sql = sprintf( "SHOW TABLES FROM `%s`", $this->dbDatabase );
        $result = mysql_query( $sql );
        
        if ( !$result ) {
            die( sprintf( "Could not list \"%s\" tables: %s", $this->dbDatabase, mysql_error() ) );
        }
        
        $tables = array ();
        while ( $row = mysql_fetch_row( $result ) ) {
            if ( !empty( $this->onlyTables ) ? in_array( $row[ 0 ], $this->onlyTables ) : !in_array( $row[ 0 ], 
                    $this->skipTables ) ) {
                $tables[] = $row[ 0 ];
            }
        }
        
        mysql_free_result( $result );
        
        return $tables;
    }

    /**
     * @param $table Table
     * @return Array
     */
    private function getDbTableFields( $table ) {
        
        $result = mysql_query( sprintf( 'SELECT * FROM `%s`', $table ) );
        if ( !$result ) {
            die( sprintf( 'Getting table \"%s\" properties failed: %s', $table, mysql_error() ) );
        }
        
        $i = 0;
        $fields = array ();
        while ( $i < mysql_num_fields( $result ) ) {
            $meta = mysql_fetch_field( $result, $i );
            if ( !$meta ) {
                continue;
            }
            $fields[] = get_object_vars( $meta );
            $i++;
        }
        
        mysql_free_result( $result );
        
        return $fields;
    
    }
    
    // ... /GET
    

    // ... DO
    

    private function doDbConnect() {
        $this->dbLink = mysql_connect( $this->dbHost, $this->dbUser, $this->dbPassword );
        
        if ( !$this->dbLink ) {
            die( 'Could not connect to database: ' . mysql_error() );
        }
        
        $this->dbSelected = mysql_select_db( $this->dbDatabase, $this->dbLink );
        if ( !$this->dbSelected ) {
            die( sprintf( 'Can\'t use database \'%s\': %s', $this->dbDatabase, mysql_error() ) );
        }
    }

    /**
     * Generats the general files to the given path. Will be stored in a root folder "generated".
     *
     * @param string $folder Absolute path
     */
    public function doGenerate( $path ) {
        
        // Path must exist
        if ( !file_exists( $path ) ) {
            die( sprintf( "Path \"%s\" does not exist", $path ) );
        }
        
        // Connect to database
        $this->doDbConnect();
        
        // Get db tables
        $tables = $this->getDbTables();
        
        // CREATE FOLDERS
        

        // Create generated folder
        if ( !file_exists( sprintf( "%s/%s", $path, self::$GENERATED_PATH ) ) ) {
            mkdir( sprintf( "%s/%s", $path, self::$GENERATED_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s\"', self::$GENERATED_PATH ) );
        }
        
        // Create model folder
        if ( !file_exists( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH ) ) ) {
            mkdir( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_MODEL_PATH ) );
        }
        
        // Create model list folder
        if ( !file_exists( 
                sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                        self::$GENERATED_MODEL_LIST_PATH ) ) ) {
            mkdir( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                            self::$GENERATED_MODEL_LIST_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_MODEL_PATH, self::$GENERATED_MODEL_LIST_PATH ) );
        }
        
        // Create model factory folder
        if ( !file_exists( 
                sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                        self::$GENERATED_MODEL_FACTORY_PATH ) ) ) {
            mkdir( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                            self::$GENERATED_MODEL_FACTORY_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_MODEL_PATH, self::$GENERATED_MODEL_FACTORY_PATH ) );
        }
        
        // Create resource folder
        if ( !file_exists( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH ) ) ) {
            mkdir( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_RESOURCE_PATH ) );
        }
        
        // Create resource db folder
        if ( !file_exists( 
                sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH, 
                        self::$GENERATED_RESOURCE_DB_PATH ) ) ) {
            mkdir( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH, 
                            self::$GENERATED_RESOURCE_DB_PATH ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_RESOURCE_PATH, self::$GENERATED_RESOURCE_DB_PATH ) );
        }
        
        // Create dao folder
        if ( !file_exists( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO ) ) ) {
            mkdir( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s\"', $path, self::$GENERATED_PATH, self::$GENERATED_DAO ) );
        }
        
        // Create dao db folder
        if ( !file_exists( 
                sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO, self::$GENERATED_DAO_DB ) ) ) {
            mkdir( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO, 
                            self::$GENERATED_DAO_DB ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_DAO, self::$GENERATED_DAO_DB ) );
        }
        
        // Create test folder
        if ( !file_exists( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_TEST ) ) ) {
            mkdir( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_TEST ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s\"', $path, self::$GENERATED_PATH, self::$GENERATED_TEST ) );
        }
        
        // Create test dao folder
        if ( !file_exists( 
                sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_TEST, self::$GENERATED_TEST_DAO ) ) ) {
            mkdir( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_TEST, 
                            self::$GENERATED_TEST_DAO ) ) or die( 
                    sprintf( 'Can\'t create folder \"%s/%s/%s/%s\"', $path, self::$GENERATED_PATH, 
                            self::$GENERATED_TEST, self::$GENERATED_TEST_DAO ) );
        }
        
        // /CREATE FOLDERS
        

        // GENERATE
        

        // Foreach table
        $tableFields = array ();
        foreach ( $tables as $table ) {
            // Table fields
            $tableFields[ $table ] = $this->getDbTableFields( $table );
            
            // Generate model
            $this->doGenerateModel( 
                    sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH ), $table, 
                    $tableFields[ $table ] );
            
            // Generate model list
            $this->doGenerateModelList( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                            self::$GENERATED_MODEL_LIST_PATH ), $table );
            
            // Generate model factory
            $this->doGenerateModelFactory( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_MODEL_PATH, 
                            self::$GENERATED_MODEL_FACTORY_PATH ), $table, $tableFields[ $table ] );
            
            // Generate resources
            $this->doGenerateDbResourceTable( 
                    sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH, 
                            self::$GENERATED_RESOURCE_DB_PATH ), $table, $tableFields[ $table ] );
            
            // Generate dao
            if ( $this->modeDao == self::MODE_DAO_STANDARD ) {
                $this->doGenerateDaoStandard( 
                        sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO ), $table, 
                        $tableFields[ $table ] );
            }
            else {
                $this->doGenerateDao( sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO ), 
                        $table, $tableFields[ $table ] );
            }
            
            // Generate dao db
            if ( $this->modeDao == self::MODE_DAO_STANDARD ) {
                $this->doGenerateDaoDbStandard( 
                        sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO, 
                                self::$GENERATED_DAO_DB ), $table, $tableFields[ $table ] );
            }
            else {
                $this->doGenerateDaoDb( 
                        sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_DAO, 
                                self::$GENERATED_DAO_DB ), $table, $tableFields[ $table ] );
            }
            
            // Generate test dao
            if ( $this->modeDao == self::MODE_DAO_DB ) {
                $this->doGenerateTestDao( 
                        sprintf( "%s/%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_TEST, 
                                self::$GENERATED_TEST_DAO ), $table, $tableFields[ $table ] );
            }
        
        }
        
        // Generate resource
        $this->doGenerateDbResource( 
                sprintf( "%s/%s/%s", $path, self::$GENERATED_PATH, self::$GENERATED_RESOURCE_PATH ), $tables );
        
        // Generate test
        $this->doGenerateTest( sprintf( "%s/%s", $path, self::$GENERATED_PATH ), $tables );
        
        // /GENERATE
    

    }
    
    // ... ... GENERATE
    

    /**
     * @param string $path
     * @param string $folders
     * @param string $file
     * @return string Filepath
     */
    private function doCreateFoldersFile( $path, $folders, $file ) {
        
        // Create folders
        $mkdir = $path;
        foreach ( array_reverse( $folders ) as $folder ) {
            $mkdir = sprintf( "%s/%s", $mkdir, $folder );
            if ( !file_exists( $mkdir ) ) {
                mkdir( $mkdir ) or die( sprintf( 'Can\'t create folder \"%s\"', $mkdir ) );
            }
        }
        
        // Create file
        $pathFile = sprintf( "%s/%s", $mkdir, $file );
        $fileHandle = fopen( $pathFile, 'w' ) or die( sprintf( "Can't create file \"%s\"", $pathFile ) );
        fclose( $fileHandle );
        
        // Return path file
        return $pathFile;
    
    }

    private function doWriteFileContents( $filePath, $content ) {
        // Open file
        $fh = fopen( $filePath, 'w' ) or die( sprintf( "Can't open file \"%s\"", $filePath ) );
        
        // Write file
        fwrite( $fh, $content );
        
        // Close file
        fclose( $fh );
    }

    private function doGenerateModel( $path, $table, $fields ) {
        
        $constant = <<<EOF
    const %s = "%s";
EOF;
        
        $variable = <<<EOF
    private $%s;
EOF;
        
        $function = <<<EOF
    public function get:function:()
    {
        return :dollar:this->:variable:;
    }

    public function set:function:( $:variable: )
    {
        :dollar:this->:variable: = $:variable:;
    }\n
EOF;
        
        // Get template contents
        $modelFileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_MODEL ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_model.php", $filename ) );
        
        // Create file contents
        $constants = array ();
        $variables = array ();
        $functions = array ();
        foreach ( $fields as $field ) {
            $fieldCamelCase = self::getCamelcaseUnderscore( $field[ "name" ], $fieldPrefix );
            //var_dump($table, $field["name"], strpos( $field[ "name" ], $fieldPrefix ) === 0, $fieldCamelCase, "<br />");
            

            $constants[] = sprintf( $constant, strtoupper( $fieldCamelCase ), $fieldCamelCase );
            $variables[] = sprintf( $variable, $fieldCamelCase );
            $functions[] = str_replace( ":dollar:", '$', 
                    str_replace( ":function:", ucfirst( $fieldCamelCase ), 
                            str_replace( ":variable:", $fieldCamelCase, $function ) ) );
        
        }
        
        $modelFile = $modelFileContents;
        $modelFile = str_replace( ":class:", $className, $modelFile );
        $modelFile = str_replace( ":constants:", implode( "\n", $constants ), $modelFile );
        $modelFile = str_replace( ":variables:", implode( "\n", $variables ), $modelFile );
        $modelFile = str_replace( ":functions:", implode( "\n", $functions ), $modelFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $modelFile );
    
    }

    private function doGenerateModelList( $path, $table ) {
        
        // Get template contents
        $listFileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_MODEL_LIST ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_list_model.php", $filename ) );
        
        $listFile = $listFileContents;
        $listFile = str_replace( ":class:", $className, $listFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $listFile );
    
    }

    private function doGenerateModelFactory( $path, $table, $fields ) {
        
        $setter = <<<EOF
        \$%s->set%s( \$%s );
EOF;
        
        // Get template contents
        $factoryFileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_MODEL_FACTORY ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_factory_model.php", $filename ) );
        
        $arguments = array ();
        $setters = array ();
        foreach ( $fields as $field ) {
            $fieldCamelCase = self::getCamelcaseUnderscore( $field[ "name" ], $fieldPrefix );
            $arguments[] = sprintf( "$%s", $fieldCamelCase );
            $setters[] = sprintf( $setter, lcfirst( $className ), ucfirst( $fieldCamelCase ), $fieldCamelCase );
        }
        
        $factoryFile = $factoryFileContents;
        $factoryFile = str_replace( ":class:", $className, $factoryFile );
        $factoryFile = str_replace( ":variable:", lcfirst( $className ), $factoryFile );
        $factoryFile = str_replace( ":arguments:", implode( ", ", $arguments ), $factoryFile );
        $factoryFile = str_replace( ":setters:", implode( "\n", $setters ), $factoryFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $factoryFile );
    
    }

    private function doGenerateDbResource( $path, array $tables ) {
        
        $variable = <<<EOF
    private static %s;
EOF;
        
        $function = <<<EOF
    /**
     * @return :class:
     */
    public static function :function:()
    {
        self:::variable: = self:::variable: ? self:::variable: : new :class:();
        return self:::variable:;
    }\n
EOF;
        
        // Get template contents
        $resourceFileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DB_RESOURCE ) );
        
        // Foreach tables
        $variables = array ();
        $functions = array ();
        foreach ( $tables as $table ) {
            
            // Get table info
            list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
            
            $variables[] = sprintf( "$%s", strtoupper( $className ) );
            $functions[] = str_replace( ":variable:", sprintf( "$%s", strtoupper( $className ) ), 
                    str_replace( ":function:", lcfirst( $className ), 
                            str_replace( ":class:", sprintf( "%sDbResource", $className ), $function ) ) );
        
        }
        
        // Create file contents
        $resourceFile = $resourceFileContents;
        $resourceFile = str_replace( ":variables:", sprintf( $variable, implode( ", ", $variables ) ), $resourceFile );
        $resourceFile = str_replace( ":functions:", implode( "\n", $functions ), $resourceFile );
        
        // Write file contentes
        $this->doWriteFileContents( sprintf( "%s/db_resource.php", $path ), $resourceFile );
    
    }

    private function doGenerateDbResourceTable( $path, $table, $fields ) {
        
        $tableVar = <<<EOF
    private \$table = "%s";
EOF;
        
        $variable = <<<EOF
    private \$field:variable: = ":field:";
EOF;
        
        $function = <<<EOF
    public function get:function:()
    {
        return \$this->:variable:;
    }\n
EOF;
        
        // Get template contents
        $resourceFileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DB_RESOURCES ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_db_resource.php", $filename ) );
        
        // Create file contents
        $variables = array ();
        $functions = array (); // array ( str_replace( ":variable:", "table", str_replace( ":function:", "Table", $function ) ) );
        foreach ( $fields as $field ) {
            $fieldCamelCase = ucfirst( 
                    strpos( $field[ "name" ], $fieldPrefix ) === 0 ? self::getCamelcaseUnderscore( 
                            substr( $field[ "name" ], strlen( $fieldPrefix ) ) ) : self::getCamelcaseUnderscore( 
                            $field[ "name" ] ) );
            
            $variables[] = str_replace( ":variable:", $fieldCamelCase, 
                    str_replace( ":field:", $field[ "name" ], $variable ) );
            $functions[] = str_replace( ":variable:", sprintf( "field%s", $fieldCamelCase ), 
                    str_replace( ":function:", sprintf( "Field%s", $fieldCamelCase ), $function ) );
        
        }
        
        $resourceFile = $resourceFileContents;
        $resourceFile = str_replace( ":class:", $className, $resourceFile );
        $resourceFile = str_replace( ":table:", sprintf( $tableVar, $table ), $resourceFile );
        $resourceFile = str_replace( ":fields:", implode( "\n", $variables ), $resourceFile );
        $resourceFile = str_replace( ":functions:", implode( "\n", $functions ), $resourceFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $resourceFile );
    
    }

    private function doGenerateDao( $path, $table, $fields ) {
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DAO ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_dao.php", $filename ) );
        
        $idType = "int";
        $idName = lcfirst( $className );
        foreach ( $fields as $field ) {
            if ( $field[ "primary_key" ] ) {
                $idType = $field[ "type" ];
                $idName = self::getCamelcaseUnderscore( $field[ "name" ] );
            }
        }
        
        $daoFile = $fileContents;
        $daoFile = str_replace( ":class:", $className, $daoFile );
        $daoFile = str_replace( ":id_type:", $idType, $daoFile );
        $daoFile = str_replace( ":id:", $idName, $daoFile );
        $daoFile = str_replace( ":variable:", lcfirst( $className ), $daoFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $daoFile );
    
    }

    private function doGenerateDaoStandard( $path, $table, $fields ) {
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DAO_STANDARD ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_dao.php", $filename ) );
        
        $daoFile = $fileContents;
        $daoFile = str_replace( ":class:", $className, $daoFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $daoFile );
    
    }

    private function doGenerateDaoDb( $path, $table, $fields ) {
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DAO_DB ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_db_dao.php", $filename ) );
        
        $idName = lcfirst( $className );
        $fieldCamelCase = ucfirst( $idName );
        foreach ( $fields as $field ) {
            if ( $field[ "primary_key" ] ) {
                $idName = self::getCamelcaseUnderscore( $field[ "name" ] );
                $fieldCamelCase = ucfirst( 
                        strpos( $field[ "name" ], $fieldPrefix ) === 0 ? self::getCamelcaseUnderscore( 
                                substr( $field[ "name" ], strlen( $fieldPrefix ) ) ) : self::getCamelcaseUnderscore( 
                                $field[ "name" ] ) );
            }
        }
        
        $dbFile = $fileContents;
        $dbFile = str_replace( ":class:", $className, $dbFile );
        $dbFile = str_replace( ":id:", $idName, $dbFile );
        $dbFile = str_replace( ":id_field:", $fieldCamelCase, $dbFile );
        $dbFile = str_replace( ":variable:", lcfirst( $className ), $dbFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $dbFile );
    
    }

    private function doGenerateDaoDbStandard( $path, $table, $fields ) {
        
        $fieldBind = <<<EOF
        \$fields[ Resource::db()->:class:()->getField:function:() ] = "::field:";
        \$binds[ ":field:" ] = \$model->get:function:();
EOF;
        $factoryArgument = "Core::arrayAt( \$modelArray, Resource::db()->%s()->getField%s() )";
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_DAO_DB_STANDARD ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_db_dao.php", $filename ) );
        
        $idName = lcfirst( $className );
        $fieldsBinds = array ();
        $factoryArguments = array ();
        foreach ( $fields as $field ) {
            if ( $field[ "primary_key" ] ) {
                $idName = self::getCamelcaseUnderscore( $field[ "name" ] );
                $idNameFunction = ucfirst( self::getCamelcaseUnderscore( $field[ "name" ], $fieldPrefix ) );
            }
            
            $fieldCamelCase = self::getCamelcaseUnderscore( $field[ "name" ], $fieldPrefix );
            $fieldsBinds[] = str_replace( ":class:", lcfirst( $className ), 
                    str_replace( ":field:", $fieldCamelCase, 
                            str_replace( ":function:", ucfirst( $fieldCamelCase ), $fieldBind ) ) );
            $factoryArguments[] = sprintf( $factoryArgument, lcfirst( $className ), ucfirst( $fieldCamelCase ) );
        }
        
        $dbFile = $fileContents;
        $dbFile = str_replace( ":class:", $className, $dbFile );
        $dbFile = str_replace( ":id:", $idName, $dbFile );
        $dbFile = str_replace( ":id_field:", $idNameFunction, $dbFile );
        $dbFile = str_replace( ":variable:", lcfirst( $className ), $dbFile );
        $dbFile = str_replace( ":fields_binds:", implode( "\n", $fieldsBinds ), $dbFile );
        $dbFile = str_replace( ":factory_arguments:", implode( ", ", $factoryArguments ), $dbFile );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $dbFile );
    
    }

    private function doGenerateTest( $path, $tables ) {
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_TEST ) );
        
        // Freach tables
        $testClasses = array ();
        foreach ( $tables as $table ) {
            
            // Get table info
            list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
            
            $testClasses[] = sprintf( "\t\$this->add( new %sDaoTest() );", $className );
        
        }
        
        // Create content
        $file = $fileContents;
        $file = str_replace( ":test:", implode( "\n", $testClasses ), $file );
        
        // Write file contentes
        $this->doWriteFileContents( sprintf( "%s/test.php", $path ), $file );
    
    }

    private function doGenerateTestDao( $path, $table, $fields ) {
        
        $assertEdit = <<<EOF
            \$this->assertEqual( $:variable:->get:field:(),
                    $:variable:Retrieved->get:field:(),
                    sprintf( ":class: :field: should be \"%s\" but is \"%s\"",
                            $:variable:->get:field:(),
                            $:variable:Retrieved->get:field:() ) );
EOF;
        
        $assertGetList = <<<EOF
            \$this->assertEqual( $:variable:->get:field:(),
                    $:variable:Retrieved->get(0)->get:field:(),
                    sprintf( ":class: :field: should be \"%s\" but is \"%s\"",
                            $:variable:->get:field:(),
                            $:variable:Retrieved->get(0)->get:field:() ) );
EOF;
        
        $assertGet = <<<EOF
            \$this->assertNotNull( $:variable:Retrieved->get:field:(),
                    sprintf( ":class: :field: \"%s\" should not be null",
                            $:variable:->get:field:() ) );
EOF;
        
        // Get template contents
        $fileContents = file_get_contents( 
                sprintf( "%s/%s/%s", dirname( __FILE__ ), self::$TEMPLATE_PATH, self::$TEMPLATE_TEST_DAO ) );
        
        // Get table info
        list ( $filename, $folders, $className, $fieldPrefix ) = $this->getTableInfo( $table );
        
        // Create folders and file
        $filePath = $this->doCreateFoldersFile( $path, $folders, sprintf( "%s_dao_test.php", $filename ) );
        
        // Foreach fields
        $fieldCamelCase = $className;
        $assertsEdit = array ();
        $assertsGet = array ();
        $assertsGetList = array ();
        foreach ( $fields as $field ) {
            $camelCase = strpos( $field[ "name" ], $fieldPrefix ) === 0 ? self::getCamelcaseUnderscore( 
                    substr( $field[ "name" ], strlen( $fieldPrefix ) ) ) : self::getCamelcaseUnderscore( 
                    $field[ "name" ] );
            
            if ( $field[ "primary_key" ] ) {
                $fieldCamelCase = ucfirst( $camelCase );
            }
            
            if ( !( $field[ "type" ] == "datetime" && $field[ "not_null" ] == 0 ) ) {
                $assertsGet[] = str_replace( array ( ":variable:", ":field:", ":class:" ), 
                        array ( lcfirst( $className ), ucfirst( $camelCase ), $className ), $assertGet );
            }
            if ( !( ( $field[ "type" ] == "datetime" && $field[ "not_null" ] == 0 ) || $field[ "type" ] == "timestamp" ) ) {
                $assertsGetList[] = str_replace( array ( ":variable:", ":field:", ":class:" ), 
                        array ( lcfirst( $className ), ucfirst( $camelCase ), $className ), $assertGetList );
                $assertsEdit[] = str_replace( array ( ":variable:", ":field:", ":class:" ), 
                        array ( lcfirst( $className ), ucfirst( $camelCase ), $className ), $assertEdit );
            }
        }
        
        $file = $fileContents;
        $file = str_replace( ":class:", $className, $file );
        $file = str_replace( ":id:", $fieldCamelCase, $file );
        $file = str_replace( ":variable:", lcfirst( $className ), $file );
        $file = str_replace( ":assertEdit:", implode( "\n", $assertsEdit ), $file );
        $file = str_replace( ":assertGet:", implode( "\n", $assertsGet ), $file );
        $file = str_replace( ":assertGetList:", implode( "\n", $assertsGetList ), $file );
        
        // Write file contentes
        $this->doWriteFileContents( $filePath, $file );
    
    }
    
    // ... ... /GENERATE
    

    // /... DO
    

    // /FUNCTIONS


}

//$generator = new Generator( "localhost", "root", "", "campusguide_test" );


//$generator->doGenerate( realpath( "./" ) );


?>