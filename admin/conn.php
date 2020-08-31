<?php
      $dsn = "mysql:host=localhost";
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
                          name varchar(50) NOT NULL UNIQUE, 
                          salt VARCHAR(4) NOT NULL,
                          FOREIGN KEY(name) REFERENCES tb_pass(name)
                          ON DELETE CASCADE
                          )");
        $conn ->exec("CREATE TABLE IF NOT EXISTS tb_todo (
                          id int(5) PRIMARY KEY AUTO_INCREMENT ,
                          title varchar(15) NOT NULL,
                          text text NOT NULL,
                          status int(5) NOT NULL DEFAULT '0'
                          )ENGINE=InnoDB DEFAULT CHARSET=utf8;
                                              )");

      }catch(PDOException $e){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>GETRENNT</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        
            <span aria-hidden="true">&times;</span>
        </button><br>
      '. $e->getMessage().'</div>';
      }
?>


