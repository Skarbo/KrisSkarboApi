<?php

interface KillHandler
{

    /**
     * @param Exception $exception
     * @return boolean True if auto logging exception error's
     */
    public function isAutoErrorLog( Exception $exception );

    /**
     * Called when page is to be killed
     *
     * @param Exception $exception The exception killer
     * @param ErrorHandler $error_handler
     */
    public function handle( Exception $exception, ErrorHandler $error_handler );

}

?>