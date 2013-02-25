<?php

class PdoDbApi extends DbApi
{

    // VARIABLES


    /**
     * @var PDO
     */
    private $pdo = NULL;
    private $pdo_engine = "mysql";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    // ... /GET


    /**
     * @see DbApi::connect()
     */
    public function connect()
    {
        try
        {
            $this->pdo = new PDO( "{$this->pdo_engine}:host={$this->hostname};dbname={$this->database}", $this->username,
                    $this->password );
        }
        catch ( PDOException $e )
        {
            $this->pdo = null;
            throw new DbException( "Connect error: " . $e->getMessage(), $e );
        }

        $this->getPdo()->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }

    /**
     * @see DbApi::disconnect()
     */
    public function disconnect()
    {
        $this->pdo = null;
    }

    /**
     * @see DbApi::query()
     */
    public function query( QueryDbCore $query )
    {

        if ( !$this->pdo )
            throw new Exception( "DAtabase is disconnected" );

        switch ( get_class( $query ) )
        {
            case SelectQueryDbCore::class_() :
                return $this->querySelect( $query );
                break;

            case UpdateQueryDbCore::class_() :
                return $this->queryUpdate( $query );
                break;

            case DeleteQueryDbCore::class_() :
                return $this->queryDelete( $query );
                break;

            case InsertQueryDbCore::class_() :
                return $this->queryInsert( $query );
                break;

            case QueryDbCore::class_() :
                return $this->querySelect( $query );
                break;

            default :
                throw new Exception( "No query is given" );
                break;
        }
    }

    /**
     * True PdoDbApi.pdo is not null
     *
     * @see DbApi::isConnected()
     */
    public function isConnected()
    {
        return !is_null( $this->getPdo() );
    }

    // ... QUERY


    /**
     * @param SelectQueryDbCore $query
     * @return DBResult
     * @throws DbException
     */
    private function querySelect( QueryDbCore $query )
    {

        $result = new ResultDbCore();
        $result->setQuery( $query );

        try
        {

            // Prepare statement
            $preparedStatement = $this->getPdo()->prepare( $query->getQuery()->build() );

            // Execute
            if ( !$query->getBinds() )
            {
                $result->setExecute( $preparedStatement->execute() );
            }
            else
            {
                $result->setExecute( $preparedStatement->execute( $query->getBinds() ) );
            }

            // Row count
            $result->setAffectedRows( $preparedStatement->rowCount() );

            // Fetch mode
            $preparedStatement->setFetchMode( PDO::FETCH_ASSOC );

            // Fetch all and return array
            $result->setRows( $preparedStatement->fetchAll() );

        }
        catch ( PDOException $e )
        {
            throw new DbException( $e->getMessage(), $e, $query );
        }

        return $result;

    }

    /**
     * @param UpdateQueryDbCore $query
     * @return DBResult
     * @throws DbException
     */
    private function queryUpdate( QueryDbCore $query )
    {

        $result = new ResultDbCore();
        $result->setQuery( $query );

        try
        {

            // Prepare statement
            $preparedStatement = $this->getPdo()->prepare( $query->getQuery()->build() );

            // Execute
            if ( !$query->getBinds() )
            {
                $result->setExecute( $preparedStatement->execute() );
            }
            else
            {
                $result->setExecute( $preparedStatement->execute( $query->getBinds() ) );
            }

            // Rows affected
            $result->setAffectedRows( $preparedStatement->rowCount() );

        }
        catch ( PDOException $e )
        {
            throw new DbException( $e->getMessage(), $e, $query );
        }

        return $result;

    }

    /**
     * @param DeleteQueryDbCore $query
     * @return DBResult
     * @throws DbException
     */
    private function queryDelete( DeleteQueryDbCore $query )
    {
        return $this->queryUpdate( $query );
    }

    /**
     * @param InsertQueryDbCore $query
     * @return DBResult
     * @throws DbException
     */
    private function queryInsert( InsertQueryDbCore $query )
    {

        $result = new ResultDbCore();
        $result->setQuery( $query );

        try
        {

            // Prepare statement
            $preparedStatement = $this->getPdo()->prepare( $query->getQuery()->build() );

            // Execute
            if ( !$query->getBinds() )
            {
                $result->setExecute( $preparedStatement->execute() );
            }
            else
            {
                $result->setExecute( $preparedStatement->execute( $query->getBinds() ) );
            }

            // Last insert id
            $result->setInsertId( $this->getPdo()->lastInsertId() );

        }
        catch ( PDOException $e )
        {
            throw new DbException( $e->getMessage(), $e, $query );
        }

        return $result;

    }

    /**
     * @see DbApi::rollback()
     */
    public function rollback()
    {
        return $this->getPdo()->rollBack();
    }

    /**
     * @see DbApi::beginTransaction()
     */
    public function beginTransaction()
    {
        return $this->getPdo()->beginTransaction();
    }

    /**
     * @see DbApi::commit()
     */
    public function commit()
    {
        return $this->getPdo()->commit();
    }

    // ... /QUERY


    // /FUNCTIONS


}

?>