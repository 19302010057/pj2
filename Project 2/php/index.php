<?php

require_once('config.php');
/*
 Displays the list of artist links on the left-side of page
*/
function outputMaxPhoto($num) {
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from travelimagefavor where FavorID = $num";
        $result = $pdo->query($sql);
        $row = $result->fetch();
        $uid = $row["ImageID"];
        $sql1 = "select * from travelimage where  ImageID = '$uid'";
        $result1 = $pdo->query($sql1);
        $row1 = $result1->fetch();
        echo '<img src="../../img/travel-images/large/'.$row1['PATH'] .'"class="main-photo">';
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
function outputSmallPaintings($math){
    try {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from travelimage order by ImageID limit 0,80";
            $result = $pdo->query($sql);
            for ($i=0;$i<80;$i++) {
            $row = $result->fetch();
            if (($math-1)*6<= $i &&$math*6>$i)
            outputSinglePainting($row);
        }
            $pdo = null;
        }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
/*
 Displays a single painting
*/
function outputSinglePainting($row){
    echo '<figure class="photos">';
    echo "<a href='photo.php?id=". $row["ImageID"]."'>";
    echo '<img src="../../img/travel-images/large/' .$row["PATH"].' ">';
    echo '<h5>';
    echo $row['Title'];
    echo '</h5>';
    echo '<h5>';
    echo $row['Description'];
    echo '</h5>';
    echo '</a>';
    echo '</figure>'; // end class=content
}
function outputCenter(){
    if (isset($_COOKIE["username"])){
        return "<form method='post'>
            <div>个人中心</div>
            <ul class='plat'>
            <li><a href='upload.php'><img src='../../img/images/upload.jpg' class='plat-photo'>上传 </a></li>
            <li><a href='my_photo.php'><img src='../../img/images/photo%20(2).jpg' class='plat-photo'>我的照片</a></li>
            <li><a href='my_favorite.php'><img src='../../img/images/collect2.jpg' class='plat-photo'>我的收藏</a></li>
            <li><a href='sign_in.php' ><img src='../../img/images/sign.jpg' class='plat-photo'><input type='submit' name='logout' value='登出' class='center-sub'></a></li>
            </ul>
        </form>";
    }
    else return"<a href='sign_in.php'><div class='login'>登陆</div></a>";
}
if (isset($_POST["logout"])){
    setcookie("username","user",time()-3600);
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>主页</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/index.css">

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
        <ul class="nav" id="center">
            <?php echo outputCenter(); ?>
            </ul>
    </nav>
</header>
<section>
    <div class="main-photo">
        <?php
        if (isset($_POST["sub-new"])){
            $math1 = rand(1,10);
            outputMaxPhoto($math1);
        }
        else outputMaxPhoto(1);
        ?>
    </div>
    <div class="small-photo">
           <?php
           if (isset($_POST["sub-new"])){
               $math = rand(1,12);
               outputSmallPaintings($math);
           }
           else outputSmallPaintings(1);
           ?>
    </div>
</section>
<div class="button">
    <form method="post" action="">
    <input type="submit"  value="刷新" name="sub-new"/>
    </form>
    <br/>
    <a href="#header">
        <button class="back">回顶</button>
    </a>
</div>
<footer>
    <div class="footer">
    <p>
       版权所有者：19302010057_陈敏
    </p>
    <p>
        联系方式：3163259989@qq.com
    </p>
    </div>
    <img src="../../img/images/wo.jpg">
    &copy;
</footer>
<script type="text/javascript">
    function exchange() {
        <?php
        global $math;
        $math++;
        ?>
        document.getElementById("photo").innerHTML="<?php outputPaintings();?>";
        location.reload();
    }
</script>
</body>
</html>