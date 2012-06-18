<?php

abstract class StandardRestController extends RestController
{

    // VARIABLES


    const URI_COMMAND = 1;
    const URI_ID = 2;
    const URI_SEARCH = 2;

    const COMMAND_ADD = "add";
    const COMMAND_EDIT = "edit";
    const COMMAND_GET = "get";
    const COMMAND_GET_FOREIGN = "foreign";
    const COMMAND_REMOVE = "remove";
    const COMMAND_SEARCH = "search";

    public static $ID_SPLITTER = "_";

    public static $POST_OBJECT = "object";

    /**
     * @var StandardModel
     */
    private $model;
    /**
     * @var IteratorCore
     */
    private $modelList;
    /**
     * @var StandardModel
     */
    private $foreignModel;
    /**
     * @var IteratorCore
     */
    private $foreignModelList;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return StandardModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param StandardModel $model
     */
    public function setModel( StandardModel $model )
    {
        $this->model = $model;
    }

    /**
     * @return StandardListModel
     */
    public function getModelList()
    {
        return $this->modelList;
    }

    /**
     * @param StandardListModel $modelList
     */
    public function setModelList( StandardListModel $modelList )
    {
        $this->modelList = $modelList;
    }

    /**
     * @return StandardModel
     */
    public function getForeignModel()
    {
        return $this->foreignModel;
    }

    /**
     * @param StandardModel $foreignModel
     */
    public function setForeignModel( StandardModel $foreignModel )
    {
        $this->foreignModel = $foreignModel;
    }

    /**
     * @return StandardListModel
     */
    public function getForeignModelList()
    {
        return $this->foreignModelList;
    }

    /**
     * @param StandardListModel $foreignModelList
     */
    public function setForeignModelList( StandardListModel $foreignModelList )
    {
        $this->foreignModelList = $foreignModelList;
    }

    // ... GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return array Id's given in URI
     */
    protected static function getIds()
    {
        return array_filter(
                array_map(
                        function ( $val )
                        {
                            return intval( $val );
                        }, explode( self::$ID_SPLITTER, self::getURI( self::URI_ID ) ) ) );
    }

    /**
     * @return int Id given in URI
     */
    protected static function getId()
    {
        return Core::arrayAt( self::getIds(), 0, null );
    }

    /**
     * @return string Search string
     */
    protected static function getSearchString()
    {
        return self::getURI( self::URI_SEARCH );
    }

    // ... ... STATIC


    /**
     * @return StandardDao
     */
    protected abstract function getStandardDao();

    /**
     * @return StandardDao
     */
    protected abstract function getForeignStandardDao();

    /**
     * @return StandardModel
     * @throws ValidatorException
     */
    protected abstract function getModelPost();

    /**
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), $this->getModelList()->getLastModified(),
                $this->getModel() ? $this->getModel()->getLastModified() : null, parent::getLastModified() );
    }

    /**
     * @return StandardListModel
     */
    protected abstract function getModelListInit();

    /**
     * @return array
     */
    protected static function getPostObject()
    {
        return Core::arrayAt( self::getPost(), self::$POST_OBJECT, array () );
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if command is get
     */
    protected static function isGetCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && count( self::getIds() ) == 1;
    }

