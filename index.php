<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="css/login.css">
    <title>flogin</title>
</head>
<body>
<?php
include "init.php";
if (!isset($_GET['do'])){
?>
    <div class="container text-center">
    <br><br><br>
        <h1 class="" >TO-DO</h1>
        <br><br>
        <div class="row anm-row">
            <div class="col log">
                <form action="?do=log" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="anm-email" placeholder="Username" name="name" 
                            value='<?php $val = isset($_GET['name']) ? $_GET['name'] : '' ;echo $val; ?>' required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="anm-Password" placeholder="Password" name="pass" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success btn-block" name="sub">anmelden</button>
                </form>
            </div>

            <div class="col">
                <form action="?do=reg" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="anm-email" placeholder="Username" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12"> 
                            <input type="password" class="form-control" id="anm-Password" placeholder="Password" name="pass" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-block" name="sub">registrieren</button>
                </form>
            </div>
        </div>
    </div>
<?php 
}elseif (isset($_GET['do'])) {
    $do = $_GET['do'];
    if ($do == "reg" ){
        if (isset($_POST['sub'])){
            $salt = strval(rand(1000,9999));
            $name = filter_var( $_POST['name'],   FILTER_SANITIZE_STRING);
            $pass = $_POST['pass'];
            $stmt =  $conn->prepare("INSERT INTO tb_pass(name,password)VALUE (:iName, :ipass)");
            $stmt ->execute(array(
            'iName'          => $name,
            'ipass'          => hash("sha512",$salt.$pass.$salt)
            ));
            $stmt1 =  $conn->prepare("INSERT INTO tb_salt(name,salt) VALUE (:iName, :ipass)");
            $stmt1 ->execute(array(
            'iName'          => $name,
            'ipass'          => $salt ));
            echo
            '<div class=" container alert alert-success alert-dismissible fade show" role="alert">
            <strong>erfolgreich hinzugefügt</strong> <br> <br><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </div>';
            header('Refresh: 1; url=index.php?name='.$name);
            exit();
        }
    }



    if ($do == "log" ){

        $name = filter_var( $_POST['name'],   FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $stmt  = $conn ->prepare("  SELECT salt FROM tb_salt WHERE name=? LIMIT 1  ");
        $stmt  ->execute(array($name));
        $row = $stmt->fetch();
        $salt= $row['salt'];
        $hashedpass = hash("sha512",$salt.$pass.$salt);
        $stmt1  = $conn ->prepare("     SELECT name,password
                                        FROM tb_pass 
                                        WHERE name=? 
                                        AND password=?
                                        LIMIT 1             ");
        $stmt1  ->execute(array($name,$hashedpass));
        $count = $stmt1->rowCount();
        if ($count > 0 ){
            header('Location: home.php');
            exit();
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>LEIDER SIND SIE NOCH NICHT ANGEMELDET</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
        header('Refresh: 1; url=index.php?name_erorr='.$name);
        exit();
        }
    }   
    
    


}
?>
</body>
</html>