<?php

abstract class StandardDbDao extends DbDao implements StandardDao {
    
    // VARIABLES
    

    // /VARIABLES
    

    // CONSTRUCTOR
    

    // /CONSTRUCTOR
    

    // FUNCTIONS
    

    // ... CREATE
    

    /**
     * @param array $modelArray
     * @return StandardModel
     */
    protected abstract function createModel( array $modelArray );

    /**
     * @param array List
     * @return StandardListModel
     */
    protected function createList( array $listArray ) {
        
        // Initiate list
        $list = $this->getInitiatedList();
        
        // Foreach objects
        foreach ( $listArray as $modelArray ) {
            $list->add( $this->createModel( $modelArray ) );
        }
        
        // Return list
        return $list;
    
    }
    
    // ... /CREATE
    

    // ... GET
    

    /**
     * @return string Table
     */
    protected abstract function getTable();

    /**
     * @return string Primary field
     */
    protected abstract function getPrimaryField();

    /**
     * @return string Foreign field
     */
    protected abstract function getForeignField();

    /**
     * @return string Touch field
     */
    protected function getTouchField() {
        return "";
    }

    /**
     * @param StandardModel $model
     * @param int $foreignId
     * @param boolean True if insert
     * @return array Array( Array( fields ), Array( binds ) )
     */
    protected abstract function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false );

    /**
     * @return SelectQueryDbCore
     */
    protected function getSelectQuery() {
        
        // Select query
        $select_query = new SelectQueryDbCore();
        
        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( SB::pun( $this->getTable(), "*" ) );
        $select_build->setFrom( sprintf( "`%s`", $this->getTable() ) );
        
        $select_query->setQuery( $select_build );
        
        // Return query
        return $select_query;
    
    }

    /**
     * @param string $search
     * @return SelectQueryDbCore
     */
    protected function getSearchSelectQuery( $search, $foreignId = null ) {
        return $this->getSelectQuery();
    }

    /**
     * @return InsertQueryDbCore
     */
    protected function getInsertQuery( StandardModel $model, $foreignId ) {
        
        // Insert query
        $insert_query = new InsertQueryDbCore();
        
        // Get fields and binds
        list ( $fields, $binds ) = $this->getInsertUpdateFieldsBinds( $model, $foreignId, true );
        
        // ... Build
        $insert_build = new InsertSqlbuilderDbCore();
        $insert_build->setInto( $this->getTable() );
        $insert_build->setSetValues( $fields );
        
        $insert_query->setQuery( $insert_build );
        
        // ... Bind
        $insert_query->setBinds( $binds );
        
        // Return insert query
        return $insert_query;
    
    }

    /**
     * @return StandardListModel
     */
    protected abstract function getInitiatedList();
    
    // ... /GET
    

    /**
     * @param mixed $id
     * @return StandardModel
     * @throws DbException
     */
    public function get( $id ) {
        
        // Select query
        $select_query = $this->getSelectQuery();
        
        // ... Build
        $select_build = SelectSqlbuilderDbCore::get_( $select_query->getQuery() );
        $select_build->setWhere( SB::equ( $this->getPrimaryField(), ":id" ) );
        
        // ... Binds
        $select_query->setBinds( array ( "id" => $id ) );
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Return created object
        return count( $result->getRows() ) > 0 ? $this->createModel( $result->getRow( 0 ) ) : null;
    
    }

    /**
     * @param array fields@return StandardListModel
     * @throws DbException
     */
    public function getList( array $ids ) {
        
        // Select query
        $select_query = $this->getSelectQuery();
        
        list ( $fields, $binds ) = SB::createIn( $this->getPrimaryField(), $ids );
        
        // ... Build
        $select_build = SelectSqlbuilderDbCore::get_( $select_query->getQuery() );
        $select_build->setWhere( SB::in( $this->getPrimaryField(), $fields ) );
        
        // ... Binds
        $select_query->setBinds( $binds );
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Return created list
        return $this->createList( $result->getRows() );
    
    }

    /**
     * @return StandardListModel
     * @throws DbException
     */
    public function getAll() {
        
        // Select query
        $select_query = $this->getSelectQuery();
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Return created list
        return $this->createList( $result->getRows() );
    
    }

    /**
     * @param array $foreignIds
     * @return StandardListModel
     * @throws DbException
     */
    public function getForeign( array $foreignIds ) {
        
        // Select query
        $select_query = $this->getSelectQuery();
        
        list ( $fields, $binds ) = SB::createIn( $this->getForeignField(), $foreignIds );
        
        // ... Build
        $select_build = SelectSqlbuilderDbCore::get_( $select_query->getQuery() );
        $select_build->setWhere( SB::in( $this->getForeignField(), $fields ) );
        
        // ... Binds
        $select_query->setBinds( $binds );
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Return created list
        return $this->createList( $result->getRows() );
    
    }

    /**
     * @param StandardModel $model
     * @param int $foreignId [null]
     * @return int Generated id
     * @throws DbException
     */
    public function add( StandardModel $model, $foreignId ) {
        
        // Insert query
        $insert_query = $this->getInsertQuery( $model, $foreignId );
        
        // Do insert
        $result = $this->getDbApi()->query( $insert_query );
        
        // Return object id
        return $result->getInsertId();
    
    }

    /**
     * @param int $id
     * @param StandardModel $model
     * @param int $foreignId [null]
     * @throws DbException
     */
    public function edit( $id, StandardModel $model, $foreignId ) {
        
        // Update query
        $update_query = new UpdateQueryDbCore();
        
        // Get fields and binds
        list ( $fields, $binds ) = $this->getInsertUpdateFieldsBinds( $model, $foreignId, false );
        
        // ... Build
        $update_build = new UpdateSqlbuilderDbCore();
        $update_build->setTable( $this->getTable() );
        $update_build->setSet( $fields );
        $update_build->setWhere( SB::equ( $this->getPrimaryField(), ":id" ) );
        
        $update_query->setQuery( $update_build );
        
        // ... Bind
        $update_query->setBinds( array_merge( $binds, array ( "id" => $id ) ) );
        
        // Do update
        $result = $this->getDbApi()->query( $update_query );
        
        // Return boolean
        return $result->isExecute();
    
    }

    /**
     * @param $id
     * @return boolean True if removed
     * @throws DbException
     */
    public function remove( $id ) {
        
        // Delete query
        $delete_query = new DeleteQueryDbCore( 
                new DeleteSqlbuilderDbCore( $this->getTable(), SB::equ( $this->getPrimaryField(), ":id" ) ), 
                array ( "id" => $id ) );
        
        // Do delete
        $result = $this->getDbApi()->query( $delete_query );
        
        // Return true if removed
        return $result->isExecute();
    
    }

    /**
     * @return int Number removed
     * @throws DbException
     */
    public function removeAll() {
        
        // Delete query
        $delete_query = new DeleteQueryDbCore( new DeleteSqlbuilderDbCore( $this->getTable() ) );
        
        // Do delete
        $result = $this->getDbApi()->query( $delete_query );
        
        // Return number of removed objects
        return $result->getAffectedRows();
    
    }

    /**
     * @see StandardDao::search()
     * @throws DbException
     */
    public function search( $search, $foreignId = null ) {
        
        // Select query
        $select_query = $this->getSearchSelectQuery( $search );
        
        // Do select
        $result = $this->getDbApi()->query( $select_query );
        
        // Return created list
        return $this->createList( $result->getRows() );
    
    }

    /**
     * @see StandardDao::touch()
     * @throws DbException
     */
    public function touch( $id ) {
        
        if ( !$this->getTouchField() )
            return null;
            
            // Update query
        $update_query = new UpdateQueryDbCore();
        
        // ... Build
        $update_build = new UpdateSqlbuilderDbCore();
        $update_build->setTable( $this->getTable() );
        $update_build->setSet( array ( $this->getTouchField() => SB::$CURRENT_TIMESTAMP ) );
        $update_build->setWhere( SB::equ( $this->getPrimaryField(), ":id" ) );
        
        $update_query->setQuery( $update_build );
        
        // ... Bind
        $update_query->setBinds( array ( "id" => $id ) );
        
        // Do update
        $result = $this->getDbApi()->query( $update_query );
        
        // Return boolean
        return $result->isExecute();
    
    }
    
    // /FUNCTIONS


}

?>