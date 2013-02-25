<?php

abstract class AbstractStandardRestControllerTest extends AbstractControllerTest
{

    // VARIABLES


    protected static $QUERY_GET_LIST_GET = "%s/get";
    protected static $QUERY_GET_SINGLE_GET = "%s/get/%s";
    protected static $QUERY_GET_LIST_FOREIGN_GET = "%s/foreign/%s";
    protected static $QUERY_POST_SINGLE_ADD = "%s/add/%s";
    protected static $QUERY_POST_SINGLE_EDIT = "%s/edit/%s";
    protected static $QUERY_POST_SINGLE_REMOVE = "%s/remove/%s";
    protected static $QUERY_POST_SINGLE_SEARCH = "%s/search/%s";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    // ... ... QUERY


    protected function getQueryGetSingle( $id )
    {
        return sprintf( self::$QUERY_GET_SINGLE_GET, $this->getControllerName(), urlencode( $id ) );
    }

    protected function getQueryGetListMultiple( array $ids )
    {
        return sprintf( self::$QUERY_GET_SINGLE_GET, $this->getControllerName(),
                implode( AbstractStandardRestController::$ID_SPLITTER,
                        array_map(
                                function ( $var )
                                {
                                    return urlencode( $var );
                                }, $ids ) ) );
    }

    protected function getQueryGetList()
    {
        return sprintf( self::$QUERY_GET_LIST_GET, $this->getControllerName() );
    }

    protected function getQueryGetListForeign( array $foreignIds )
    {
        return sprintf( self::$QUERY_GET_LIST_FOREIGN_GET, $this->getControllerName(),
                implode( AbstractStandardRestController::$ID_SPLITTER,
                        array_map(
                                function ( $var )
                                {
                                    return urlencode( $var );
                                }, $foreignIds ) ) );
    }

    protected function getQueryAddSingle( $foreignId )
    {
        return sprintf( self::$QUERY_POST_SINGLE_ADD, $this->getControllerName(), urlencode( $foreignId ) );
    }

    protected function getQueryEditSingle( $id )
    {
        return sprintf( self::$QUERY_POST_SINGLE_EDIT, $this->getControllerName(), urlencode( $id ) );
    }

    protected function getQueryRemoveSingle( $id )
    {
        return sprintf( self::$QUERY_POST_SINGLE_REMOVE, $this->getControllerName(), urlencode( $id ) );
    }

    protected function getQuerySearch( $search )
    {
        return sprintf( self::$QUERY_POST_SINGLE_SEARCH, $this->getControllerName(), urlencode( $search ) );
    }

    // ... ... /QUERY


    /**
     * @return StandardListModel
     */
    protected abstract function getInitiatedModelList();

    /**
     * @param array $array
     * @return StandardModel
     */
    protected abstract function getRestModel( array $array );

    /**
     * @param array arrayy
     * @return IteratorCore
     */
    protected function getRestModelList( array $array )
    {
        $list = $this->getInitiatedModelList();

        foreach ( $array as $modelPost )
        {
            $list->add( $this->getRestModel( $modelPost ) );
        }

        return $list;
    }

    /**
     * @param StandardModel $model
     * @return StandardModel
     */
    protected abstract function getEditedModel( StandardModel $model );

    /**
     * @return StandardDao
     */
    protected abstract function getStandardDao();

    /**
     * @return string Controller name
     */
    protected abstract function getControllerName();

    /**
     * @param StandardModel $model
     * @return string Search string
     */
    protected abstract function getSearchString( StandardModel $model );

    // ... /GET


    // ... ASSERT


