<?php

    class PolicyController implements IController{

        private $db;

        public function __construct(){
            require_once(DIRECTORY_MODELS."/MyDatabase.php");
            $this->db = new MyDatabase();
        }

        public function show(string $pageTitle): string{
            global $tplData;
            $tplData = [];

            ob_start();

            require_once(DIRECTORY_VIEWS ."/PolicyTemplate.php");

            $obsah = ob_get_clean();

            return $obsah;
        }
    }

?>