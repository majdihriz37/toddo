<?php
//class/class_Login.inc.php

class session{

    public function __construct(){
    $this->setSession();     
    }



    private function setSession(){//Methode
        session_start();//anlegen und verwalten
        if(isset($_REQUEST['user'],$_REQUEST['pass'])){//Formular gesendet
            $name = $_REQUEST['user'];
            $pass = $_REQUEST['pass'];
            $res  = SELF::$PDO ->query("SELECT id FROM tb_pass WHERE name='{$name}'");
            $id   = $res->fetchColumn();
            $res  = SELF::$PDO ->query("SELECT salt FROM tb_salt WHERE id_pass={$id}");
            if($res){
            $salt = $res->fetchColumn();
            $hash =  hash("sha512",$salt.$pass.$salt);
            $res  = SELF::$PDO ->query("SELECT name FROM tb_pass WHERE password = '{$hash}' AND id={$id} ");
            $name = $res->fetchColumn();
            if($name){
                $_SESSION['user'] =  $name;
                header("Location: seite2.php");//zielseite
                exit; //keinen weiteren Code ausführen
            }//if name
            }//if res
        }// if request
    }// end Methode    

    }   
        
        


?>