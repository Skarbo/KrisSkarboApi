<?php

abstract class DebugDao extends Dao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Add Debug
     *
     * @param DebugModel $debug
     * @return integer Debug id
     * @throws DbException
     */
    public abstract function addDebug( DebugModel $debug );

    /**
     * Removes all Debug's that are older than 5 sessions
     *
     * @return integer Number of removed Debug's
     * @throws DbException
     */
    public abstract function removeDebugs();

    /**
     * Retrieves the next session
     *
     * @return integer Next session
     * @throws DbException
     */
    public abstract function getNextSession();

    // /FUNCTIONS


}

?>