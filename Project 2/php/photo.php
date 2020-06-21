<?php require_once ('config.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图片信息</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/photo.css" type="text/css">
</head>
<body>
<header id="header">
    <nav>
        <h2>
            <a href="index.php" ><img src="../../img/images/photo.jpg" class="header-photo"></a>
            <a href="index.php" class="home">首页</a>
            <a href="Browser.php" class="browser">浏览页</a>
            <a href="search.php" class="search">搜索页</a>
        </h2>
        <ul class="nav">
            <?php echo outputCenter(); ?>
        </ul>
    </nav>
</header>
<script type="text/javascript">
    var sub = document.getElementById("sub");
    function change() {
        if (sub.value==="收藏") {
            sub.value = "为收藏";
        }
        else sub.value="收藏";
    }
</script>
<?php pho(); ?>
<footer>
    <p>图片版权所有：19ss</p>
    <p>联系人：xx</p>
    &copy;
</footer>
</body>
</html>
<?php
function outputCenter()
{
    if (isset($_COOKIE["username"])) {
        return "<form method='post'>
            <div>个人中心</div>
            <ul class='plat'>
            <li><a href='upload.php'><img src='../../img/images/upload.jpg' class='plat-photo'>上传 </a></li>
            <li><a href='my_photo.php'><img src='../../img/images/photo%20(2).jpg' class='plat-photo'>我的照片</a></li>
            <li><a href='my_favorite.php'><img src='../../img/images/collect2.jpg' class='plat-photo'>我的收藏</a></li>
            <li><a href='sign_in.php' ><img src='../../img/images/sign.jpg' class='plat-photo'><input type='submit' name='logout' value='登出' class='center-sub'></a></li>
            </ul>
        </form>";
    } else return "<a href='sign_in.php'><div class='login'>登陆</div></a>";
}
if (isset($_POST["logout"])){
    setcookie("username","user",time()-3600);
    header("Location:index.php");
}
function pho(){
try {
    if(isset($_GET['id'])){
        $id = $_GET["id"];
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql_start = "select * from travelimagefavor where ImageID= '$id'and UID=32";
        $result_start = $pdo->query($sql_start);
        $row_start = $result_start->fetch();
        if ($row_start){
            $sql = "select * from travelimage where ImageID= '$id'";
            $result = $pdo->query($sql);
            $row = $result->fetch();
            $sql1 = "select * from travelimagefavor where ImageID = '$id'";
            $result1 = $pdo->query($sql1);
            $math = 0;
            while ($row1 = $result1->fetch()) {
                $math++;
            }
            $user = $row["UID"];
            $sql2 = "select * from traveluser where UID= '$user'";
            $result2 = $pdo->query($sql2);
            $row2 = $result2->fetch();
            $country = $row["CountryCodeISO"];
            $sql3 = "select * from geocountries where ISO= '$country'";
            $result3 = $pdo->query($sql3);
            $row3 = $result3->fetch();
            $city = $row["CityCode"];
            $sql4 = "select * from geocities where GeoNameID= '$city'";
            $result4 = $pdo->query($sql4);
            $row4 = $result4->fetch();
            echo '<div class="photo-all">';
            echo '<h4 class="photo-title">图片</h4>';
            echo '<h1 class="title">' . $row["Title"] . '</h1>';
            echo '<div class="main">';
            echo "<img src='../../img/travel-images/large/" . $row["PATH"] . "'>";
            echo '<ul>';
            echo '<li class="li-title">收藏数量</li>';
            echo '<li class="like_number">' . $math . '</li>';
            echo '<li class="li-title">图片信息</li>';
            echo '<li>拍摄者：' . $row2['UserName'] . '</li>';
            echo '<li>主题：' . $row['Content'] . '</li>';
            echo '<li>拍摄国家：' . $row3['CountryName'] . '</li>';
            echo '<li>拍摄城市：' . $row4['AsciiName'] . '</li>';
            echo '<li class="collect" onclick="disp_alert()">
            <img src="../../img/images/collect.jpg"/>
            <form method="post">
            <input type="submit" id="sub" name="sub_yes" value="为收藏">
            </form>
        </li>';
            echo '</ul>';
            echo '<p>' . $row['Description'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
        else{
            $sql = "select * from travelimage where ImageID= '$id'";
            $result = $pdo->query($sql);
            $row = $result->fetch();
            $sql1 = "select * from travelimagefavor where ImageID = '$id'";
            $result1 = $pdo->query($sql1);
            $math = 0;
            while ($row1 = $result1->fetch()) {
                $math++;
            }
            $user = $row["UID"];
            $sql2 = "select * from traveluser where UID= '$user'";
            $result2 = $pdo->query($sql2);
            $row2 = $result2->fetch();
            $country = $row["CountryCodeISO"];
            $sql3 = "select * from geocountries where ISO= '$country'";
            $result3 = $pdo->query($sql3);
            $row3 = $result3->fetch();
            $city = $row["CityCode"];
            $sql4 = "select * from geocities where GeoNameID= '$city'";
            $result4 = $pdo->query($sql4);
            $row4 = $result4->fetch();
            echo '<div class="photo-all">';
            echo '<h4 class="photo-title">图片</h4>';
            echo '<h1 class="title">' . $row["Title"] . '</h1>';
            echo '<div class="main">';
            echo "<img src='../../img/travel-images/large/" . $row["PATH"] . "'>";
            echo '<ul>';
            echo '<li class="li-title">收藏数量</li>';
            echo '<li class="like_number">' . $math . '</li>';
            echo '<li class="li-title">图片信息</li>';
            echo '<li>拍摄者：' . $row2['UserName'] . '</li>';
            echo '<li>主题：' . $row['Content'] . '</li>';
            echo '<li>拍摄国家：' . $row3['CountryName'] . '</li>';
            echo '<li>拍摄城市：' . $row4['AsciiName'] . '</li>';
            echo '<li class="collect" onclick="disp_alert()">
            <img src="../../img/images/collect.jpg"/>
            <form method="post">
            <input type="submit" id="sub" name="subno" value="收藏">
            </form>
        </li>';
            echo '</ul>';
            echo '<p>' . $row['Description'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
        $pdo = null;
    }
}catch(PDOException $e) {
    die( $e->getMessage() );
}
}
try {
    if (isset($_POST["subno"])){
        $id = $_GET["id"];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $math = 0;
        $sql_math = "select * from travelimagefavor order by FavorID";
        $result_math = $pdo->query($sql_math);
        while ($row_math = $result_math->fetch()) {
            if ($row_math["FavorID"]>=$math){
                $math = $row_math["FavorID"];
            }
        }
        $math+=1;
        $uid = 32;
        $sql_insert = "insert into travelimagefavor(FavorID,UID,ImageID) values($math,$uid,$id)";
        $result = $pdo->query($sql_insert);
        if ($result){
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "收藏成功！" . "\"" . ")" . ";" . "</script>";
            header("Refresh:0.1;url=photo.php?id=".$id."");
        }
        else
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "不能收藏！" . "\"" . ")" . ";" . "</script>";
        $pdo = null;
    }
    if (isset($_POST["sub_yes"])){
        $id = $_GET["id"];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from travelimagefavor where ImageID = $id and UID=32";
        $result = $pdo->query($sql);
        if ($result){
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "取消收藏！" . "\"" . ")" . ";" . "</script>";
            header("Refresh:0.1;url=photo.php?id=".$id."");
        }
        else
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "取消失败！" . "\"" . ")" . ";" . "</script>";
        $pdo = null;
    }

}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>