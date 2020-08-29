<?php
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
           
}
?>