<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>browser</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" href="../css/browser.css" type="text/css">
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

<aside >
    <ul >
        <form method="post" action="Browser.php?id3=3&page=1" name="titleSearch">
        <li class="li-title">标题浏览</li>
        <li>
            <input type="text" name="text" id="title_text">
            <input type="submit" class="button-search" id="title_button" value="搜索" name="sub">
        </li>
        </form>
        <li class="li-title">热门国家快速浏览</li>
        <?php outputCountry(); ?>
        <li class="li-title">热门城市快速浏览</li>
        <?php outputCity(); ?>
        <li class="li-title">热门内容快速浏览</li>
        <?php outputOptic(); ?>
    </ul>
</aside>
<section>
    <div class="section-header">
        图片浏览
    </div>
    <div class="section-select">
        <form action="Browser.php?id4=1&page=1" method="post">
            <select id="cmbProvince" name="topic">
            </select>
            <select id="cmbCity" name="country">
            </select>
            <select id="cmbArea" name="city">
            </select>
            <input type="submit" value="刷新" class="button-refresh" name="sub_select">
        </form>
        <script >
            var addressInit = function(_cmbProvince, _cmbCity, _cmbArea, defaultProvince, defaultCity, defaultArea)
            {
                var cmbProvince = document.getElementById(_cmbProvince);
                var cmbCity = document.getElementById(_cmbCity);
                var cmbArea = document.getElementById(_cmbArea);
                function cmbSelect(cmb, str)
                {
                    for(var i=0; i<cmb.options.length; i++)
                    {
                        if(cmb.options[i].value == str)
                        {
                            cmb.selectedIndex = i;
                            return;
                        }
                    }
                }
                function cmbAddOption(cmb, str, obj)
                {
                    var option = document.createElement("OPTION");
                    cmb.options.add(option);
                    option.innerText = str;
                    option.value = str;
                    option.obj = obj;
                }

                function changeCity()
                {
                    cmbArea.options.length = 0;
                    if(cmbCity.selectedIndex == -1)return;
                    var item = cmbCity.options[cmbCity.selectedIndex].obj;
                    for(var i=0; i<item.areaList.length; i++)
                    {
                        cmbAddOption(cmbArea, item.areaList[i], null);
                    }
                    cmbSelect(cmbArea, defaultArea);
                }
                function changeProvince()
                {
                    cmbCity.options.length = 0;
                    cmbCity.onchange = null;
                    if(cmbProvince.selectedIndex == -1)return;
                    var item = cmbProvince.options[cmbProvince.selectedIndex].obj;
                    for(var i=0; i<item.cityList.length; i++)
                    {
                        cmbAddOption(cmbCity, item.cityList[i].name, item.cityList[i]);
                    }
                    cmbSelect(cmbCity, defaultCity);
                    changeCity();
                    cmbCity.onchange = changeCity;
                }

                for(var i=0; i<provinceList.length; i++)
                {
                    cmbAddOption(cmbProvince, provinceList[i].name, provinceList[i]);
                }
                cmbSelect(cmbProvince, defaultProvince);
                changeProvince();
                cmbProvince.onchange = changeProvince;
            }

            var provinceList = [
                {name:'Scenery', cityList:[
                        {name:'Canada', areaList:['Calgary']},
                        {name:'United Kingdom', areaList:['London','Battle']},
                        {name:'United States', areaList:['New York City']},
                        {name:'Germany', areaList:['Berlin','Darmstadt']},
                        {name:'Spain', areaList:['Madrid']},
                        {name:'Ghana', areaList:['Cape Coast','Accra']},
                        {name:'Hungary', areaList:['Budapest']},
                        {name:'Greece', areaList:['Athens','Fira']},
                        {name:'Bahamas', areaList:['Nassau']},
                    ]},
                {name:'Wander', cityList:[
                        {name:'Italy', areaList:['Lucca']},
                        {name:'Germany', areaList:['Frankfurt am Main']},
                    ]},
                {name:'Building', cityList:[
                        {name:'Canada', areaList:['Banff']},
                        {name:'Italy', areaList:['Lucca']},
                    ]}
            ];
            addressInit('cmbProvince', 'cmbCity', 'cmbArea');
        </script>

    </div>
    <div class="section-photo"id="bigDiv">
                    <?php
                    outputtitle();
                    ?>
                    <?php outputSelect();?>
                    <?php
                    outputPaintings();
                    ?>
                    <?php
                    outputPaintings1();
                    ?>
                    <?php
                    outputPaintings2();
                    ?>
    </div>
