<?php

abstract class AbstractStandardDaoTest extends AbstractDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return StandardDao
     */
    protected abstract function getStandardDao();

    /**
     * @param StandardModel $model
     * @return StandardModel
     */
    protected abstract function getEditedModel( StandardModel $model );

    /**
     * @return string Search string
     */
    protected abstract function getSearchString( StandardModel $model );

    // ... /GET


    // ... CREATE


    /**
     * @return StandardModel
     */
    protected abstract function createModelTest();

    // ... /CREATE


    // ... ASSSERT


    public static function assertEqualsFunction( $resultOne, $resultTwo, $desc, SimpleTestCase $testCase )
    {
        return $testCase->assertEqual( $resultOne, $resultTwo, sprintf( "%s - %%s", $desc ) );
    }

    public static function assertNotNullFunction( $result, $desc, SimpleTestCase $testCase )
    {
        return $testCase->assertFalse( is_null( $result ), sprintf( "%s - %%s", $desc ) );
    }

    protected abstract function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase );

    protected abstract function assertModelNotNull( Model $model, SimpleTestCase $testCase );

    // ... /ASSERT


    // ... TEST


    public function testShouldAddModel()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Model
        $objectAdded = $this->getStandardDao()->add( $model, $model->getForeignId() );

        // Assert add
        $this->assertNotNull( $objectAdded, sprintf( "%s should be added", get_class( $model ) ) );

    }

    public function testShouldGetModel()
    {

        // Create test Model
        $model = $this->createModelTest();

        // Add Model
        $model->setId( $this->getStandardDao()->add( $model, $model->getForeignId() ) );

        // Get Model
        $modelRetrieved = $this->getStandardDao()->get( $model->getId() );

        // Assert get
        if ( $this->assertNotNull( $modelRetrieved,
                sprintf( "Retrieved %s should not be null", get_class( $model ) ) ) )
        {
            $this->assertModelNotNull( $model, $this );
        }

    }

    public function testShouldGetAll()
    {

        // Create test model
        $model = $this->createModelTest();

        // Add Model
        $model->setId( $this->getStandardDao()->add( $model, $model->getForeignId() ) );

        // Get Model
        $modelRetrieved = $this->getStandardDao()->get( $model->getId() );

        // Get Model list
        $modelListRetrieved = $this->getStandardDao()->getAll();

        // Assert get list
        if ( $this->assertEqual( 1, $modelListRetrieved->size(),
                sprintf( "Retrieved %s List should be size 1 but is %d", get_class( $model ),
                        $modelListRetrieved->size() ) ) )
        {
            $this->assertModelEquals( $modelRetrieved, $modelListRetrieved->get( 0 ), $this );
        }

    }

    public function testShouldGetForeign()
    {

        // Create test model
        $model = $this->createModelTest();

        // Add Models
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );

        // Get foreign List
        $modelRetrievedForeignList = $this->getStandardDao()->getForeign( array ( $model->getForeignId() ) );

        // Assert foreign list
        $this->assertEqual( 3, $modelRetrievedForeignList->size(),
                sprintf( "Retrieved Foreign %s should be size %d but is %d", get_class( $model ), 3,
                        $modelRetrievedForeignList->size() ) );

    }

    public function testShouldEditModel()
    {

        // Create test model
        $model = $this->createModelTest();

        // Add Model
        $model->setId( $this->getStandardDao()->add( $model, $model->getForeignId() ) );

        // Edit Model
        $modelEdited = $this->getEditedModel( $model );

        $facilityUpdated = $this->getStandardDao()->edit( $model->getId(), $modelEdited, $model->getForeignId() );

        // Get Model
        $modelRetrieved = $this->getStandardDao()->get( $model->getId() );

        // Assert edit
        if ( $this->assertTrue( $facilityUpdated, "Model should be updated" ) )
        {
            $this->assertModelEquals( $modelEdited, $modelRetrieved, $this );
        }

    }

    public function testShouldSearch()
    {

        // Create test model
        $model = $this->createModelTest();

        // Add Models
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );

        // Search Models
        $searchString = $this->getSearchString( $model );
        $modelListResult = $this->getStandardDao()->search( $searchString );

        // Assert foreign list
        $this->assertEqual( 3, $modelListResult->size(),
                sprintf( "Search result \"%s\" should be size %d but is %d", $searchString, 3,
                        $modelListResult->size() ) );

    }

    // ... /TEST


    // /FUNCTIONS


}

?>

