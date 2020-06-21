<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>删除</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
</head>
<body>
<div style="border: dotted 2px black;height: 80px;width: 80px;margin: 0 auto">
    <h4>你确定要删除吗？</h4>
    <form method="post">
        <input type="submit" value="确定" name="sure">
        <input type="submit" value="取消" name="no">
    </form>
</div>
</body>
</html>
<?php
try{
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        if (isset($_POST["sure"])){
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from travelimage where ImageID = $id";
        $result = $pdo->query($sql);
       if ($result){
           header("Location:my_photo.php?page=1");
       }
       else {
           echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "无法删除！" . "\"" . ")" . ";" . "</script>";
       }
        }
        if (isset($_POST["no"])){
            header("Location:my_photo.php?page=1");
        }
        $pdo = null;
    }
    if (isset($_GET["favor"])){
        $id1 = $_GET["favor"];
        if (isset($_POST["sure"])){
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "delete from travelimagefavor where ImageID = $id1 and UID=32";
            $result = $pdo->query($sql);
            if ($result){
                header("Location:my_favorite.php?page=1");
            }
            else {
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "无法删除！" . "\"" . ")" . ";" . "</script>";
            }
        }
        if (isset($_POST["no"])){
            header("Location:my_favorite.php?page=1");
        }
        $pdo = null;
    }
}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>