</section>
<footer>
    <p>图片版权所有：19ss</p>
    <p>联系人：xx</p>
    &copy;
</footer>
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
function outputButton($k){
    if ($k==1) {
        echo '<a href="Browser.php?id3=3&page=1 ">';
        echo '<input type="button">';
        echo '<input type="submit" class="button-search" id="title_button" value="搜索" name="sub" onclick="onsubmit">';
        echo "</a>";
    }
    else{
        echo '<a href="Browser.php?id3=3&page=1 ">';
        echo '<input type="button">';
        echo '<input type="submit" value="刷新" class="button-refresh" name="sub_select" onclick="onsubmit">';
        echo "</a>";
    }
}
//建立连接
function outputtitle()
{
    $conn = mysqli_connect('localhost', 'chenmin', '316325chenmin');
    if ($conn) {
        //数据库连接成功
        $select = mysqli_select_db($conn, "new_travel");  //选择数据库
        if ($select) {
            //数据库选择成功
            if (isset($_POST["sub"])) {
                $text = $_POST["text"];
                //sql语句
                $sql_select = "select * from travelimage where Title = '$text'";
                //设置编码
                mysqli_query($conn, 'SET NAMES UTF8');
                //执行sql语句
                $ret = mysqli_query($conn, $sql_select);
                $row = mysqli_fetch_array($ret);
                if (!count($row)==0) {
                    echo '<figure>';
                    echo "<a href='photo.php?id=" . $row["ImageID"] . "'>";
                    echo '<img src="../../img/travel-images/square-medium/' . $row["PATH"] .'">';
                    echo '</a>';
                    echo '</figure>';
                }
                else echo "<h3>没有符合标题的图片</h3>";
            }
        }
        //关闭数据库
        mysqli_close($conn);
    } else {
        //连接错误处理
        die('Could not connect:' . mysql_error());
    }
}
?>


<?php

