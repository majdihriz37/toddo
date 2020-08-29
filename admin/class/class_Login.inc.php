<?php

class Login{

      
   public function __construct(){
   $this->db_connect();

   }
   private function db_connect(){
      $dsn = "mysql:host=localhost;dbname=shop_z";
      $user = "root";
      $pass = "root";
      $option = array(
         PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES utf8",
      );
      try{
         $conn = new PDO($dsn,$user,$pass,$option);
         $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $conn ->exec("CREATE DATABASE IF NOT EXISTS db_schule_plus");
         $conn ->exec("USE db_schule_plus");
         $conn ->exec("CREATE TABLE IF NOT EXISTS tb_pass(
                           id INT(5) PRIMARY KEY AUTO_INCREMENT,
                           name VARCHAR(50) NOT NULL UNIQUE,
                           password VARCHAR(128) NOT NULL
                           )");
         $conn ->exec("CREATE TABLE IF NOT EXISTS tb_salt(
                           id_pass INT(5) UNIQUE, 
                           salt VARCHAR(4) NOT NULL,
                           FOREIGN KEY(id_pass) REFERENCES tb_pass(id)
                           ON DELETE CASCADE
                           )");
      }catch(PDOException $e){
         echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>GETRENNT</strong>
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         
            <span aria-hidden="true">&times;</span>
         </button><br>
      '. $e->getMessage().'</div>';
      }
   }

   function reg(){
      global$conn;
      echo $_POST["name"];
      $salt = strval(rand(1000,9999));
      $name = filter_var( $_POST['name'],   FILTER_SANITIZE_STRING);
      $pass = $_POST['pass'];
      $stmt =  $conn->prepare("INSERT INTO tb_pass(name,password)
                                             VALUE (:itemName, :itemDesc,) 
                                    ");
                     $stmt ->execute(array(
                     'itemName'          => $name,
                     'itemDesc'          => hash("sha512",$salt.$pass.$salt)
                     )); 
                     echo
                     '<div class=" container alert alert-success alert-dismissible fade show" role="alert">
                     <strong>erfolgreich hinzugefügt</strong> <br> <br><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                     </div>';
                     exit();
   }
   }

?>
