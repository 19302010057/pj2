<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的照片</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/my_photo.css"/>
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
<section>
    <script type="text/javascript">
        function disp_alert()
        {
            alert("图片已删除。")
        }
    </script>
    <h4 class="title">我的照片</h4>
    <div class="select-photo">
        <?php output(); ?>
    </div>
</section>
<footer>
    <p>图片版权所有：19ss</p>
    <p>联系人：xx</p>
    &copy;
</footer>
</body>
</html>
<?php
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
function output()
{
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "select * from travelimage order by ImageID ";
$result = $pdo->query($sql);
while ($row = $result->fetch()){
    if ($row["ImageID"]>=82) {
            $array[] = "<a href='photo.php?id=" . $row["ImageID"] . "'>
                        <img src='../../img/travel-images/myPhoto/" . $row["PATH"] . "'>
                        </a>
                        <div class='select-photo-introduce'>
                        <h4>" . $row["Title"] . "</h4>
                        <p>" . $row["Description"] . "</p>
                        <a href='repair.php?id=" . $row["ImageID"] . "'><input type='button' value='修改'></a>
                        <a href='delete.php?id=".$row["ImageID"]."'>
                        <input type='button' name='delete' value='删除'>
                        </a>
                        </div>
                        <hr style='clear: both'>";
    }
}
    if (isset($array)) {
        draw($array);
    } else {
        echo '<h3>还没有图片，请先上传</h3>';
        echo '<a href="upload.php"><button>上传</button></a>';
    }
}
function draw($array){
    $pages = min(count($array)/4,5);
    echo "<div>";
    if ($array==null){
        echo "<b>没有图片</b>";
    }
    elseif (isset($_GET["page"])&&$page = $_GET["page"]){
        if ($page>=0&&$page<=1){
            $page=1;
        }
        for ($i = 0;$i<min(4,count($array)-4*($page-1));$i++){
            echo $array[4*($page-1)+$i];
        }
        if ($pages>0) {
            echo "<h4>";
            echo "<div class='transform-line'>";
            $previous = $page + $pages;
            echo "<div class='pageFoot'>" . "<a href='my_photo.php?&page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous)) . "'><<</a>" . "&nbsp;&nbsp;&nbsp;";
            for ($p = 1; $p <= $pages; $p++) {
                if ($p == $page)
                    echo "<span class='currentPage'>$p</span>&nbsp;&nbsp;&nbsp;";
                else
                    echo "<a href='my_photo.php?&page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
            }
            $next = $page + 1;
            echo "<a href='my_photo.php?&page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>>></a>";
            echo "</div>";
            echo "</h4>";
        }
    }
    else
        header("Refresh:0.1;url=my_photo.php?page=1");
    echo "</div>";
}
?>
