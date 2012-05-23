<?php

abstract class OutputHandler extends ClassCore
{

    /**
     * Handles the output
     *
     * @param AbstractXhtml $output
     * @return string The output
     */
    public abstract function handle( AbstractXhtml $output );

}

?>