    /**
     * @return boolean True if command is get multiple
     */
    protected static function isGetMultipleCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && count( self::getIds() ) > 1;
    }

    /**
     * @return boolean True if command is get all
     */
    protected static function isGetAllCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && !self::getId();
    }

    /**
     * @return boolean True if command is get foreign
     */
    protected static function isGetForeignCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET_FOREIGN && self::getId();
    }

    /**
     * @return boolean True if command is add
     */
    protected static function isAddCommand()
    {
        return self::isPost() && self::getURI( self::URI_COMMAND ) == self::COMMAND_ADD;
    }

    /**
     * @return boolean True if command is edit
     */
    protected static function isEditCommand()
    {
        return self::isPost() && self::getURI( self::URI_COMMAND ) == self::COMMAND_EDIT && self::getId();
    }

    /**
     * @return boolean True if command is remove
     */
    protected static function isRemoveCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_REMOVE && self::getId();
    }

    /**
     * @return boolean True if command is search
     */
    protected static function isSearchCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_SEARCH && self::getSearchString();
    }

    // ... /IS


    // ... DO


    /**
     * Do get command
     */
    protected function doGetCommand()
    {

        // Set Model
        $this->setModel( $this->getStandardDao()->get( self::getId() ) );

        // Add to list
        $this->getModelList()->add( $this->getModel() );

        // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do get multiple command
     */
    protected function doGetMultipleCommand()
    {

        // Set Model
        $this->setModel( $this->getStandardDao()->get( self::getId() ) );

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getList( self::getIds() ) );

        // Set status code
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do get all command
     */
    protected function doGetAllCommand()
    {

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getAll() );

        // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do get foreign command
     */
    protected function doGetForeignCommand()
    {

        // Set Model
        $this->setModel( $this->getStandardDao()->getForeign( array ( self::getId() ) ) );

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getForeign( self::getIds() ) );

        // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do add command
     */
    protected function doAddCommand()
    {

        // Get Model from post
        $model = $this->getModelPost();

        // Add Model
        $modelId = $this->getStandardDao()->add( $model, $this->getForeignModel()->getId() );

        // Set added Model
        $this->setModel( $this->getStandardDao()->get( $modelId ) );

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getForeign( $this->getForeignModel()->getId() ) );

        // Set status scode
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * Do edit command
     */
    protected function doEditCommand()
    {

        // Get Model from post
        $model = $this->getModelPost();

        // Edit Model
        $this->getStandardDao()->edit( $this->getModel()->getId(), $model, $model->getForeignId() );

        // Set edited Model
        $this->setModel( $this->getStandardDao()->get( $this->getModel()->getId() ) );

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getForeign( $this->getModel()->getForeignId() ) );

        // Set status scode
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * Do remove command
     */
    protected function doRemoveCommand()
    {

        // Delete Model
        $this->getStandardDao()->remove( $this->getModel()->getId() );

        // Set Model list
        $this->setModelList(
                $this->getStandardDao()->getForeign( array ( $this->getModel()->getForeignId() ) ) );

        // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do search command
     */
    protected function doSearchCommand()
    {

        // Get search string
        $searchString = self::getSearchString();

        // Set search result as Model list
        $this->setModelList( $this->getStandardDao()->search( $searchString ) );

        // Set status code
        $this->setStatusCode( self::STATUS_OK );

    }

    // ... /DO


    // ... BEFORE


    public function before()
    {

        // Set Model list
        $this->setModelList( $this->getModelListInit() );

        // Get foreign Model
        if ( self::isAddCommand() )
        {
            $this->beforeIsAdd();
        }
        // Get Model
        else if ( self::isEditCommand() || self::isRemoveCommand() )
        {
            $this->beforeIsEditDelete();
        }

    }

    protected function beforeIsAdd()
    {
        // Set foreign Model
        $this->setForeignModel( $this->getForeignStandardDao()->get( self::getId() ) );

        // Foreign model must exist
        if ( !$this->getForeignModel() )
        {
            throw new BadrequestException( sprintf( "Id \"%d\" does not exist", self::getId() ) );
        }
    }

    protected function beforeIsEditDelete()
    {
        // Set Model
        $this->setModel( $this->getStandardDao()->get( self::getId() ) );

        // Model must exist
        if ( !$this->getModel() )
        {
            throw new BadrequestException( sprintf( "Id \"%d\" does not exist", self::getId() ) );
        }
    }

    // ... /BEFORE


    // ... REQUEST


    /**
     * @see Controller::request()
     */
    public function request()
    {

        if ( self::isGetCommand() )
        {
            $this->doGetCommand();
        }
        else if ( self::isGetMultipleCommand() )
        {
            $this->doGetMultipleCommand();
        }
        else if ( self::isGetAllCommand() )
        {
            $this->doGetAllCommand();
        }
        else if ( self::isGetForeignCommand() )
        {
            $this->doGetForeignCommand();
        }
        else if ( self::isAddCommand() )
        {
            $this->doAddCommand();
        }
        else if ( self::isEditCommand() )
        {
            $this->doEditCommand();
        }
        else if ( self::isRemoveCommand() )
        {
            $this->doRemoveCommand();
        }
        else if ( self::isSearchCommand() )
        {
            $this->doSearchCommand();
        }
        else
        {
            throw new BadrequestException( sprintf( "Unknown command \"%s\"", self::getURI( self::URI_COMMAND ) ) );
        }
    }

    // ... /REQUEST


    // /FUNCTIONS


}

?>