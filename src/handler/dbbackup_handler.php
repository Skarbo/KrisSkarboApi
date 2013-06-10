<?php

class DbbackupHandler extends ClassCore {
    
    // VARIABLES
    

    const OCCURENCE_DEFAULT = 3600; // 1 hour
    private static $BACKUP_FOLDER = "dbbackup";
    private static $BACKUP_INFOFILE = "_backupinfo.txt";
    private static $BACKUP_EXTENTION = "sql";
    
    private $dbHost;
    private $dbUser;
    private $dbPassword;
    /**
     * @var array
     */
    private $databases;
    private $source;
    private $occurence;
    private $time;
    private $tableRowsSkip = array ( '/^error$|.?\_error$/i' );
    
    // /VARIABLES
    

    // CONSTRUCTOR
    

    /**
     * @param string $dbHost
     * @param string $dbUser
     * @param string $dbPassword
     * @param array $databases
     * @param string $source
     * @param int $occurence Backup occurence in seconds
     */
    public function __construct( $dbHost, $dbUser, $dbPassword, array $databases, $source, $occurence = self::OCCURENCE_DEFAULT ) {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->databases = $databases;
        $this->source = $source;
        $this->occurence = $occurence;
        $this->time = time();
    }
    
    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... GETTERS/SETTERS
    

    /**
     * @return string
     */
    public function getDbHost() {
        return $this->dbHost;
    }

    /**
     * @param string $dbHost
     */
    public function setDbHost( $dbHost ) {
        $this->dbHost = $dbHost;
    }

    /**
     * @return string
     */
    public function getDbUser() {
        return $this->dbUser;
    }

    /**
     * @param string $dbUser
     */
    public function setDbUser( $dbUser ) {
        $this->dbUser = $dbUser;
    }

    /**
     * @return string
     */
    public function getDbPassword() {
        return $this->dbPassword;
    }

    /**
     * @param string $dbPassword
     */
    public function setDbPassword( $dbPassword ) {
        $this->dbPassword = $dbPassword;
    }

    /**
     * @return array
     */
    public function getDatabases() {
        return $this->databases;
    }

    /**
     * @param array $databases
     */
    public function setDatabases( array $databases ) {
        $this->databases = $databases;
    }

    /**
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource( $source ) {
        $this->source = $source;
    }

    /**
     * @return int
     */
    public function getOccurence() {
        return $this->occurence;
    }

    /**
     * @param int $occurence
     */
    public function setOccurence( $occurence ) {
        $this->occurence = $occurence;
    }

    /**
     * @return int
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime( $time ) {
        $this->time = $time;
    }
    
    // ... /GETTERS/SETTERS
    

    // ... GET
    

    /**
     * @return string Backup folder source
     */
    private function getBackupFolderSrc() {
        return sprintf( "%s%s%s", $this->getSource(), DIRECTORY_SEPARATOR, self::$BACKUP_FOLDER );
    }

    /**
     * @return string Info file source
     */
    private function getInfoFileSrc() {
        return sprintf( "%s%s%s", $this->getBackupFolderSrc(), DIRECTORY_SEPARATOR, self::$BACKUP_INFOFILE );
    }

    /**
     * @param string $host
     * @return string Database host folder source
     */
    private function getDatabaseHostFolderSrc() {
        return sprintf( "%s%s%s", $this->getBackupFolderSrc(), DIRECTORY_SEPARATOR, $this->getDbHost() );
    }

    /**
     * @param string $database
     * @return string Database file source
     */
    private function getDatabaseFileSrc( $database ) {
        return sprintf( "%s%s%s.%s", $this->getDatabaseHostFolderSrc(), DIRECTORY_SEPARATOR, $database, 
                self::$BACKUP_EXTENTION );
    }

    /**
     * @return int Unix timestamp of last time backup, null if never backup
     */
    private function getLastBackup() {
        if ( !file_exists( $this->getInfoFileSrc() ) ) {
            return null;
        }
        
        // Return last changed
        return filemtime( $this->getInfoFileSrc() );
    }
    
    // ... /GET
    

    // ... DO
    

    /**
     * Create backup folder
     */
    private function doCreateBackupFolder() {
        if ( !file_exists( $this->getBackupFolderSrc() ) ) {
            $return = mkdir( $this->getBackupFolderSrc() );
            
            if ( !$return ) {
                throw new Exception( sprintf( "Can't create folder \"%s\"", $this->getBackupFolderSrc() ) );
            }
            
            if ( !file_exists( $this->getDatabaseHostFolderSrc() ) ) {
                
                $return = mkdir( $this->getDatabaseHostFolderSrc() );
                
                if ( !$return ) {
                    throw new Exception( sprintf( "Can't create folder \"%s\"", $this->getDatabaseHostFolderSrc() ) );
                }
            
            }
        }
    }

