<?php
include "init.php";
if (!isset($_GET['do'])){
?>
<nav class="navbar navbar-dark bg-rark justify-content-between">
    <h1 class="text-info">TO-DO</h1>
    <form class="form-inline">
        <a href="logout.php" class="btn btn-danger my-2 my-sm-0" type="submit">ABMELDEN</a>
    </form>
</nav>
<body>
    
    <?php
    $stmt = $conn->prepare("SELECT * from tb_todo
                            ");
    $stmt->execute();
    $count = $stmt->fetchAll();
    echo '<div class="container liste" style="">';
    foreach ( $count as $count ){
        if ($count['status']==0){
            $border = "#ccc";
        };
        if ($count['status']==1){
            $border = "green";
        };
        if ($count['status']==2){
            $border = "orange";
        };
        if ($count['status']==3){
            $border = "red";
        };

        echo'
        <div class="card-deck col-12" >
            <div class="card" style="border-left:5px solid '.$border.'">
                <div class="card-body row">
                    <h5 class="card-title col-2" style="border-right:1px solid black">id : '.$count["id"].'<br>'.$count["title"].'</h5>
                    <p class="card-text col-10">'.$count["text"].'</p>
                </div>
            </div>
            <div class="card-footer">
                <a class="btn btn-outline-success opt" href="?do=status&set=1&id='.$count["id"].'"><i class="fas fa-check-circle"></i></a>
                <a class="btn btn-outline-warning opt" href="?do=status&set=2&id='.$count["id"].'"><i class="fas fa-edit"></i></a>
                <a class="btn btn-outline-danger opt" href="?do=status&set=3&id='.$count["id"].'"><i class="fas fa-folder-open"></i></a><br><br>
                <a class="btn btn-block btn-outline-danger opt" href="?do=del&id='.$count["id"].'"><i class="fas fa-times-circle"></i> DEL </a>
            </div>
            </div>
        ';
    }
    ?>
    </div>


                    
                    
    <div class="container ">
        <br>
        <form class="modal-content animate" action="?do=add" method="POST">
            <div class="container">
                <div class="row">
                    <input type="text" class="col-2 " placeholder="title" name="title" maxlength="14" required>
                    <textarea type="text" class="col-9 " placeholder="text" name="text" required></textarea>
                    <button class="btn btn-outline-primary col-1">ADD</button>
                </div>
            </div>
        </form>
    </div>

<?php 
}elseif (isset($_GET['do'])) {
    $do = $_GET['do'];
    if ($do == "add" ){
        $title= $_POST['title'];
        $text = $_POST['text'];
        $stmt = $conn->prepare("INSERT INTO tb_todo (title,text)
                                        VALUE(:tit,:txt)");
        $stmt ->execute(array(
            'tit'=>$title,
            'txt'=>$text
        ));
        header('location:home.php');
        exit();
    }
    if($do == "status"){
        $set=$_GET['set'];
        $id=$_GET['id'];
        $stmt  = $conn ->prepare("UPDATE tb_todo SET status=? WHERE id=? ");
        $stmt->execute(array($set,$id));
        header('location: home.php');
        exit();
    }
    if($do == "del"){
        $id=$_GET['id'];
        $stmt = $conn->prepare("DELETE FROM tb_todo WHERE id =?");
        $stmt ->execute(array($id));
        header('location: home.php');
        exit();
    }
}

?>

</body>
