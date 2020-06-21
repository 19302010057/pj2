<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>搜索页</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/search.css"/>
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
<div class="aside-and-section">
<aside>
    <h4 class="title">搜索</h4>
    <div>
        <form action="search.php?page=1" method="post">
        <input type="radio" name="radio" value="1" checked>标题筛选
        <br>
        <textarea class="textarea1" name="text1"></textarea>
        <br>
        <input type="radio" value="2" name="radio">描述筛选
        <br>
        <textarea class="textarea2" name="text2" placeholder="输入主题，国家，城市eg：scenery,Canada,Calgary"></textarea>
        <input type="submit" value="搜索" class="aside-button" name="sub_search">
        </form>
    </div>
</aside>
<section>
    <h4 class="title">图片详情</h4>
    <div class="select-photo">
        <?php output(); ?>
        </div>
</section>
</div>
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
    $conn = mysqli_connect('localhost', 'chenmin', '316325chenmin');
    if ($conn) {
        //数据库连接成功
        $select = mysqli_select_db($conn, "new_travel");  //选择数据库
        if ($select) {
            //数据库选择成功
            if (isset($_POST["sub_search"])) {
                if ($_POST["radio"]==1){
                    $text = $_POST["text1"];
                    //sql语句
                    $sql_select = "select * from travelimage where Title = '$text'";
                    //设置编码
                    mysqli_query($conn, 'SET NAMES UTF8');
                    //执行sql语句
                    $ret = mysqli_query($conn, $sql_select);
                    $row = mysqli_fetch_array($ret);
                    if (!count($row) == 0){
                        echo "<a href='photo.php?id=" . $row["ImageID"] . "'>";
                        echo '<img src="../../img/travel-images/square-medium/' . $row["PATH"] . '">';
                        echo '</a>';
                        echo '<div class="select-photo-introduce">';
                        echo '<h4>'.$row["Title"].'</h4>';
                        echo '<p>'.$row["Description"].'</p>';
                        echo '</div>';
                    }
                    else {
                        echo "<h3>没有符合标题的图片</h3>";
                    }
                }
                else {
                    $text = $_POST["text2"];
                    //sql语句
                    $array1 = explode(",", $text);
                    if (count($array1) == 3) {
                        $sql_select = "select * from geocities where AsciiName = '$array1[2]'";
                        //设置编码
                        mysqli_query($conn, 'SET NAMES UTF8');
                        //执行sql语句
                        $ret = mysqli_query($conn, $sql_select);
                        $row = mysqli_fetch_array($ret);
                        $id = $row["GeoNameID"];
                        $sql_select1 = "select * from travelimage where CityCode = '$id'";
                        mysqli_query($conn, 'SET NAMES UTF8');
                        //执行sql语句
                        $ret1 = mysqli_query($conn, $sql_select1);
                        while ($row1 = mysqli_fetch_array($ret1)) {
                            $array[] = "<a href='photo.php?id=" . $row1["ImageID"] . "'>
                        <img src='../../img/travel-images/square-medium/" . $row1["PATH"] . "'>
                        </a>
                        <div class='select-photo-introduce'>
                        <h4>" . $row1["Title"] . "</h4>
                        <p>" . $row1["Description"] . "</p>
                        </div>";
                        }
                        if (isset($array)) {
                            draw($array,$array1[2]);
                        } else {
                            echo "<h3>没有符合描述的图片</h3>";
                        }
                    }
                    else echo "<h3>请规范格式再进行搜索</h3>";
                }

            }
            if (isset($_GET["id"])){
                $id1 = $_GET["id"];
                $sql_select = "select * from geocities where AsciiName = '$id1'";
                //设置编码
                mysqli_query($conn, 'SET NAMES UTF8');
                //执行sql语句
                $ret = mysqli_query($conn, $sql_select);
                $row = mysqli_fetch_array($ret);
                $id = $row["GeoNameID"];
                $sql_select1 = "select * from travelimage where CityCode = '$id'";
                mysqli_query($conn, 'SET NAMES UTF8');
                //执行sql语句
                $ret1 = mysqli_query($conn, $sql_select1);
                while ($row1 = mysqli_fetch_array($ret1)) {
                    $array[] = "<a href='photo.php?id=" . $row1["ImageID"] . "'>
                        <img src='../../img/travel-images/square-medium/" . $row1["PATH"] . "'>
                        </a>
                        <div class='select-photo-introduce'>
                        <h4>" . $row1["Title"] . "</h4>
                        <p>" . $row1["Description"] . "</p>
                        </div>";
                }
                if (isset($array)) {
                    draw($array,$id1);
                }
            }
        }
        //关闭数据库
        mysqli_close($conn);
    } else {
        //连接错误处理
        die('Could not connect:' . mysql_error());
    }
}
function draw($array,$id){
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
            echo "<div class='pageFoot'>" . "<a href='search.php?id=$id&page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous)) . "'><<</a>" . "&nbsp;&nbsp;&nbsp;";
            for ($p = 1; $p <= $pages; $p++) {
                if ($p == $page)
                    echo "<span class='currentPage'>$p</span>&nbsp;&nbsp;&nbsp;";
                else
                    echo "<a href='search.php?id=$id&page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
            }
            $next = $page + 1;
            echo "<a href='search.php?id=$id&page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>>></a>";
            echo "</div>";
            echo "</h4>";
        }
    }
    else
        header("Refresh:0.1;url=search.php?id=".$id."&page=1");
    echo "</div>";
}
?>
