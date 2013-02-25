<?php

abstract class AbstractStandardRestController extends AbstractRestController
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
                            return trim( $val );
                        }, explode( self::$ID_SPLITTER, self::getURI( self::URI_ID ) ) ) );
    }

    protected static function getUriCommand()
    {
        return self::getURI( self::URI_COMMAND );
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
     * @see AbstractController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), $this->getModelList()->getLastModified(),
                $this->getModel() ? $this->getModel()->getLastModified() : null,
                $this->getForeignModel() ? $this->getForeignModel()->getLastModified() : null,
                $this->getForeignModelList() ? $this->getForeignModelList()->getLastModified() : null,
                parent::getLastModified() );
    }

    /**
     * @return StandardListModel
     */
    protected function getModelListInit()
    {
        return new StandardListModel();
    }

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
     * @return boolean True if touch foreign object on manipulation
     */
    protected function isTouchOnManipulate()
    {
        return false;
    }

    /**
     * @return boolean True if command is get
     */
    public static function isGetCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && count( self::getIds() ) == 1;
    }

    /**
     * @return boolean True if command is get multiple
     */
    public static function isGetMultipleCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && count( self::getIds() ) > 1;
    }

    /**
     * @return boolean True if command is get all
     */
    public static function isGetAllCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET && !self::getId();
    }

    /**
     * @return boolean True if command is get foreign
     */
    public static function isGetForeignCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET_FOREIGN && self::getId();
    }

    /**
     * @return boolean True if command is add
     */
    public static function isAddCommand()
    {
        return self::isPost() && self::getURI( self::URI_COMMAND ) == self::COMMAND_ADD;
    }

    /**
     * @return boolean True if command is edit
     */
    public static function isEditCommand()
    {
        return self::isPost() && self::getURI( self::URI_COMMAND ) == self::COMMAND_EDIT && self::getId();
    }

    /**
     * @return boolean True if command is remove
     */
    public static function isRemoveCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_REMOVE && self::getId();
    }

    /**
     * @return boolean True if command is search
     */
    public static function isSearchCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_SEARCH;
    }

    // ... /IS


    // ... DO


    // ... ... COMMANDS


    /**
     * Do get command
     */
    protected function doGetCommand()
    {

        // Set Model
        $this->setModel( $this->doGetModel( self::getId() ) );

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
        $this->setModel( $this->doGetModel( self::getId() ) );

        // Set Model list
        $this->setModelList( $this->doGetList( self::getIds() ) );

        // Set status code
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do get all command
     */
    protected function doGetAllCommand()
    {

        // Set Model list
        $this->setModelList( $this->doGetAll() );

        // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    /**
     * Do get foreign command
     */
    protected function doGetForeignCommand()
    {

        // Set Model list
        $this->setModelList( $this->doGetForeign( self::getIds() ) );

        // Add to list
        if ( !$this->getModelList()->isEmpty() )
            $this->setModel( $this->getModelList()->get( 0 ) );

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
        $modelAdded = $this->doAddModel( $model,
                $this->getForeignModel() ? $this->getForeignModel()->getId() : null );

        // Set added Model
        $this->setModel( $modelAdded );

        // Set Model list
        $this->setModelList(
                $this->doGetForeign( array ( $this->getForeignModel() ? $this->getForeignModel()->getId() : null ) ) );

        // Touch foreign object
        $this->doTouchForeign();

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
        $modelEdited = $this->doEditModel( $this->getModel()->getId(), $model,
                $this->getForeignModel() ? $this->getForeignModel()->getId() : null );

        // Set edited Model
        $this->setModel( $modelEdited );

        // Set Model list
        $this->setModelList(
                $this->doGetForeign( array ( $this->getForeignModel() ? $this->getForeignModel()->getId() : null ) ) );

        // Touch foreign object
        $this->doTouchForeign();

        // Set status scode
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * Do remove command
     */
    protected function doRemoveCommand()
    {

        // Delete Model
        $this->doRemoveModel( $this->getModel()->getId() );

        // Set Model list
        $this->setModelList(
                $this->doGetForeign( array ( $this->getForeignModel() ? $this->getForeignModel()->getId() : null ) ) );

        // Touch foreign object
        $this->doTouchForeign();

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
        $this->setModelList( $this->doSearch( $searchString ) );

        // Set status code
        $this->setStatusCode( self::STATUS_OK );

    }

    // ... ... /COMMANDS


    /**
     * @return StandardModel
     */
    protected function doGetModel( $id )
    {
        return $this->getStandardDao()->get( $id );
    }

    /**
     * @return StandardListModel
     */
    protected function doGetList( array $ids )
    {
        return $this->getStandardDao()->getList( $ids );
    }

    /**
     * @return StandardListModel
     */
    protected function doGetForeign( array $ids )
    {
        return $this->getStandardDao()->getForeign( $ids );
    }

    /**
     * @return StandardListModel
     */
    protected function doGetAll()
    {
        return $this->getStandardDao()->getAll();
    }

    /**
     * @param string $searchString
     * @return StandardListModel
     */
    protected function doGetSearch( $searchString )
    {
        return $this->getStandardDao()->search( $searchString );
    }

    /**
     * @param StandardModel $model
     * @return StandardModel Added model
     */
    protected function doAddModel( StandardModel $model, $foreignId )
    {
        $modelId = $this->getStandardDao()->add( $model, $foreignId );
        return $this->getStandardDao()->get( $modelId );
    }

    /**
     * @param StandardModel $model
     * @return StandardModel Edited model
     */
    protected function doEditModel( $id, StandardModel $model, $foreignId )
    {
        $this->getStandardDao()->edit( $id, $model, $foreignId );
        return $this->getStandardDao()->get( $id );
    }

    /**
     * @param int $id
     */
    protected function doRemoveModel( $id )
    {
        $this->getStandardDao()->remove( $id );
    }

    /**
     * Touches foreign object, sets updated foreign object
     */
    protected function doTouchForeign()
    {
        if ( !$this->isTouchOnManipulate() || !$this->getModel() )
            return;

            // Touch foreign object
        $touched = $this->getForeignStandardDao()->touch( $this->getModel()->getForeignId() );

        // Get foreign object
        $this->setForeignModel( $this->getForeignStandardDao()->get( $this->getModel()->getForeignId() ) );

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
        if ( $this->getForeignStandardDao() )
        {
            // Set foreign Model
            $this->setForeignModel( $this->getForeignStandardDao()->get( self::getId() ) );

            // Foreign model must exist
            if ( !$this->getForeignModel() )
            {
                throw new BadrequestException( sprintf( "Id \"%d\" does not exist", self::getId() ) );
            }
        }
    }

    protected function beforeIsEditDelete()
    {
        // Set Model
        $this->setModel( $this->doGetModel( self::getId() ) );

        // Model must exist
        if ( !$this->getModel() )
        {
            throw new BadrequestException( sprintf( "Id \"%d\" does not exist", self::getId() ) );
        }

        // Set foreign Model
        if ( $this->getForeignStandardDao() )
            $this->setForeignModel( $this->getForeignStandardDao()->get( $this->getModel()->getForeignId() ) );
    }

    // ... /BEFORE


    // ... REQUEST


    /**
     * @see AbstractController::request()
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
            throw new BadrequestException( sprintf( "Unknown command \"%s\"", self::getURI( self::URI_COMMAND ) ),
                    BadrequestException::UNKNOWN_COMMAND );
        }
    }

    // ... /REQUEST


    // /FUNCTIONS


}

?>