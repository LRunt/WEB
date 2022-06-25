<?php

interface IController{

    /**
     * Ensures page rendering
     * @param string $pageTitle name of the page
     * @return string HTML of the page
     */
    public function show(string $pageTitle):string;
}

?>