function outputSelect(){
    try {
        if (isset($_GET["id4"])&&isset($_POST["sub_select"])) {
            $select3 = $_POST["city"];
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from geocities where AsciiName = '$select3'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()){
                $select = $row["GeoNameID"];
                $sql1 = "select * from travelimage where CityCode = '$select'";
                $result = $pdo->query($sql1);
                echo "<div>";
                while ($row = $result->fetch()) {
                    echo "<a href='photo.php?id=".$row["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row["PATH"]."'></a>";
                }
                echo "<h4>";
                echo "<div class='transform-line'>";
                echo "<div class='pageFoot'>" . "<a href='#'><<</a>" . "&nbsp;&nbsp;&nbsp;";
                echo "<a href='#'>>></a>";
                echo "</div>";
                echo "</h4>";
                echo '</div>';
            }
            $pdo = null;
        }
    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
/*
 Displays a single painting
*/
function outputSinglePainting($row){
    echo '<figure>';
    echo '<img src="../../img/travel-images/square-medium/' .$row["PATH"].' ">';
    echo '</figure>'; // end class=content
}
/* 热门主题浏览*/
function outputCountry(){
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from geocountries where ISO in('CA','US','GH','IT')";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
            echo '<li class="li-content">';
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id1=' . $row['fipsCountryCode'] . '&page=1" class="';
            if (isset($_GET['id1']) && $_GET['id1'] == $row['fipsCountryCode']) echo 'active ';
            echo 'item">';
            echo $row['CountryName'] . '</a>';
            echo '</li>';
        }
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
function outputPaintings(){
    try {
        if(isset($_GET['id1'])){
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id1 = $_GET["id1"];
            $sql = "select * from travelimage where CountryCodeISO= '$id1'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $array[] = "<a href='photo.php?id=".$row["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row["PATH"]."'></a>";
            }
            draw1($array);

            $pdo = null;
        }
    }catch(PDOException $e) {
        die( $e->getMessage() );
    }
}

function outputCity(){
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from geocities where GeoNameID in('5913490','2643743','5128581')";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
            echo '<li class="li-content">';
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id2=' . $row['GeoNameID'] . '&page=1" class="';
            if (isset($_GET['id2']) && $_GET['id2'] == $row['GeoNameID']) echo 'active ';
            echo 'item">';
            echo $row['AsciiName'] . '</a>';
            echo '</li>';
        }
        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
function outputPaintings1() {
    try {
        if(isset($_GET['id2']) && $_GET['id2'] > 0) {
            $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id = $_GET['id2'];
            $sql = "select * from travelimage where CityCode= '$id'";
            $result = $pdo->query($sql);

            while ($row = $result->fetch()) {
                $array[] = "<a href='photo.php?id=".$row["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row["PATH"]."'></a>";
            }
            draw2($array);
            $pdo = null;
        }
    }catch(PDOException $e) {
        die( $e->getMessage() );
    }
}
function outputOptic(){
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from travelimagefavor where ImageID = 7";
        $result = $pdo->query($sql);
        $row = $result->fetch();
            echo '<li class="li-content">';
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id7=7&page=1" class="';
            if (isset($_GET['id']) && $_GET['id'] == $row['ImageID']) echo 'active ';
            echo 'item">';
            echo "scenery" . '</a>';
            echo '</li>';

            echo '<li class="li-content">';
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id5=5&page=1" >';
            echo "building" . '</a>';
            echo '</li>';

            echo '<li class="li-content">';
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id6=6&page=1" >';
            echo "wander" . '</a>';
            echo '</li>';

        $pdo = null;
    }
    catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
function outputPaintings2(){
    try {
        if(isset($_GET['id7']) && $_GET['id7'] > 0) {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id7 = $_GET['id7'];
            $sql = "select * from travelimage where Content = 'scenery'";
            $result = $pdo->query($sql);

            while ($row = $result->fetch()) {
                $array[] = "<a href='photo.php?id=".$row["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row["PATH"]."'></a>";
            }
            if (isset($array)) {
                draw($array);
            }
            else echo '<h3>没有图片</h3>';
            $pdo = null;
        }
        if(isset($_GET['id5']) && $_GET['id5'] > 0) {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id5 = $_GET['id5'];
            $sql5 = "select * from travelimage where Content = 'building'";
            $result5 = $pdo->query($sql5);

            while ($row5 = $result5->fetch()) {
                $array[] = "<a href='photo.php?id=".$row5["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row5["PATH"]."'></a>";
            }
            if (isset($array)) {
                draw($array);
            }
            else echo '<h3>没有图片</h3>';
            $pdo = null;
        }
        if(isset($_GET['id6']) && $_GET['id6'] > 0) {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id6 = $_GET['id6'];
            $sql6 = "select * from travelimage where Content = 'wander'";
            $result6 = $pdo->query($sql6);

            while ($row6 = $result6->fetch()) {
                $array[] = "<a href='photo.php?id=".$row6["ImageID"]."'><img src='../../img/travel-images/square-medium/" .$row6["PATH"]."'></a>";
            }
            if (isset($array)) {
                draw($array);
            }
            else echo '<h3>没有图片</h3>';
            $pdo = null;
        }
    }catch(PDOException $e) {
        die( $e->getMessage() );
    }
}

/*
 Displays the list of paintings for the artist id specified in the id query string
*/
function draw($array){
    $pages = min(count($array)/12,5);
    if (isset($_GET["id7"])){
    $id = $_GET["id7"];
    }elseif (isset($_GET["id5"])){
        $id = $_GET["id5"];
    }
    elseif (isset($_GET["id6"])){
        $id = $_GET["id6"];
    }
    echo "<div>";
    if ($array==null){
        echo "<b>没有图片</b>";
    }
    elseif (isset($_GET["page"])&&$page = $_GET["page"]){
        if ($page>=0&&$page<=1){
            $page=1;
        }
        for ($i = 0;$i<min(12,count($array)-12*($page-1));$i++){
            echo $array[12*($page-1)+$i];
        }
        if ($pages>0) {
            echo "<h4>";
            echo "<div class='transform-line'>";
            $previous = $page + $pages;
            echo "<div class='pageFoot'>" . "<a href='Browser.php?id$id=$id&page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous)) . "'><<</a>" . "&nbsp;&nbsp;&nbsp;";
            for ($p = 1; $p <= $pages; $p++){
                if ($p == $page)
                    echo "<span class='currentPage'>$p</span>&nbsp;&nbsp;&nbsp;";
                else
                    echo "<a href='Browser.php?id$id=$id&page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
            }
            $next = $page + 1;
            echo "<a href='Browser.php?id$id=$id&page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>>></a>";
            echo "</div>";
            echo "</h4>";
        }
    }
    else
        header("Refresh:0.1;url=Browser.php?id'$id'='$id'page=1");
    echo "</div>";
}
function draw1($array){
    $pages = min(count($array)/12,5);
    $id = $_GET["id1"];
    echo "<div>";
    if ($array==null){
        echo "<b>没有图片</b>";
    }
    elseif(isset($_GET["page"])&&$page = $_GET["page"]){
        if ($page>=0&&$page<=1){
            $page=1;
        }
        for ($i = 0;$i<min(12,count($array)-12*($page-1));$i++){
            echo $array[12*($page-1)+$i];
        }
        if ($pages>0) {
            echo "<h4>";
            echo "<div class='transform-line'>";
            $previous = $page + $pages;
            echo "<div class='pageFoot'>" . "<a href='Browser.php?id1=$id&page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous)) . "'><<</a>" . "&nbsp;&nbsp;&nbsp;";
            for ($p = 1; $p <= $pages; $p++) {
                if ($p == $page)
                    echo "<span class='currentPage'>$p</span>&nbsp;&nbsp;&nbsp;";
                else
                    echo "<a href='Browser.php?id1=$id&page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
            }
            $next = $page + 1;
            $next1 = ($next % ($pages + 1) + floor($next / ($pages + 1)));
            if ($next1>=0&&$next1<=1){
                $next1=1;
            }
            echo "<a href='Browser.php?id1=$id&page=" . $next1 . "'>>></a>";
            echo "</div>";
            echo "</h4>";
        }
    }
    else
        header("Refresh:0.1;url=Browser.php?id1='$id'&page=1");
    echo "</div>";
}
function draw2($array){
    $pages = min(count($array)/12,5);
    $id = $_GET["id2"];
    echo "<div>";
    if ($array==null){
        echo "<b>没有图片</b>";
    }
    elseif (isset($_GET["page"])&&$page = $_GET["page"]){
        if ($page>=0&&$page<=1){
            $page=1;
        }
        for ($i = 0;$i<min(12,count($array)-12*($page-1));$i++){
            echo $array[12*($page-1)+$i];
        }
        if ($pages>0) {
            echo "<h4>";
            echo "<div class='transform-line'>";
            $previous = $page + $pages;
            echo "<div class='pageFoot'>" . "<a href='Browser.php?id2=$id&page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous)) . "'><<</a>" . "&nbsp;&nbsp;&nbsp;";
            for ($p = 1; $p <= $pages; $p++) {
                if ($p == $page)
                    echo "<span class='currentPage'>$p</span>&nbsp;&nbsp;&nbsp;";
                else
                    echo "<a href='Browser.php?id2=$id&page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
            }
            $next = $page + 1;
            echo "<a href='Browser.php?id2=$id&page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>>></a>";
            echo "</div>";
            echo "</h4>";
        }
    }
    else
        header("Refresh:0.1;url=Browser.php?id2='$id'&page=1");
    echo "</div>";
}
?>

</div>
</body>
</html>