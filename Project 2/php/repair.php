<?php require_once ('config.php')?>
<?php
header("Content-Type: text/html;charset=utf-8");
$conn = mysqli_connect('localhost', 'chenmin', '316325chenmin');
if ($conn) {
    //数据库连接成功
    $select = mysqli_select_db($conn, "new_travel");  //选择数据库
    if (isset($_POST["submit"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $country = $_POST["country"];
        $city = $_POST["city"];
//得到文件名称
        $topic = $_POST["topic"];
        $id = $_GET["id"];
        if ($title==""||$description==""||$country==""||$city==""){
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "请完善图片信息后再上传！" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "repair.php?id=".$id."" . "\"" . "</script>";
            exit;
        }
        else{
            mysqli_query($conn, 'SET NAMES UTF8');
            //设置编码
            //sql语句
            $sql_select = "select * from geocountries where CountryName = '$country'";
            //sql语句执行
            $result = mysqli_query($conn, $sql_select);
            $num = mysqli_fetch_array($result);
            $cityOfCountry = $num["ISO"];
            $cityCode = "";
            $sql_select1 = "select * from geocities where CountryCodeISO = '$cityOfCountry'";
            $result1 = mysqli_query($conn, $sql_select1);
            while ($num1 = mysqli_fetch_array($result1)) {
                if ($city==$num1["AsciiName"]){
                    $cityCode = $num1["GeoNameID"];
                }
            }
            if ($cityCode==""){
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "国家与城市输入错误！" . "\"" . ")" . ";" . "</script>";
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "repair.php?id=".$id."" . "\"" . "</script>";
                exit;
            }
            else{
                //插入数据
                $sql_update = "update travelimage set Title = '".$title."',Description = '".$description."',cityCode = '".$cityCode."',CountryCodeISO = '".$cityOfCountry."',Content = '".$topic."'where ImageID ='".$id."'";
                $ret = mysqli_query($conn, $sql_update);
                if ($ret) {
                    header("Location:my_photo.php?&page=1");
                }
                else {
                    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "修改失败！" . "\"" . ")" . ";" . "</script>";
                }
            }
        }
    }
    //关闭数据库
    mysqli_close($conn);
}else {
    echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "国家与城市输入错误！" . "\"" . ")" . ";" . "</script>";
    //连接错误处理
    die('Could not connect:' . mysql_error());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>修改</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/upload.css"/>
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
<div class="upload">
    <h4>修改</h4>
    <?php pho(); ?>
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
//寄给客户
//建立连接
function pho(){
    try {
        if(isset($_GET['id'])){
            $id = $_GET["id"];
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from travelimage where ImageID= '$id'";
            $result = $pdo->query($sql);
            $row = $result->fetch();
            $sql1 = "select * from travelimagefavor where ImageID = '$id'";
            $result1 = $pdo->query($sql1);
            $math=0;
            while ($row1 = $result1->fetch()){
                $math++;
            }
            $user=$row["UID"];
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
            echo '<form method="post" name="form">
        <div class="upload-photo">
         <img src="../../img/travel-images/myPhoto/'.$row["PATH"].'"class="file_img">
        </div>
        <div class="upload-input">
            图片标题：
            <br>
            <textarea class="upload-textarea1" name="title">'.$row["Title"].'</textarea>
            <br>
            图片描述：
            <br>
            <textarea class="upload-textarea2" name="description">'.$row['Description'].'</textarea>
            <br>
            拍摄国家：
            <br>
            <textarea class="upload-textarea3" name="country">'.$row3['CountryName'].'</textarea>
            <br>
            拍摄城市：
            <br>
            <textarea class="upload-textarea4" name="city">'.$row4['AsciiName'].'</textarea>
            <br>
            选择主题：
            <select name="topic">
                <option value="scenery">Scenery</option>
                <option value="city">City</option>
                <option value="people">People</option>
                <option value="animal">Animal</option>
                <option value="building">Building</option>
                <option value="wander">Wander</option>
                <option value="other">Other</option>
            </select>
            <input type="submit" name="submit" value="修改" >
        </div>
    </form>';
            $pdo = null;
        }
    }catch(PDOException $e) {
        die( $e->getMessage() );
    }
}
?>