    /**
     * Write/append to file
     *
     * @param string $file
     * @param string $content
     * @throws Exception
     */
    private function doWriteFile( $file, $content ) {
        
        // Open file
        $fh = fopen( $file, "a" );
        
        // File must open
        if ( !$fh ) {
            throw new Exception( sprintf( "Can't open file \"%s\"", $file ) );
        }
        
        // Write to file
        fwrite( $fh, sprintf( "%s\n", $content ) );
        
        // Close file
        fclose( $fh );
    
    }

    /**
     * Write to info file
     *
     * @throws Exception Can't open file
     */
    private function doWriteInfoFile() {
        
        // Append to file
        $this->doWriteFile( $this->getInfoFileSrc(), 
                sprintf( "%s - %s - %s", gmdate( "D, d M Y H:i:s \\G\\M\\T", time() ), $this->getDbHost(), 
                        implode( ", ", $this->getDatabases() ) ) );
    
    }

    /**
     * Backup
     *
     * @param resource $link
     * @param string $database
     * @throws Exception
     */
    private function doBackup( $link, $database ) {
        
        // Database must be given
        if ( !$database ) {
            throw new Exception( "Database must be given" );
        }
        
        // Open database
        $dbSelected = mysql_select_db( $database, $link );
        
        if ( !$dbSelected ) {
            throw new Exception( sprintf( "Can't use database \"%s\": %s", $database, mysql_error() ) );
        }
        
        // Get database file
        $databaseFile = $this->getDatabaseFileSrc( $database );
        
        // Delete file if exist
        if ( file_exists( $databaseFile ) ) {
            $result = unlink( $databaseFile );
            
            if ( !$result ) {
                throw new Exception( sprintf( "Can't remove file \"%s\"", $databaseFile ) );
            }
        }
        
        // Write to database file
        $this->doWriteFile( $databaseFile, sprintf( "-- %s", gmdate( "D, d M Y H:i:s \\G\\M\\T", time() ) ) );
        $this->doWriteFile( $databaseFile, "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;" );
        $this->doWriteFile( $databaseFile, "/*!40014 SET FOREIGN_KEY_CHECKS=0 */;" );
        
        // Backup database
        $this->doBackupDatabase( $link, $database );
        
        // Query show tables
        $result = mysql_query( sprintf( "SHOW TABLES FROM `%s`", $database ) );
        
        if ( !$result ) {
            throw new Exception( sprintf( "Invalid query: %s", mysql_error( $link ) ) );
        }
        
        // Get tables
        $tables = array ();
        while ( $row = mysql_fetch_row( $result ) ) {
            $tables[] = Core::arrayAt( $row, 0 );
        }
        
        // Backup tables
        foreach ( $tables as $table ) {
            $this->doBackupDatabaseTable( $link, $database, $table );
        }
        
        // Write to database file
        $this->doWriteFile( $databaseFile, "/*!40014 SET FOREIGN_KEY_CHECKS=1 */;" );
        $this->doWriteFile( $databaseFile, "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;" );
    
    }

    /**
     * Backup database
     *
     * @param resource $link
     * @param string $database
     */
    private function doBackupDatabase( $link, $database ) {
        
        // Table must be given
        if ( !$database ) {
            throw new Exception( "Database must be given" );
        }
        
        // Show create database
        $result = mysql_query( sprintf( "SHOW CREATE DATABASE `%s`;", $database ) );
        
        if ( !$result ) {
            throw new Exception( sprintf( "Invalid query: %s", mysql_error( $link ) ) );
        }
        
        // Retrieve row
        $row = mysql_fetch_row( $result );
        
        // Must contain row
        if ( !$row ) {
            throw new Exception( sprintf( "Backup database query must contains rows for database \"%s\"", $database ) );
        }
        
        $data = array ();
        
        // Comment
        $data[] = sprintf( "-- Dumping database structure for %s", $database );
        
        // Drop database if exist
        $data[] = sprintf( "DROP DATABASE IF EXISTS `%s`;", $database );
        
        // Create database
        $data[] = sprintf( "%s;", Core::arrayAt( $row, 1 ) );
        
        // Use database
        $data[] = sprintf( "USE `%s`;", $database );
        
        $data[] = "\n";
        
        // Write to database file
        $this->doWriteFile( $this->getDatabaseFileSrc( $database ), implode( "\n", $data ) );
    
    }