    protected abstract function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase );

    protected abstract function assertModelNotNull( Model $model, SimpleTestCase $testCase );

    // ... /ASSERT


    // ... CREATE


    /**
     * @return StandardModel
     */
    protected abstract function createModelTest();

    /**
     * @param StandardModel $model
     * @return array
     */
    protected function createPostModel( StandardModel $model )
    {
        return array ( AbstractStandardRestController::$POST_OBJECT => get_object_vars( $model ) );
    }

    // ... /CREATE


    // ... DO


    /**
     * @param StandardModel $model
     * @param int $foreignId
     * @return StandardModel
     */
    protected function doAddModel( $model, $foreignId )
    {
        $model->setId( $this->getStandardDao()->add( $model, $foreignId ) );
        return $model;
    }

    /**
    * @param int $foreignId
    * @return StandardListModel
    */
    protected function doGetForeign( $foreignId )
    {
        return $this->getStandardDao()->getForeign( $foreignId );
    }

    // ... /DO


    // ... TEST


    public function testShouldGetSingle()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Model
        $this->doAddModel( $model, $model->getForeignId() );

        // Get Website
        $url = self::getRestWebsite( $this->getQueryGetSingle( $model->getId() ) );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        //         $this->showHeaders();
        //         $this->showRequest();
        //         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK ) )
        {

            // Get REST Model
            $modelRest = $this->getRestModel(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_SINGLE, array () ) );

            // Get REST List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Assert Model
            if ( $this->assertFalse( is_null( $modelRest ), "Model REST should not be null" ) )
            {
                $this->assertModelEquals( $model, $modelRest, $this );
            }
            $this->assertEqual( 1, $modelListRest->size(),
                    sprintf( "Model List REST size should be 1 but is \"%d\"", $modelListRest->size() ) );

        }

    }

    public function testShouldGetList()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Model
        $this->doAddModel( $model, $model->getForeignId() );

        // Get Website
        $url = self::getRestWebsite( $this->getQueryGetList() );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        //         $this->showHeaders();
        //         $this->showRequest();
        //         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK, "Should be correct response" ) )
        {

            // Get REST List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Assert List
            if ( $this->assertEqual( 1, $modelListRest->size(),
                    sprintf( "Model List REST size should be 1 but is \"%d\"", $modelListRest->size() ) ) )
            {
                $this->assertModelEquals( $model, $modelListRest->get( 0 ), $this );
            }

        }

    }

    public function testShouldAddSingle()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Get Website
        $url = self::getRestWebsite( $this->getQueryAddSingle( $model->getForeignId() ) );

        // Do POST
        $data = $this->post( $url, $this->createPostModel( $model ) );
        $dataArray = json_decode( $data, true );

        //                                         $this->showHeaders();
        //                                         $this->showRequest();
        //                                         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {

            // Get REST Model
            $modelRest = $this->getRestModel(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_SINGLE, array () ) );

            // Assert Model
            if ( $this->assertFalse( is_null( $modelRest ), "Model REST should not be null" ) )
            {
                $this->assertModelEquals( $model, $modelRest, $this );
            }

        }
    }

    public function testShouldEditSingle()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Model
        $this->doAddModel( $model, $model->getForeignId() );

        // Edit Model
        $modelEdited = $this->getEditedModel( $model );

        // Get Website
        $url = self::getRestWebsite( $this->getQueryEditSingle( $model->getId() ) );

        // Do POST
        $data = $this->post( $url, $this->createPostModel( $modelEdited ) );
        $dataArray = json_decode( $data, true );

        //                                                 $this->showHeaders();
        //                                                 $this->showRequest();
        //                                                 $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {

            // Get REST Model
            $modelRest = $this->getRestModel(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_SINGLE, array () ) );

            // Assert Model
            if ( $this->assertFalse( is_null( $modelRest ), "Model REST should not be null" ) )
            {
                $this->assertModelEquals( $modelEdited, $modelRest, $this );
            }

        }
    }

    public function testShouldDeleteSingle()
    {

        // Create test Model
        $model = $this->createModelTest();
        $modelTwo = $this->getEditedModel( clone $model );

        // Add Models
        $this->doAddModel( $model, $model->getForeignId() );
        $this->doAddModel( $modelTwo, $modelTwo->getForeignId() );

        // Get Website
        $url = self::getRestWebsite( $this->getQueryRemoveSingle( $model->getId() ) );

        // Do POST
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        //         $this->showHeaders();
        //         $this->showRequest();
        //         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK ) )
        {

            // Get REST Model
            $modelRest = $this->getRestModel(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_SINGLE, array () ) );

            // Get REST Model List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Get Model List
            $modelList = $this->doGetForeign( $modelTwo->getForeignId() );

            // Assert List
            if ( $this->assertEqual( $modelList->size(), $modelListRest->size(), "Model List size: %s " ) && $this->assertTrue(
                    $modelList->size() > 0, "Model List should contain one Model" ) )
            {
                $this->assertModelEquals( $modelList->get( 0 ), $modelListRest->get( 0 ), $this );
            }

            // Assert Model
            if ( $this->assertFalse( is_null( $modelRest ), "Model REST should not be null" ) )
            {
                $this->assertModelEquals( $model, $modelRest, $this );
            }

        }
    }

    public function testShouldGetListForeign()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Models
        $this->doAddModel( $model, $model->getForeignId() );
        $this->doAddModel( $model, $model->getForeignId() );
        $this->doAddModel( $model, $model->getForeignId() );

        // Get Website
        $url = self::getRestWebsite( $this->getQueryGetListForeign( array ( $model->getForeignId() ) ) );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        //                         $this->showHeaders();
        //                         $this->showRequest();
        //                         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK ) )
        {

            // Get REST List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Assert Model
            $this->assertEqual( 3, $modelListRest->size(),
                    sprintf( "Model List REST size should be 3 but is \"%d\"", $modelListRest->size() ) );

        }

    }

    public function testShouldGetListMultiple()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Models
        $this->doAddModel( $model, $model->getForeignId() );
        $modelOneId = $model->getId();
        $this->doAddModel( $model, $model->getForeignId() );
        $modelTwoId = $model->getId();
        $this->doAddModel( $model, $model->getForeignId() );
        $modelThreeId = $model->getId();

        // Get Website
        $url = self::getRestWebsite(
                $this->getQueryGetSingle(
                        sprintf( "%s%s%s", $modelOneId, AbstractStandardRestController::$ID_SPLITTER, $modelTwoId ) ) );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

//         $this->showHeaders();
//         $this->showRequest();
//         $this->showSource();

        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK ) )
        {

            // Get REST List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Assert Model
            $this->assertEqual( 2, $modelListRest->size(),
                    sprintf( "Model List REST size should be 2 but is \"%d\"", $modelListRest->size() ) );

        }

    }

    public function testShouldSearchList()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Models
        $this->doAddModel( $model, $model->getForeignId() );
        $this->doAddModel( $model, $model->getForeignId() );
        $this->doAddModel( $model, $model->getForeignId() );

        // Get Website
        $search = $this->getSearchString( $model );
        $url = self::getRestWebsite( $this->getQuerySearch( $search ) );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        //         $this->showHeaders();
        //         $this->showRequest();
        //         $this->showSource();


        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK, "Should be correct response" ) )
        {

            // Get REST List
            $modelListRest = $this->getRestModelList(
                    Core::arrayAt( $dataArray, AbstractStandardRestView::$FIELD_LIST, array () ) );

            // Assert Model
            $this->assertEqual( 3, $modelListRest->size(),
                    sprintf( "Model List REST size should be 3 but is \"%d\"", $modelListRest->size() ) );

        }

    }

    // ... /TEST


    // /FUNCTIONS


}

?>