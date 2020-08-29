<?php
//class/secure.inc.php

class secure{
    public function __construct(){
        session_start();
        if(!isset($_SESSION['user'])){
            header("Location:index.php");
            exit;
        }
        if(isset($_REQUEST['logout'])){
            session_destroy();//session auflösen
            header("Location: index.php");
            exit;
        }
    }
}
new secure();
?>