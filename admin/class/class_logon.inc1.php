<?php
//class_login.inc.php
class login{

private static $PDO;

public function __construct(){
    // get DB 
    $this->setSession();
    $this->db_connect();
    $this->getView();
    // setInitDB
    // echo __METHOD__;
}
private function db_connect(){
    SELF::$PDO = new PDO ("mysql:host=localhost;charset=utf8","root","root");
    SELF::$PDO ->exec("CREATE DATABASE IF NOT EXISTS db_login");
    SELF::$PDO ->exec("USE db_login");
    //SELF::$PDO ->exec("DROP TAPLE tp_pass");
    SELF::$PDO ->exec("CREATE TABLE IF NOT EXISTS tb_pass(
                        id INT(5) PRIMARY KEY AUTO_INCREMENT,
                        name VARCHAR(50) NOT NULL,
                        password VARCHAR(128) NOT NULL UNIQUE )");

    SELF::$PDO ->exec("CREATE TABLE IF NOT EXISTS tb_salt(
                        id_pass INT (5) UNIQUE,
                        salt VARCHAR(4) NOT NULL,
                        FOREIGN KEY(id_pass)
                        REFERENCES tb_pass(id)
                        ON DELETE CASCADE)");
                        
    //$pass = hash("sha512","123");
    $salt = strval(rand(1000,9999));
    $name = "lisa";
    $password = "123";
    SELF::$PDO ->exec("INSERT INTO tp_pass(name)
                    //   VALUE('[$name]')");
    $id = SELF::$PDO->lastInsertId();
    SELF::$PDO->exec("INSERT INTO tb_salt(id_pass,salt)
                        VALUE ({$id},'{$salt}'");
    $pass = hash("sha512",$salt.$password.$salt);
    SELF::$PDO->exec("UPDATE tb_pass SET pass='{$pass}'
                        WHERE id={$id}");
    //echo"test";
}
private function setSession(){
    session_start(); //anlegen und verwalten 
    if(isset($_REQUEST['user'],$_REQUEST['pass'])){
        if($_REQUEST['user']=="max" & $_REQUEST['pass']="123"){
            $_SESSION['user']=true;
            header("location: seite2.php");
            exit ; 
        }
    }
}
 private function getView(){
    $tpl = 
    '<form class="login">
    <input type="text" pleaceholder="username" name="user"><br>
    <input type="password" pleaceholder="password" name="pass"><br>
    <button>Anmelden</button>
    </form>';
    echo $tpl;
 }
}
?>