    /**
     * Backup database table
     *
     * @param resource $link
     * @param string $database
     * @param string $table
     * @throws Exception
     */
    private function doBackupDatabaseTable( $link, $database, $table ) {
        
        // Table must be given
        if ( !$table ) {
            throw new Exception( sprintf( "Table for database \"%s\" must be given", $database ) );
        }
        
        // Backup table
        $result = mysql_query( sprintf( "SHOW CREATE TABLE `%s`", $table ), $link );
        
        if ( !$result ) {
            throw new Exception( 
                    sprintf( "Invalid query for database \"%s\" and table \"%s\": %s", $database, $table, 
                            mysql_error( $link ) ) );
        }
        
        // Retrieve row
        $row = mysql_fetch_row( $result );
        
        // Must contain row
        if ( !$row ) {
            throw new Exception( 
                    sprintf( "Backup database table query must contains rows for database \"%s\" and table \"%s\"", 
                            $database, $table ) );
        }
        
        $data = array ();
        
        // Comment
        $data[] = sprintf( "-- Dumping structure for table %s.%s", $database, $table );
        
        // Drop table if exist
        $data[] = sprintf( "DROP TABLE IF EXISTS `%s`;", $table );
        
        // Create table
        $data[] = sprintf( "%s;", Core::arrayAt( $row, 1 ) );
        
        $data[] = "\n";
        
        // Write to database file
        $this->doWriteFile( $this->getDatabaseFileSrc( $database ), implode( "\n", $data ) );
        
        // Backup databaes table rows
        $this->doBackupDatabaseTableRows( $link, $database, $table );
    
    }

    /**
     * Backup database table rows
     *
     * @param resource $link
     * @param string $database
     * @param string $table
     * @throws Exception
     */
    private function doBackupDatabaseTableRows( $link, $database, $table ) {
        
        // Table must be given
        if ( !$table ) {
            throw new Exception( sprintf( "Table for database \"%s\" must be given", $database ) );
        }
        
        // Select all from table
        $result = mysql_query( sprintf( "SELECT * FROM `%s`.`%s`", $database, $table ), $link );
        
        if ( !$result ) {
            throw new Exception( 
                    sprintf( "Invalid query for database \"%s\" and table \"%s\": %s", $database, $table, 
                            mysql_error( $link ) ) );
        }
        
        // Skip rows
        foreach ( $this->tableRowsSkip as $rowSkipRegex ) {
            if ( preg_match( $rowSkipRegex, $table ) )
                return;
        }
        
        $data = array ();
        
        // Comment
        $data[] = sprintf( "-- Dumping data for table %s.%s: ~%d rows (approximately)", $database, $table, 
                mysql_num_rows( $result ) );
        
        // Not empty
        if ( mysql_num_rows( $result ) > 0 ) {
            
            // Fetch rows
            $rows = array ();
            
            while ( $row = mysql_fetch_assoc( $result ) ) {
                $rows[] = $row;
            }
            
            // Disable keys
            $data[] = sprintf( "/*!40000 ALTER TABLE `%s` DISABLE KEYS */;", $table );
            
            // Table fields
            $tableFields = array_map( 
                    function ( $var ) {
                        return sprintf( "`%s`", $var );
                    }, array_keys( Core::arrayAt( $rows, 0, array () ) ) );
            
            // Insert into table
            

            // Table values
            //             $data[] = implode( ",\n",
            $arr = array_map( 
                    function ( $row ) {
                        return sprintf( "\t(%s)", 
                                implode( ", ", 
                                        array_map( 
                                                function ( $rowValue ) {
                                                    return is_null( $rowValue ) ? "NULL" : ( is_numeric( $rowValue ) ? $rowValue : sprintf( 
                                                            "'%s'", mysql_real_escape_string( utf8_encode( $rowValue ) ) ) );
                                                }, $row ) ) );
                    }, $rows );
            
            foreach ( $arr as $v ) {
                $data[] = sprintf( "INSERT INTO `%s` (%s) VALUES\n%s;", $table, implode( ", ", $tableFields ), $v );
            }
            
            //             $data[] = ";";
            

            // Enable keys
            $data[] = sprintf( "/*!40000 ALTER TABLE `%s` ENABLE KEYS */;", $table );
        
        }
        
        $data[] = "\n";
        
        // Write to database file
        $this->doWriteFile( $this->getDatabaseFileSrc( $database ), implode( "\n", $data ) );
    
    }
    
    // ... /DO
    

    public function handle() {
        
        // Get last backup time
        $lastBackup = $this->getLastBackup();
        
        // Backup if never backed up or occurence time passed
        if ( !$lastBackup || $this->getTime() > ( $lastBackup + $this->getOccurence() ) || filemtime( __FILE__ ) > $lastBackup ) {
            
            // Create backup folder
            $this->doCreateBackupFolder();
            
            // Write info file
            $this->doWriteInfoFile();
            
            // Connect to DB
            $link = mysql_connect( $this->getDbHost(), $this->getDbUser(), $this->getDbPassword() );
            
            if ( !$link ) {
                throw new Exception( sprintf( "Could not connect: %s", mysql_error() ) );
            }
            
            // Foreach databases
            foreach ( $this->getDatabases() as $database ) {
                $this->doBackup( $link, $database );
            }
            
            // Disconnect DB
            mysql_close( $link );
        
        }
    
    }
    
    // /FUNCTIONS


}

?>