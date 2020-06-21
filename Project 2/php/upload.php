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
        $name = $_POST['myFile'];//得到传输的数据
//得到文件名称
        $topic = $_POST["topic"];
        if ($title==""||$description==""||$country==""||$city==""){
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "请完善图片信息后再上传！" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "upload.php" . "\"" . "</script>";
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
            while ($num1 = mysqli_fetch_array($result1)){
                if ($city==$num1["AsciiName"]){
                    $cityCode = $num1["GeoNameID"];
                }
            }
            $idMath = 1;
            $sql_select2 = "select * from travelimage order by ImageID";
            $result2 = mysqli_query($conn, $sql_select2);
            while ( $num2 = mysqli_fetch_array($result2)){
                if ($num2["ImageID"]>=$idMath){
                    $idMath = $num2["ImageID"];
                }
            }
            $idMath+=1;
            if ($cityCode==""){
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "国家与城市输入错误！" . "\"" . ")" . ";" . "</script>";
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "upload.php" . "\"" . "</script>";
                exit;
            }
            else{
                $sql_insert = "insert into travelimage(ImageID,Title,Description,cityCode,CountryCodeISO,PATH,Content) values('$idMath','$title','$description','$cityCode','$cityOfCountry','$name','$topic')";
                //插入数据
                $ret = mysqli_query($conn, $sql_insert);
                header("Location:my_photo.php?id=82&page=1");
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
    <title>上传</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="../css/upload.css"/>
    <script type="text/javascript">
        function change() {
            var pic = document.getElementById("preview"),
                file = document.getElementById("file");
            //得到后缀名
            var ext=file.value.substring(file.value.lastIndexOf(".")+1).toLowerCase();
            // gif在IE浏览器暂时无法显示
            if(ext!='png'&&ext!='jpg'&&ext!='jpeg'){
                alert("图片的格式必须为png或者jpg或者jpeg格式！");
                return;
            }
            var isIE = navigator.userAgent.match(/MSIE/)!= null,
                isIE6 = navigator.userAgent.match(/MSIE 6.0/)!= null;

            if(isIE) {
                file.select();
                var reallocalpath = document.selection.createRange().text;

                // IE6浏览器设置img的src为本地路径可以直接显示图片
                if (isIE6) {
                    pic.src = reallocalpath;
                }else {
                    // 非IE6版本的IE由于安全问题直接设置img的src无法显示本地图片，但是可以通过滤镜来实现
                    pic.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='image',src=\"" + reallocalpath + "\")";
                    // 设置img的src为base64编码的透明图片 取消显示浏览器默认图片
                    pic.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
                }
            }else {
                html5Reader(file);
            }
        }

        function html5Reader(file){
            var file = file.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var pic = document.getElementById("preview");
                pic.src=this.result;
            }
        }
        function sel(obj){
            $.get("select.php",{province:obj.options[obj.selectedIndex].value},function(json){
                var city = $("#city");
                $("option",city).remove(); //清空原有的选项
                $.each(json,function(index,array){
                    //alert(array.cityid);
                    var option = "<option value='"+array.cityid+"'>"+array.city+"</option>";
                    city.append(option);
                });
            },'json');
        }
    </script>
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
    <h4>上传</h4>
<form method="post" name="form1">
    <div class="upload-photo">
        <img id="preview" alt="图片未上传" src="" name="pic" class="file_img" />
        <input type="file" multiple id="file" name="myFile" onchange="change()">
    </div>
    <div class="upload-input">
    图片标题：
    <br>
    <textarea class="upload-textarea1" name="title"></textarea>
    <br>
    图片描述：
    <br>
    <textarea class="upload-textarea2" name="description"></textarea>
    <br>
    拍摄国家：
    <br>
    <textarea class="upload-textarea3" name="country"></textarea>
    <br>
    拍摄城市：
    <br>
    <textarea class="upload-textarea4" name="city"></textarea>
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
    <a href="my_photo.php"><input type="submit" name="submit" value="上传" ></a>
    </div>
</form>
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
        return "<form method='post' action='upload.php'>
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

?>
